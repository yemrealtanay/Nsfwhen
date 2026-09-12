<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use App\Services\TmdbService;
use Mockery;
use Tests\TestCase;

class TmdbPullRangeAndImportTest extends TestCase
{
    public function test_tmdb_pull_range_command_fetches_and_skips_duplicates(): void
    {
        // Pre-create one film to verify duplicate skipping
        Film::create([
            'tmdb_id' => 101,
            'title' => 'Existing Film 2020',
            'runtime_minutes' => 100,
        ]);

        $mockTmdb = Mockery::mock(TmdbService::class);

        // Expect discoverPopular for year 2020, page 1
        $mockTmdb->shouldReceive('discoverPopular')
            ->once()
            ->with(2020, 1, 50)
            ->andReturn([
                'page' => 1,
                'total_pages' => 1,
                'results' => [
                    ['id' => 101, 'title' => 'Existing Film 2020'],
                    ['id' => 102, 'title' => 'New Film 2020'],
                ],
            ]);

        // Details for the new movie 102
        $mockTmdb->shouldReceive('getMovie')
            ->once()
            ->with(102)
            ->andReturn([
                'id' => 102,
                'title' => 'New Film 2020',
                'release_date' => '2020-05-15',
                'runtime' => 110,
                'overview' => 'Sample overview',
                'genres' => [['id' => 18, 'name' => 'Drama']],
                'credits' => ['crew' => [], 'cast' => []],
            ]);

        $this->app->instance(TmdbService::class, $mockTmdb);

        $this->artisan('tmdb:pull-range', [
            '--start' => 2020,
            '--end' => 2020,
            '--pages' => 1,
            '--min-votes' => 50,
            '--delay' => 0,
        ])
            ->expectsOutputToContain('HASAT RAPORU')
            ->expectsOutputToContain('Yeni Eklenen: 1')
            ->expectsOutputToContain('Zaten Kayıtlı (Duplicate önlendi): 1')
            ->assertSuccessful();

        $this->assertDatabaseHas('films', [
            'tmdb_id' => 102,
            'title' => 'New Film 2020',
        ]);
    }

    public function test_editor_can_search_and_import_film_from_tmdb(): void
    {
        $editor = User::factory()->create([
            'is_editor' => true,
            'email_verified_at' => now(),
        ]);

        $mockTmdb = Mockery::mock(TmdbService::class);
        $mockTmdb->shouldReceive('search')
            ->once()
            ->with('The Substance')
            ->andReturn([
                'results' => [
                    [
                        'id' => 933260,
                        'title' => 'The Substance',
                        'original_title' => 'The Substance',
                        'release_date' => '2024-09-07',
                        'poster_path' => '/lqoMzCcZYEFK729Fc6rKWZzAc4e.jpg',
                        'overview' => 'A fading celebrity takes a black-market drug.',
                    ],
                ],
            ]);

        $mockTmdb->shouldReceive('getMovie')
            ->once()
            ->with(933260)
            ->andReturn([
                'id' => 933260,
                'title' => 'The Substance',
                'original_title' => 'The Substance',
                'release_date' => '2024-09-07',
                'runtime' => 141,
                'overview' => 'A fading celebrity takes a black-market drug.',
                'genres' => [['id' => 27, 'name' => 'Horror']],
                'credits' => [
                    'crew' => [['name' => 'Coralie Fargeat', 'job' => 'Director']],
                    'cast' => [['name' => 'Demi Moore']],
                ],
            ]);

        $this->app->instance(TmdbService::class, $mockTmdb);

        // 1. Editor searches TMDb in editor dashboard
        $response = $this->actingAs($editor)->get(route('editor.dashboard', [
            'tab' => 'import',
            'q' => 'The Substance',
        ]));

        $response->assertOk();
        $response->assertSee('The Substance');
        $response->assertSee('A fading celebrity takes a black-market drug');

        // 2. Editor imports the movie
        $importResponse = $this->actingAs($editor)->post(route('editor.films.import'), [
            'tmdb_id' => 933260,
        ]);

        $importedFilm = Film::where('tmdb_id', 933260)->first();
        $this->assertNotNull($importedFilm);
        $this->assertEquals('The Substance', $importedFilm->title);
        $this->assertEquals('Coralie Fargeat', $importedFilm->director);
        $this->assertContains('Demi Moore', $importedFilm->cast);

        $importResponse->assertRedirect(route('films.show', $importedFilm->id));
        $importResponse->assertSessionHas('success');
    }

    public function test_non_editor_cannot_import_films(): void
    {
        $regularUser = User::factory()->create([
            'is_editor' => false,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($regularUser)->post(route('editor.films.import'), [
            'tmdb_id' => 933260,
        ]);

        $response->assertForbidden();
    }
}
