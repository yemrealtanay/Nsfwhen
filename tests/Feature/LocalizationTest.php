<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_can_switch_locale_via_route(): void
    {
        $response = $this->get(route('locale.switch', 'en'));
        $response->assertSessionHas('locale', 'en');

        $responseTr = $this->get(route('locale.switch', 'tr'));
        $responseTr->assertSessionHas('locale', 'tr');
    }

    public function test_switching_locale_updates_authenticated_user_preference(): void
    {
        $user = User::factory()->create(['locale' => 'tr']);

        $this->actingAs($user)->get(route('locale.switch', 'en'));

        $user->refresh();
        $this->assertEquals('en', $user->locale);
    }

    public function test_default_locale_is_english_for_guests(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertOk();
        $this->assertEquals('en', app()->getLocale());
        $response->assertSee('Know');
        $response->assertSee('when');
    }
}
