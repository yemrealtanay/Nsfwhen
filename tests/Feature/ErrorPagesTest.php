<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    public function test_404_error_page_renders_with_dark_theme(): void
    {
        $response = $this->get('/non-existent-movie-url-12345');
        $response->assertNotFound();
        $response->assertSee('404');
        $response->assertSee('NSFW');
    }

    public function test_403_error_page_renders_for_unauthorized_editor_access(): void
    {
        $regularUser = User::factory()->create(['is_editor' => false]);

        $response = $this->actingAs($regularUser)->get(route('editor.dashboard'));
        $response->assertForbidden();
        $response->assertSee('403');
    }
}
