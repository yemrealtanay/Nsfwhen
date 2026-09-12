<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Tests\TestCase;

class AutoDelistCandidateTest extends TestCase
{
    public function test_positive_clean_votes_trigger_delist_candidate_at_threshold(): void
    {
        $film = Film::create([
            'tmdb_id' => 9999,
            'title' => 'Clean Hope Film',
            'runtime_minutes' => 95,
            'delist_status' => 'active',
            'clean_votes_count' => 0,
        ]);

        $users = User::factory()->count(5)->create();

        // Vote 4 times: should remain active
        for ($i = 0; $i < 4; $i++) {
            $this->actingAs($users[$i])->postJson(route('films.clean-vote', $film));
        }

        $film->refresh();
        $this->assertEquals(4, $film->clean_votes_count);
        $this->assertEquals('active', $film->delist_status);

        // 5th vote: reaches threshold -> moves to delist_candidate
        $this->actingAs($users[4])->postJson(route('films.clean-vote', $film));

        $film->refresh();
        $this->assertEquals(5, $film->clean_votes_count);
        $this->assertEquals('delist_candidate', $film->delist_status);
        $this->assertNull($film->clean_confirmed_at);
    }

    public function test_editor_must_confirm_before_film_is_editor_delisted(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);
        $film = Film::create([
            'tmdb_id' => 8888,
            'title' => 'Candidate Film',
            'runtime_minutes' => 110,
            'delist_status' => 'delist_candidate',
            'clean_votes_count' => 5,
        ]);

        $this->actingAs($editor)->post(route('editor.films.delist', $film));

        $film->refresh();
        $this->assertEquals('editor_delisted', $film->delist_status);
        $this->assertEquals($editor->id, $film->clean_confirmed_by);
        $this->assertNotNull($film->clean_confirmed_at);
    }
}
