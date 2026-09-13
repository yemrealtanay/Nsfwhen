<?php

namespace App\Services;

use App\Models\Film;
use App\Models\Scene;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VideoSkipService
{
    /**
     * Map VideoSkip / MCF raw category strings to NSFWhen's 3 core categories.
     */
    public function mapCategory(string $rawCategory): ?string
    {
        $normalized = strtolower(trim($rawCategory));

        // Clean out extra qualifiers or numbers like "sex 3", "nudity blur"
        $parts = preg_split('/[\s\(\)\[\]\-]+/', $normalized);
        $primary = $parts[0] ?? '';

        if (in_array($primary, ['sex', 'sex_scene', 'intercourse', 'sodomy', 'rape', 'pornography', 'intimate', 'coitus'])) {
            return 'sex_scene';
        }

        if (in_array($primary, ['nud', 'nudity', 'naked', 'topless', 'frontal', 'bare', 'buttocks', 'breasts', 'partial_nudity'])) {
            return 'nudity';
        }

        if (in_array($primary, ['sugg', 'suggestive', 'erotic', 'kiss', 'kissing', 'sensual', 'provocative', 'foreplay', 'groping', 'makeout'])) {
            return 'suggestive';
        }

        // Check if secondary parts contain sex/nudity keywords
        foreach ($parts as $p) {
            if (in_array($p, ['sex', 'intercourse'])) {
                return 'sex_scene';
            }
            if (in_array($p, ['nudity', 'naked'])) {
                return 'nudity';
            }
            if (in_array($p, ['suggestive', 'erotic', 'kissing'])) {
                return 'suggestive';
            }
        }

        // Other VideoSkip categories (violence, curse, booze, scare) are safely ignored
        return null;
    }

    /**
     * Parse a .skp file content into structured scenes and metadata.
     *
     * @return array{metadata: array, scenes: array<int, array{start_time_seconds: int, end_time_seconds: int, category: string, raw_text: string, action: string, severity: int}>}
     */
    public function parseSkp(string $content): array
    {
        $metadata = [
            'title' => null,
            'year' => null,
            'tmdb_id' => null,
            'offsets' => ['local' => 0],
        ];

        // Extract JSON offsets block if present at end or middle
        if (preg_match('/\{[\s\S]*?"(?:local|offset|netflix|prime)"[\s\S]*?\}/i', $content, $jsonMatch)) {
            $decoded = json_decode($jsonMatch[0], true);
            if (is_array($decoded)) {
                $metadata['offsets'] = $decoded;
            }
        }

        // Extract metadata lines (e.g. NOTE Title: ..., NOTE TMDb: ...)
        if (preg_match('/(?:NOTE|#)\s*(?:title|film)[:=]\s*([^\n\r]+)/i', $content, $m)) {
            $metadata['title'] = trim($m[1]);
        }
        if (preg_match('/(?:NOTE|#)\s*(?:year)[:=]\s*(\d{4})/i', $content, $m)) {
            $metadata['year'] = (int) $m[1];
        }
        if (preg_match('/(?:NOTE|#)\s*(?:tmdb|tmdb_id)[:=]\s*(\d+)/i', $content, $m)) {
            $metadata['tmdb_id'] = (int) $m[1];
        }

        $scenes = [];
        // Split WebVTT cues by double newlines
        $blocks = preg_split('/\r?\n\s*\r?\n/', trim($content));

        foreach ($blocks as $block) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $block))));
            if (count($lines) < 2) {
                continue;
            }

            // Find line containing "-->"
            $tsIndex = -1;
            foreach ($lines as $idx => $line) {
                if (str_contains($line, '-->')) {
                    $tsIndex = $idx;
                    break;
                }
            }

            if ($tsIndex === -1) {
                continue;
            }

            $tsLine = $lines[$tsIndex];
            $parts = explode('-->', $tsLine);
            if (count($parts) !== 2) {
                continue;
            }

            $startSeconds = $this->parseHmsToSeconds(trim($parts[0]));
            $endSeconds = $this->parseHmsToSeconds(trim($parts[1]));

            if ($startSeconds === null || $endSeconds === null || $endSeconds <= $startSeconds) {
                continue;
            }

            // Text line describing the skip cue
            $descLine = $lines[$tsIndex + 1] ?? '';
            $category = $this->mapCategory($descLine);

            if (! $category) {
                // Not a sexual / nudity category (e.g. violence or profanity)
                continue;
            }

            // Detect action (skip, blur, mute)
            $action = 'skip';
            if (stripos($descLine, 'blur') !== false) {
                $action = 'blur';
            } elseif (stripos($descLine, 'mute') !== false) {
                $action = 'mute';
            }

            // Detect severity (1 to 4)
            $severity = 3;
            if (preg_match('/\b([1-4])\b/', $descLine, $sm)) {
                $severity = (int) $sm[1];
            }

            $scenes[] = [
                'start_time_seconds' => (int) round($startSeconds),
                'end_time_seconds' => (int) round($endSeconds),
                'category' => $category,
                'raw_text' => $descLine,
                'action' => $action,
                'severity' => $severity,
            ];
        }

        return [
            'metadata' => $metadata,
            'scenes' => $scenes,
        ];
    }

    /**
     * Generate standard VideoSkip .skp WebVTT content for a Film.
     */
    public function generateSkp(Film $film): string
    {
        $year = $film->releaseYear();
        $title = $film->title;
        $tmdbId = $film->tmdb_id;

        $lines = [];
        $lines[] = 'WEBVTT - VideoSkip Filter for '.$title.($year !== '—' ? " ({$year})" : '');
        $lines[] = 'NOTE Title: '.$title;
        if ($year !== '—') {
            $lines[] = "NOTE Year: {$year}";
        }
        if ($tmdbId) {
            $lines[] = "NOTE TMDb: {$tmdbId}";
        }
        $lines[] = 'NOTE Generator: NSFWhen.com';
        $lines[] = 'NOTE URL: '.route('films.show', $film);
        $lines[] = '';

        $scenes = $film->scenes()
            ->where('verification_status', '!=', 'rejected')
            ->orderBy('start_time_seconds')
            ->get();

        foreach ($scenes as $scene) {
            $startStr = $this->formatSecondsToHms($scene->start_time_seconds);
            $endStr = $this->formatSecondsToHms($scene->end_time_seconds);

            $action = $scene->category === 'sex_scene' ? 'skip' : 'blur';
            $severity = match ($scene->category) {
                'sex_scene' => 3,
                'nudity' => 2,
                default => 1,
            };

            $label = match ($scene->category) {
                'sex_scene' => 'sex',
                'nudity' => 'nudity',
                default => 'suggestive',
            };

            $lines[] = "{$startStr} --> {$endStr}";
            $lines[] = "{$label} {$action} {$severity} (".str_replace('_', ' ', $scene->category).')';
            $lines[] = '';
        }

        // Standard VideoSkip offset trailer
        $lines[] = '{"local":0}';
        $lines[] = '';

        return implode("\n", $lines);
    }

    /**
     * Apply parsed scenes to a Film, skipping overlaps to prevent duplicates.
     *
     * @param  array<int, array{start_time_seconds: int, end_time_seconds: int, category: string}>  $scenes
     */
    public function applyFilterToFilm(Film $film, array $scenes, ?int $submittedBy = null): int
    {
        $existingScenes = $film->scenes()->get();
        $addedCount = 0;

        foreach ($scenes as $item) {
            $start = $item['start_time_seconds'];
            $end = $item['end_time_seconds'];
            $cat = $item['category'];

            // Skip if overlapping with an existing scene (within +/- 3 seconds)
            $isDuplicate = $existingScenes->contains(function ($existing) use ($start, $end) {
                return abs($existing->start_time_seconds - $start) <= 4 &&
                       abs($existing->end_time_seconds - $end) <= 4;
            });

            if ($isDuplicate) {
                continue;
            }

            $newScene = Scene::create([
                'film_id' => $film->id,
                'start_time_seconds' => $start,
                'end_time_seconds' => $end,
                'category' => $cat,
                'verification_status' => 'unverified',
                'submitted_by' => $submittedBy,
            ]);

            $existingScenes->push($newScene);
            $addedCount++;
        }

        return $addedCount;
    }

    /**
     * Find a matching .skp file for a film in local storage.
     */
    public function findSkpFileForFilm(Film $film, string $directory = ''): ?string
    {
        $dir = ! empty($directory) ? $directory : storage_path('app/videoskip');

        if (! File::isDirectory($dir)) {
            return null;
        }

        $candidates = [
            $dir.'/'.$film->tmdb_id.'.skp',
            $dir.'/film-'.$film->id.'.skp',
            $dir.'/'.Str::slug($film->title).'-'.$film->releaseYear().'.skp',
            $dir.'/'.Str::slug($film->title).'.skp',
        ];

        foreach ($candidates as $path) {
            if (File::exists($path)) {
                return $path;
            }
        }

        // Fuzzy search through all .skp files in directory
        $files = File::glob($dir.'/*.skp');
        $filmSlug = Str::slug($film->title);

        foreach ($files as $file) {
            $baseName = strtolower(pathinfo($file, PATHINFO_FILENAME));
            $fileSlug = Str::slug($baseName);

            if (str_contains($fileSlug, $filmSlug) || str_contains($baseName, (string) $film->tmdb_id)) {
                return $file;
            }
        }

        return null;
    }

    /**
     * Automatically populate scenes for a film if a local .skp file exists.
     */
    public function autoPopulateScenes(Film $film, string $directory = ''): int
    {
        $filePath = $this->findSkpFileForFilm($film, $directory);
        if (! $filePath || ! File::exists($filePath)) {
            return 0;
        }

        try {
            $content = File::get($filePath);
            $parsed = $this->parseSkp($content);

            if (empty($parsed['scenes'])) {
                return 0;
            }

            return $this->applyFilterToFilm($film, $parsed['scenes']);
        } catch (\Throwable $e) {
            Log::warning("VideoSkip autoPopulateScenes failed for film {$film->id}: ".$e->getMessage());

            return 0;
        }
    }

    /**
     * Parse HH:MM:SS[.mmm] or MM:SS to float seconds.
     */
    public function parseHmsToSeconds(string $timeStr): ?float
    {
        $clean = str_replace(',', '.', trim($timeStr));
        $parts = explode(':', $clean);

        if (count($parts) === 3) {
            return (float) $parts[0] * 3600 + (float) $parts[1] * 60 + (float) $parts[2];
        }

        if (count($parts) === 2) {
            return (float) $parts[0] * 60 + (float) $parts[1];
        }

        if (is_numeric($clean)) {
            return (float) $clean;
        }

        return null;
    }

    /**
     * Format seconds to HH:MM:SS.mmm.
     */
    public function formatSecondsToHms(float|int $seconds): string
    {
        $hours = intdiv((int) $seconds, 3600);
        $minutes = intdiv(((int) $seconds) % 3600, 60);
        $secs = ((int) $seconds) % 60;
        $ms = (int) round(($seconds - floor($seconds)) * 1000);

        return sprintf('%02d:%02d:%02d.%03d', $hours, $minutes, $secs, $ms);
    }
}
