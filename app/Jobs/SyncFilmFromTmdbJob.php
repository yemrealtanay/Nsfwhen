<?php

namespace App\Jobs;

use App\Models\Film;
use App\Services\TmdbService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncFilmFromTmdbJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $tmdbId,
        public ?int $filmId = null
    ) {}

    public function handle(TmdbService $tmdbService): void
    {
        $data = $tmdbService->getMovie($this->tmdbId);

        if (! $data) {
            Log::warning("Could not sync movie metadata from TMDb for ID {$this->tmdbId}");

            return;
        }

        $directors = [];
        if (! empty($data['credits']['crew'])) {
            foreach ($data['credits']['crew'] as $crew) {
                if (($crew['job'] ?? '') === 'Director') {
                    $directors[] = $crew['name'];
                }
            }
        }
        $directorStr = ! empty($directors) ? implode(', ', array_slice($directors, 0, 2)) : null;

        $castList = [];
        if (! empty($data['credits']['cast'])) {
            foreach (array_slice($data['credits']['cast'], 0, 5) as $actor) {
                $castList[] = $actor['name'];
            }
        }

        $genresList = [];
        if (! empty($data['genres'])) {
            foreach ($data['genres'] as $g) {
                $genresList[] = $g['name'];
            }
        }

        Film::updateOrCreate(
            ['tmdb_id' => $this->tmdbId],
            [
                'title' => $data['title'] ?? 'Unknown',
                'original_title' => $data['original_title'] ?? null,
                'poster_path' => $data['poster_path'] ?? null,
                'release_date' => ! empty($data['release_date']) ? $data['release_date'] : null,
                'runtime_minutes' => (int) ($data['runtime'] ?? 0),
                'genres' => $genresList,
                'director' => $directorStr,
                'cast' => $castList,
                'overview' => $data['overview'] ?? null,
            ]
        );
    }
}
