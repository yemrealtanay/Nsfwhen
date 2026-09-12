<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Tests\TestCase;

class SceneSubmissionTest extends TestCase
{
    public function test_authenticated_user_can_submit_valid_scene_mark(): void
    {
        $user = User::factory()->create();
        $film = Film::create([
            'tmdb_id' => 12345,
            'title' => 'Test Film',
            'runtime_minutes' => 120,
        ]);

        $response = $this->actingAs($user)->postJson(route('scenes.store', $film), [
            'start_time' => '00:15:30',
            'end_time' => '00:17:45',
            'category' => 'sex_scene',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);

        $this->assertDatabaseHas('scenes', [
            'film_id' => $film->id,
            'submitted_by' => $user->id,
            'start_time_seconds' => 930,
            'end_time_seconds' => 1065,
            'category' => 'sex_scene',
            'verification_status' => 'unverified',
        ]);

        $film->refresh();
        $this->assertNotNull($film->last_submission_at);
    }

    public function test_invalid_timestamps_fail_validation(): void
    {
        $user = User::factory()->create();
        $film = Film::create([
            'tmdb_id' => 12345,
            'title' => 'Test Film',
            'runtime_minutes' => 120,
        ]);

        // end time before start time
        $response = $this->actingAs($user)->postJson(route('scenes.store', $film), [
            'start_time' => '00:20:00',
            'end_time' => '00:19:00',
            'category' => 'nudity',
        ]);

        $response->assertStatus(422);
    }

    public function test_unauthenticated_user_cannot_submit_scenes(): void
    {
        $film = Film::create([
            'tmdb_id' => 12345,
            'title' => 'Test Film',
            'runtime_minutes' => 120,
        ]);

        $response = $this->postJson(route('scenes.store', $film), [
            'start_time' => '00:10:00',
            'end_time' => '00:11:00',
            'category' => 'suggestive',
        ]);

        $response->assertStatus(401);
    }
}
