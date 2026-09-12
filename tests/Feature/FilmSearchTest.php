<?php

namespace Tests\Feature;

use App\Models\Film;
use Database\Seeders\DemoSeeder;
use Tests\TestCase;

class FilmSearchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
    }

    public function test_can_search_films_by_actor_in_cast(): void
    {
        // Create a film with Gal Gadot in cast
        $film = Film::create([
            'tmdb_id' => 999123,
            'title' => 'Heart of Stone',
            'original_title' => 'Heart of Stone',
            'release_date' => '2023-08-11',
            'runtime_minutes' => 122,
            'genres' => ['Action', 'Thriller'],
            'director' => 'Tom Harper',
            'cast' => ['Gal Gadot', 'Jamie Dornan', 'Alia Bhatt'],
            'overview' => 'An intelligence operative for a shadowy global peacekeeping agency races to stop a hacker from stealing its most dangerous weapon.',
            'delist_status' => 'active',
            'clean_votes_count' => 0,
        ]);

        // Search by full actor name
        $results = Film::search('Gal Gadot')->get();
        $this->assertTrue($results->contains('id', $film->id));

        // Search by partial actor name (lowercase)
        $resultsPartial = Film::search('gadot')->get();
        $this->assertTrue($resultsPartial->contains('id', $film->id));

        // Search via HTTP route
        $response = $this->get(route('home', ['q' => 'Gal Gadot']));
        $response->assertOk();
        $response->assertSee('Heart of Stone');
    }

    public function test_seeded_film_search_by_actor_works(): void
    {
        // Poor Things has Emma Stone, Mark Ruffalo, Willem Dafoe
        $results = Film::search('Emma Stone')->get();
        $this->assertTrue($results->contains('title', 'Poor Things'));

        $response = $this->get(route('home', ['q' => 'Willem Dafoe']));
        $response->assertOk();
        $response->assertSee('Poor Things');
    }
}
