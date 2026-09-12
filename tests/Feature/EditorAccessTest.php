<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class EditorAccessTest extends TestCase
{
    public function test_guest_is_redirected_from_editor_dashboard(): void
    {
        $response = $this->get(route('editor.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_is_forbidden_from_editor_dashboard(): void
    {
        $user = User::factory()->create(['is_editor' => false]);

        $response = $this->actingAs($user)->get(route('editor.dashboard'));
        $response->assertStatus(403);
    }

    public function test_editor_user_can_access_editor_dashboard(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);

        $response = $this->actingAs($editor)->get(route('editor.dashboard'));
        $response->assertOk();
    }
}
