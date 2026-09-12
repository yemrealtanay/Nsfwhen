<?php

namespace App\Console\Commands;

use App\Jobs\SyncFilmFromTmdbJob;
use App\Models\Film;
use App\Services\TmdbService;
use Illuminate\Console\Command;

class PullRangeFilmsCommand extends Command
{
    protected $signature = 'tmdb:pull-range
                            {--start=2020 : Start release year (e.g. 2020)}
                            {--end=2026 : End release year (e.g. 2026)}
                            {--pages=5 : Number of pages to pull per year (20 movies/page)}
                            {--min-votes=50 : Minimum TMDb vote count filter}
                            {--delay=300 : Courtesy delay in milliseconds between movie detail fetches}
                            {--force : Force re-fetch even if film already exists in DB}';

    protected $description = 'Batch pull popular films across a range of years (2020-2026) with rate limiting, progress display, and duplicate protection';

    public function handle(TmdbService $tmdb): int
    {
        $startYear = (int) $this->option('start');
        $endYear = (int) $this->option('end');
        $pages = (int) $this->option('pages');
        $minVotes = (int) $this->option('min-votes');
        $delayMs = (int) $this->option('delay');
        $force = (bool) $this->option('force');

        if ($startYear > $endYear) {
            $this->error("Start year ({$startYear}) cannot be greater than end year ({$endYear}).");

            return self::FAILURE;
        }

        $years = range($startYear, $endYear);
        $totalYears = count($years);
        $approxMovies = $totalYears * $pages * 20;

        $this->info('================================================================================');
        $this->info(" NSFWhen TMDb Harvester: Years {$startYear} to {$endYear} ({$pages} pages/yr, max ~{$approxMovies} films)");
        $this->info(" Rate limit courtesy delay: {$delayMs}ms between API requests");
        $this->info('================================================================================');
        $this->newLine();

        $grandTotalFound = 0;
        $grandTotalAdded = 0;
        $grandTotalSkipped = 0;
        $grandTotalFailed = 0;

        $yearSummary = [];

        foreach ($years as $yearIdx => $year) {
            $this->line('<fg=cyan;options=bold>[Year '.($yearIdx + 1)."/{$totalYears}] Scanning {$year} (Pages 1..{$pages})...</>");

            $yearFound = 0;
            $yearAdded = 0;
            $yearSkipped = 0;
            $yearFailed = 0;

            for ($page = 1; $page <= $pages; $page++) {
                $this->line("  Fetching page {$page}/{$pages} from TMDb...");
                $data = $tmdb->discoverPopular($year, $page, $minVotes);
                $movies = $data['results'] ?? [];

                if (empty($movies)) {
                    $this->warn("    No more films found for {$year} on page {$page}. Moving to next year.");
                    break;
                }

                $bar = $this->output->createProgressBar(count($movies));
                $bar->setFormat('    %current%/%max% [%bar%] %percent:3s%% -- %message%');
                $bar->setMessage('Başlatılıyor...');
                $bar->start();

                foreach ($movies as $movie) {
                    $yearFound++;
                    $grandTotalFound++;
                    $tmdbId = (int) $movie['id'];
                    $title = $movie['title'] ?? 'Unknown';

                    $exists = Film::where('tmdb_id', $tmdbId)->exists();

                    if ($exists && ! $force) {
                        $yearSkipped++;
                        $grandTotalSkipped++;
                        $bar->setMessage('<fg=yellow>ATLANDI:</> '.mb_substr($title, 0, 30));
                        $bar->advance();

                        continue;
                    }

                    $bar->setMessage('<fg=green>İNDİRİLİYOR:</> '.mb_substr($title, 0, 30));

                    try {
                        SyncFilmFromTmdbJob::dispatchSync($tmdbId);
                        $yearAdded++;
                        $grandTotalAdded++;
                    } catch (\Throwable $e) {
                        $yearFailed++;
                        $grandTotalFailed++;
                        $this->warn(" [Hata] {$title}: ".$e->getMessage());
                    }

                    $bar->advance();

                    // Rate limit courtesy delay
                    if ($delayMs > 0) {
                        usleep($delayMs * 1000);
                    }
                }

                $bar->setMessage('<fg=green>Tamamlandı</>');
                $bar->finish();
                $this->newLine();

                // Brief pause between pages
                usleep(400000);
            }

            $yearSummary[] = [
                'Year' => $year,
                'Found' => $yearFound,
                'New Added' => $yearAdded,
                'Already in DB' => $yearSkipped,
                'Failed' => $yearFailed,
            ];

            $this->line("  <fg=green;options=bold>✓ {$year} tamamlandı:</> {$yearAdded} yeni eklendi, {$yearSkipped} zaten mevcuttu.");
            $this->newLine();
        }

        $this->newLine();
        $this->info('================================================================================');
        $this->info(' HASAT RAPORU (SUMMARY)');
        $this->info('================================================================================');
        $this->table(['Year', 'Scanned', 'New Added', 'Already in DB', 'Failed'], $yearSummary);

        $totalInDbNow = Film::count();
        $this->newLine();
        $this->info('Genel Toplam:');
        $this->line(" - Taranan: <fg=cyan>{$grandTotalFound}</>");
        $this->line(" - Yeni Eklenen: <fg=green;options=bold>{$grandTotalAdded}</>");
        $this->line(" - Zaten Kayıtlı (Duplicate önlendi): <fg=yellow>{$grandTotalSkipped}</>");
        if ($grandTotalFailed > 0) {
            $this->line(" - Başarısız: <fg=red>{$grandTotalFailed}</>");
        }
        $this->line(" - Veritabanındaki Toplam Film Sayısı: <fg=green;options=bold>{$totalInDbNow}</>");
        $this->newLine();

        return self::SUCCESS;
    }
}
