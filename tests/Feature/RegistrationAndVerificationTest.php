<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegistrationAndVerificationTest extends TestCase
{
    public function test_registration_validates_password_strength(): void
    {
        // Simple password without numbers
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'onlyletters',
            'password_confirmation' => 'onlyletters',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'johndoe@example.com']);
    }

    public function test_registration_creates_user_and_redirects_to_verification_notice(): void
    {
        Event::fake([Registered::class]);

        $response = $this->post(route('register'), [
            'name' => 'Jane Contributor',
            'email' => 'jane@example.com',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
        $response->assertRedirect(route('verification.notice'));
        Event::assertDispatched(Registered::class);
    }

    public function test_unverified_user_cannot_submit_scenes(): void
    {
        $user = User::factory()->unverified()->create();
        $film = Film::create([
            'tmdb_id' => 998877,
            'title' => 'Unverified Test Film',
            'runtime_minutes' => 100,
        ]);

        $response = $this->actingAs($user)->post(route('scenes.store', $film), [
            'start_time' => '00:10:00',
            'end_time' => '00:12:00',
            'category' => 'sex_scene',
        ]);

        // Verified middleware redirects to verification.notice for web requests or 403 for json
        $response->assertRedirect(route('verification.notice'));
        $this->assertDatabaseMissing('scenes', ['film_id' => $film->id]);
    }

    public function test_user_can_verify_email_via_signed_url(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('onboarding'));
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
