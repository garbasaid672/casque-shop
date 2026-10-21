<?php

namespace Tests\Feature;

use App\Filament\Pages\HomepageSettings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomepageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_configure_the_video_and_reviews_sections(): void
    {
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin-homepage@example.com',
            'password' => 'Admin123456',
        ]);
        $admin->is_admin = true;
        $admin->save();

        Livewire::actingAs($admin)
            ->test(HomepageSettings::class)
            ->set('data.home_video_enabled', false)
            ->set('data.home_video_title', 'Notre parcours de livraison')
            ->set('data.home_reviews_enabled', false)
            ->set('data.home_reviews_title', 'Les avis de nos clients')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('0', Setting::where('key', 'home_video_enabled')->value('value'));
        $this->assertSame('Notre parcours de livraison', Setting::where('key', 'home_video_title')->value('value'));
        $this->assertSame('0', Setting::where('key', 'home_reviews_enabled')->value('value'));
        $this->assertSame('Les avis de nos clients', Setting::where('key', 'home_reviews_title')->value('value'));

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('id="comment-commander"', false)
            ->assertDontSee('id="avis-clients"', false);
    }

    public function test_homepage_displays_the_configured_section_texts(): void
    {
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin-homepage-copy@example.com',
            'password' => 'Admin123456',
        ]);
        $admin->is_admin = true;
        $admin->save();

        Livewire::actingAs($admin)
            ->test(HomepageSettings::class)
            ->set('data.home_video_title', 'Suivez votre commande')
            ->set('data.home_video_description', 'De la sélection du casque à sa livraison.')
            ->set('data.home_reviews_title', 'Ils nous font confiance')
            ->set('data.home_reviews_description', 'Les retours de nos clients.')
            ->call('save')
            ->assertHasNoErrors();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Suivez votre commande')
            ->assertSee('De la sélection du casque à sa livraison.')
            ->assertSee('Ils nous font confiance')
            ->assertSee('Les retours de nos clients.');
    }
}
