<?php

namespace App\Console\Commands;

use App\Jobs\SyncFilmFromTmdbJob;
use App\Models\Film;
use App\Services\TmdbService;
use Illuminate\Console\Command;

class SyncPopularFilmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:sync-popular 
                            {--year=2024 : Primary release year (e.g. 2024, 2025)} 
                            {--pages=2 : Number of pages to fetch (20 movies per page)} 
                            {--min-votes=100 : Minimum TMDb vote count filter}
                            {--force : Force re-sync metadata even if film is already indexed}
                            {--sync : Run detail syncing synchronously instead of queuing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batch ingest popular theatrical and streaming films for a given year from TMDb';

    public function handle(TmdbService $tmdb): int
    {
        $year = (int) $this->option('year');
        $pages = (int) $this->option('pages');
        $minVotes = (int) $this->option('min-votes');
        $isSync = $this->option('sync');
        $force = (bool) $this->option('force');

        $this->info("Fetching popular films for year {$year} (Pages: 1..{$pages}, Min Votes: {$minVotes})...");

        $totalFound = 0;
        $totalCreated = 0;
        $totalSkipped = 0;

        for ($page = 1; $page <= $pages; $page++) {
            $this->line("<comment>Page {$page}/{$pages}...</comment>");
            $data = $tmdb->discoverPopular($year, $page, $minVotes);
            $results = $data['results'] ?? [];

            if (empty($results)) {
                $this->warn("No movies returned on page {$page}.");
                break;
            }

            foreach ($results as $movie) {
                $totalFound++;
                $tmdbId = $movie['id'];
                $title = $movie['title'] ?? 'Unknown';

                $existing = Film::where('tmdb_id', $tmdbId)->first();

                if ($existing && ! $force) {
                    $totalSkipped++;
                    $this->line("  [SKIP] {$title} (#{$tmdbId}) — already indexed.");

                    continue;
                }

                if ($isSync) {
                    SyncFilmFromTmdbJob::dispatchSync($tmdbId);
                    usleep(250000); // 250ms rate limit courtesy
                } else {
                    SyncFilmFromTmdbJob::dispatch($tmdbId);
                }

                $totalCreated++;
                if ($existing && $force) {
                    $this->line("  [REFRESH] {$title} (#{$tmdbId}) — re-syncing metadata.");
                } else {
                    $this->info("  [QUEUED] {$title} (#{$tmdbId})");
                }
            }

            // Brief pause between page queries
            usleep(200000);
        }

        $this->newLine();
        $this->info("Summary for {$year}:");
        $this->table(
            ['Total Processed', 'New / Queued', 'Already Indexed'],
            [[$totalFound, $totalCreated, $totalSkipped]]
        );

        return self::SUCCESS;
    }
}
