<?php

namespace Tests\Feature;

use App\Jobs\SyncFilmFromTmdbJob;
use App\Models\Film;
use App\Services\TmdbService;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class SyncPopularFilmsTest extends TestCase
{
    public function test_tmdb_sync_popular_command_fetches_and_queues_movies(): void
    {
        Queue::fake([SyncFilmFromTmdbJob::class]);

        $mockTmdb = Mockery::mock(TmdbService::class);
        $mockTmdb->shouldReceive('discoverPopular')
            ->once()
            ->with(2024, 1, 100)
            ->andReturn([
                'page' => 1,
                'total_pages' => 1,
                'results' => [
                    [
                        'id' => 888999,
                        'title' => 'Mock Blockbuster 2024',
                    ],
                ],
            ]);

        $this->app->instance(TmdbService::class, $mockTmdb);

        $this->artisan('tmdb:sync-popular', [
            '--year' => 2024,
            '--pages' => 1,
            '--min-votes' => 100,
        ])->assertSuccessful();

        Queue::assertPushed(SyncFilmFromTmdbJob::class, function ($job) {
            return $job->tmdbId === 888999;
        });
    }

    public function test_tmdb_sync_popular_skips_already_indexed_films(): void
    {
        Queue::fake([SyncFilmFromTmdbJob::class]);

        Film::create([
            'tmdb_id' => 888999,
            'title' => 'Mock Blockbuster 2024',
            'runtime_minutes' => 120,
        ]);

        $mockTmdb = Mockery::mock(TmdbService::class);
        $mockTmdb->shouldReceive('discoverPopular')
            ->once()
            ->with(2024, 1, 100)
            ->andReturn([
                'page' => 1,
                'total_pages' => 1,
                'results' => [
                    [
                        'id' => 888999,
                        'title' => 'Mock Blockbuster 2024',
                    ],
                ],
            ]);

        $this->app->instance(TmdbService::class, $mockTmdb);

        $this->artisan('tmdb:sync-popular', [
            '--year' => 2024,
            '--pages' => 1,
            '--min-votes' => 100,
        ])->assertSuccessful();

        // Should NOT push job because it is already indexed
        Queue::assertNothingPushed();
    }
}
