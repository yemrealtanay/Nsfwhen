<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_terms_page_renders_in_turkish(): void
    {
        $response = $this->withSession(['locale' => 'tr'])->get(route('terms'));
        $response->assertOk();
        $response->assertSee('Kullanım Koşulları');
        $response->assertSee('1. NSFWhen Nedir');
        $response->assertSee('2. Uygunluk (Yaş Şartı)');
        $response->assertSee('10. Sorumluluğun Sınırlandırılması');
        $response->assertSee('NSFWhen Legal Team');
        $response->assertSee('legal@nsfwhen.com');
        $response->assertDontSee('Yunus Emre Altanay');
        $response->assertDontSee('y.emrealtanay@gmail.com');
        $response->assertSee('Creative Commons Attribution-ShareAlike (CC BY-SA)');
        $response->assertSee('TR ve UK');
    }

    public function test_terms_page_renders_in_english(): void
    {
        app()->setLocale('en');
        $response = $this->get(route('terms'));
        $response->assertOk();
        $response->assertSee('Terms of Service');
        $response->assertSee('1. What is NSFWhen');
        $response->assertSee('2. Eligibility (Age Requirement)');
        $response->assertSee('10. Limitation of Liability');
        $response->assertSee('NSFWhen Legal Team');
        $response->assertSee('legal@nsfwhen.com');
        $response->assertDontSee('Yunus Emre Altanay');
        $response->assertDontSee('y.emrealtanay@gmail.com');
        $response->assertSee('Creative Commons Attribution-ShareAlike (CC BY-SA)');
    }

    public function test_guidelines_route_aliases_to_terms(): void
    {
        $response = $this->get(route('guidelines'));
        $response->assertOk();
        $response->assertSee('What is NSFWhen');
    }

    public function test_privacy_page_renders_in_turkish_with_gdpr_and_kvkk(): void
    {
        $response = $this->withSession(['locale' => 'tr'])->get(route('privacy'));
        $response->assertOk();
        $response->assertSee('Gizlilik & GDPR Politikası');
        $response->assertSee('1. Veri Sorumlusu');
        $response->assertSee('NSFWhen Legal Team');
        $response->assertSee('legal@nsfwhen.com');
        $response->assertDontSee('Yunus Emre Altanay');
        $response->assertDontSee('y.emrealtanay@gmail.com');
        $response->assertSee('GDPR');
        $response->assertSee('KVKK');
        $response->assertSee('8. Veri Sahibi Hakları');
    }

    public function test_privacy_page_renders_in_english(): void
    {
        $response = $this->get(route('privacy'));
        $response->assertOk();
        $response->assertSee('Privacy & GDPR Policy');
        $response->assertSee('1. Data Controller');
        $response->assertSee('NSFWhen Legal Team');
        $response->assertSee('legal@nsfwhen.com');
        $response->assertDontSee('Yunus Emre Altanay');
        $response->assertDontSee('y.emrealtanay@gmail.com');
        $response->assertSee('General Data Protection Regulation');
        $response->assertSee('8. Your Data Protection Rights');
    }

    public function test_gdpr_route_aliases_to_privacy(): void
    {
        $response = $this->get(route('gdpr'));
        $response->assertOk();
        $response->assertSee('Data Controller');
    }
}
