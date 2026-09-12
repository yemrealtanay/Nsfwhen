<?php

namespace Tests\Feature;

use App\Models\Badge;
use App\Models\Film;
use App\Models\Scene;
use App\Models\User;
use Database\Seeders\BadgeSeeder;
use Tests\TestCase;

class VotingAndReputationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(BadgeSeeder::class);
    }

    public function test_users_can_vote_confirm_and_dispute(): void
    {
        $submitter = User::factory()->create();
        $voter = User::factory()->create();
        $film = Film::create(['tmdb_id' => 111, 'title' => 'Vote Film', 'runtime_minutes' => 90]);

        $scene = Scene::create([
            'film_id' => $film->id,
            'submitted_by' => $submitter->id,
            'start_time_seconds' => 60,
            'end_time_seconds' => 120,
            'category' => 'nudity',
        ]);

        // 1. Confirm vote
        $response = $this->actingAs($voter)->postJson(route('scenes.vote', $scene), [
            'vote_type' => 'confirm',
        ]);
        $response->assertOk();
        $response->assertJsonPath('confirm_votes', 1);
        $response->assertJsonPath('user_vote', 'confirm');

        // 2. Switch to dispute vote
        $response2 = $this->actingAs($voter)->postJson(route('scenes.vote', $scene), [
            'vote_type' => 'dispute',
        ]);
        $response2->assertOk();
        $response2->assertJsonPath('confirm_votes', 0);
        $response2->assertJsonPath('dispute_votes', 1);
        $response2->assertJsonPath('user_vote', 'dispute');
    }

    public function test_editor_approval_awards_reputation_and_first_mark_badge(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);
        $submitter = User::factory()->create(['reputation_score' => 0]);
        $film = Film::create(['tmdb_id' => 222, 'title' => 'Reputation Film', 'runtime_minutes' => 100]);

        $scene = Scene::create([
            'film_id' => $film->id,
            'submitted_by' => $submitter->id,
            'start_time_seconds' => 300,
            'end_time_seconds' => 400,
            'category' => 'sex_scene',
            'verification_status' => 'unverified',
        ]);

        $this->actingAs($editor)->post(route('editor.scenes.approve', $scene));

        $scene->refresh();
        $this->assertEquals('verified', $scene->verification_status);
        $this->assertEquals($editor->id, $scene->reviewed_by);

        $submitter->refresh();
        $this->assertEquals(10, $submitter->reputation_score);

        // Submitter should have received the 'first_mark' badge
        $this->assertTrue($submitter->badges()->where('key', 'first_mark')->exists());
    }

    public function test_editor_rejection_penalizes_reputation(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);
        $submitter = User::factory()->create(['reputation_score' => 50]);
        $film = Film::create(['tmdb_id' => 333, 'title' => 'Penalty Film', 'runtime_minutes' => 100]);

        $scene = Scene::create([
            'film_id' => $film->id,
            'submitted_by' => $submitter->id,
            'start_time_seconds' => 100,
            'end_time_seconds' => 200,
            'category' => 'suggestive',
            'verification_status' => 'unverified',
        ]);

        $this->actingAs($editor)->post(route('editor.scenes.reject', $scene));

        $scene->refresh();
        $this->assertEquals('rejected', $scene->verification_status);

        $submitter->refresh();
        $this->assertEquals(35, $submitter->reputation_score);
    }
}
