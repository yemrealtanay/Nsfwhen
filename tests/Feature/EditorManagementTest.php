<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\BadgeSeeder;
use Database\Seeders\InitialEditorSeeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EditorManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(BadgeSeeder::class);
    }

    public function test_initial_editor_seeder_creates_master_account(): void
    {
        Config::set('nsfwhen.initial_editor.email', 'master@example.com');
        Config::set('nsfwhen.initial_editor.name', 'master');
        Config::set('nsfwhen.initial_editor.password', 'MasterSecret123');

        $this->seed(InitialEditorSeeder::class);

        $user = User::where('email', 'master@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('master', $user->name);
        $this->assertTrue($user->is_editor);
        $this->assertTrue($user->hasVerifiedEmail());
        $this->assertTrue(Hash::check('MasterSecret123', $user->password));
    }

    public function test_init_editor_command_creates_or_promotes_editor(): void
    {
        $this->artisan('app:init-editor', [
            '--email' => 'cli-editor@example.com',
            '--name' => 'CLI Admin',
            '--password' => 'SafePass123!',
        ])->assertExitCode(0);

        $editor = User::where('email', 'cli-editor@example.com')->first();
        $this->assertNotNull($editor);
        $this->assertTrue($editor->is_editor);
        $this->assertTrue($editor->hasVerifiedEmail());
    }

    public function test_promote_editor_command_promotes_existing_user(): void
    {
        $user = User::factory()->create(['is_editor' => false]);

        $this->artisan('app:promote-editor', [
            'email' => $user->email,
        ])->assertExitCode(0);

        $user->refresh();
        $this->assertTrue($user->is_editor);
        $this->assertTrue($user->hasVerifiedEmail());
    }

    public function test_editor_can_view_users_tab_and_search(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);
        $targetUser = User::factory()->create(['name' => 'JohnUniqueDoe', 'is_editor' => false]);

        $response = $this->actingAs($editor)->get(route('editor.dashboard', ['tab' => 'users']));
        $response->assertOk();
        $response->assertSee(__('editor.users_management'));
        $response->assertSee($targetUser->name);

        // Search test
        $searchResponse = $this->actingAs($editor)->get(route('editor.dashboard', ['tab' => 'users', 'search' => 'JohnUnique']));
        $searchResponse->assertOk();
        $searchResponse->assertSee($targetUser->name);
    }

    public function test_editor_can_promote_and_demote_another_user(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);
        $targetUser = User::factory()->create(['is_editor' => false]);

        // 1. Promote to editor
        $resPromote = $this->actingAs($editor)->post(route('editor.users.toggle-role', $targetUser));
        $resPromote->assertRedirect();
        $targetUser->refresh();
        $this->assertTrue($targetUser->is_editor);
        $this->assertTrue($targetUser->hasVerifiedEmail());

        // 2. Demote from editor
        $resDemote = $this->actingAs($editor)->post(route('editor.users.toggle-role', $targetUser));
        $resDemote->assertRedirect();
        $targetUser->refresh();
        $this->assertFalse($targetUser->is_editor);
    }

    public function test_editor_cannot_demote_themselves(): void
    {
        $editor = User::factory()->create(['is_editor' => true]);

        $response = $this->actingAs($editor)->post(route('editor.users.toggle-role', $editor));
        $response->assertRedirect();
        $response->assertSessionHas('error', __('editor.cannot_modify_own_role'));

        $editor->refresh();
        $this->assertTrue($editor->is_editor);
    }

    public function test_non_editor_cannot_access_or_modify_roles(): void
    {
        $regularUser = User::factory()->create(['is_editor' => false]);
        $targetUser = User::factory()->create(['is_editor' => false]);

        $resGet = $this->actingAs($regularUser)->get(route('editor.dashboard', ['tab' => 'users']));
        $resGet->assertForbidden();

        $resPost = $this->actingAs($regularUser)->post(route('editor.users.toggle-role', $targetUser));
        $resPost->assertForbidden();
    }
}
