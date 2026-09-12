<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Database\Seeders\DemoSeeder;
use Tests\TestCase;

class PageRenderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
    }

    public function test_welcome_page_renders_with_screen_1i_elements(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertOk();
        $response->assertSee('POOR THINGS · 2:21:00');
        $response->assertSee(__('welcome.how_it_works_title'));
        $response->assertSee(__('welcome.never_do_title'));
        $response->assertSee(__('welcome.clean_shelf_title'));
        $response->assertSee('tmdb_logo.png');
    }

    public function test_home_page_renders_with_seeded_films(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Poor Things');
        $response->assertSee('NSFW');
        $response->assertSee('tmdb_logo.png');
        $response->assertSee('CONTENT FILTER');
        $response->assertSee('GENRES');
        $response->assertSee('name="q"', false);
    }

    public function test_home_page_supports_different_views(): void
    {
        $grid = $this->get(route('home', ['view' => 'grid']));
        $grid->assertOk();

        $rows = $this->get(route('home', ['view' => 'rows']));
        $rows->assertOk();
        $rows->assertSee('INDEX ROWS');

        $cards = $this->get(route('home', ['view' => 'cards']));
        $cards->assertOk();
        $cards->assertSee('VERDICT CARDS');
    }

    public function test_film_detail_page_renders_with_timeline_and_facts(): void
    {
        $film = Film::where('title', 'Poor Things')->first();

        $response = $this->get(route('films.show', $film));
        $response->assertOk();
        $response->assertSee('Poor Things');
        $response->assertSee('Yorgos Lanthimos');
        $response->assertSee('timeline-mount');
        $response->assertSee(__('categories.sex_scenes_present'));
    }

    public function test_editor_dashboard_renders_for_editor(): void
    {
        $editor = User::where('email', 'editor@nsfwhen.com')->first();

        $response = $this->actingAs($editor)->get(route('editor.dashboard'));
        $response->assertOk();
        $response->assertSee(__('editor.moderation'));
        $response->assertSee(__('editor.pending_queue'));
        $response->assertSee(__('editor.delist_candidates'));
    }

    public function test_public_profile_page_renders(): void
    {
        $user = User::where('email', 'kerem_a@example.com')->first();

        $response = $this->get(route('profile.show', $user));
        $response->assertOk();
        $response->assertSee('kerem_a');
        $response->assertSee(__('messages.reputation'));
        $response->assertSee(__('messages.badges'));
    }

    public function test_onboarding_page_renders(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('onboarding'));
        $response->assertOk();
        $response->assertSee(__('messages.onboarding_title'));
    }
}
