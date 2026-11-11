<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SettingsManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_defaults_are_used_when_database_is_empty(): void
    {
        $settings = app(SiteSettings::class);

        $this->assertSame('Ceedwork-Solutions', $settings->get('general.site_name'));
        $this->assertSame('#031b3a', $settings->get('appearance.primary'));
        $this->assertSame('geral@ceedwork.co.ao', $settings->get('contact.emails.0.email'));
    }

    public function test_saving_a_setting_invalidates_the_cache(): void
    {
        $settings = app(SiteSettings::class);

        $this->assertSame('Ceedwork-Solutions', $settings->get('general.site_name'));

        $settings->set('general.site_name', 'Ceedwork Teste');

        $this->assertSame('Ceedwork Teste', app(SiteSettings::class)->get('general.site_name'));
    }

    public function test_admin_users_can_view_the_settings_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Geral')
            ->assertSee('Contactos')
            ->assertSee('Aparência');

        $this->actingAs($admin)
            ->get(route('admin.settings.edit', ['group' => 'contact']))
            ->assertOk()
            ->assertSee('Telefones');
    }

    public function test_admin_users_can_update_general_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.settings.update', 'general'), [
                'site_name' => 'Ceedwork Teste',
                'tagline' => 'Novo slogan',
                'seo_description' => 'Nova descrição.',
            ])
            ->assertRedirect(route('admin.settings.edit', ['group' => 'general']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('settings', [
            'group' => 'general',
            'key' => 'site_name',
        ]);

        $this->assertSame('Ceedwork Teste', app(SiteSettings::class)->get('general.site_name'));
    }

    public function test_admin_users_can_update_contact_repeaters(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.settings.update', 'contact'), [
                'phones' => [
                    ['label' => '+244 111 222 333', 'href' => 'tel:+244111222333'],
                ],
                'emails' => [
                    ['type' => 'Geral', 'email' => 'geral@teste.ao'],
                    ['type' => 'Suporte', 'email' => 'suporte@teste.ao'],
                ],
                'address' => 'Rua de Teste, Cabinda',
                'hours' => 'Segunda a sábado, 09h - 18h',
                'whatsapp_number' => '+244 111 222 333',
                'whatsapp_url' => 'https://wa.me/244111222333',
                'map_url' => 'https://maps.example.com/teste',
                'map_embed_url' => 'https://maps.example.com/embed',
            ])
            ->assertSessionHasNoErrors();

        $settings = app(SiteSettings::class);

        $this->assertSame('+244 111 222 333', $settings->get('contact.phones.0.label'));
        $this->assertCount(2, $settings->get('contact.emails'));
    }

    public function test_contact_repeater_form_uses_valid_alpine_data(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.settings.edit', ['group' => 'contact']))
            ->assertOk()
            ->assertSee('x-data="{ items: JSON.parse(', false);
    }

    public function test_invalid_colors_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.settings.update', 'appearance'), [
                'primary' => 'azul',
                'secondary' => '#13397c',
                'accent' => '#1baa99',
                'blue' => '#2f96bf',
                'purple' => '#475593',
                'aqua' => '#5eb3bb',
                'light_blue' => '#c3ebfa',
                'background' => '#dae1f1',
            ])
            ->assertSessionHasErrors('primary');
    }

    public function test_unsafe_urls_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.settings.update', 'contact'), [
                'address' => 'Rua Da Polícia, Cabinda, Angola',
                'hours' => 'Segunda a sexta, 08h - 17h',
                'whatsapp_number' => '+244 947 824 328',
                'whatsapp_url' => 'https://wa.me/+244947824328',
                'map_url' => 'javascript:alert(1)',
            ])
            ->assertSessionHasErrors('map_url');
    }
}
