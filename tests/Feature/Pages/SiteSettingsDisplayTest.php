<?php

namespace Tests\Feature\Pages;

use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SiteSettingsDisplayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_public_pages_render_settings_values(): void
    {
        $settings = app(SiteSettings::class);

        $settings->setGroup('general', [
            'site_name' => 'Ceedwork Teste',
            'tagline' => 'Slogan de teste.',
        ]);

        $settings->setGroup('contact', [
            'phones' => [
                ['label' => '+244 111 222 333', 'href' => 'tel:+244111222333'],
            ],
            'emails' => [
                ['type' => 'Geral', 'email' => 'geral@teste.ao'],
                ['type' => 'Suporte', 'email' => 'suporte@teste.ao'],
            ],
            'address' => 'Rua de Teste, Cabinda',
            'map_url' => 'https://maps.example.com/teste',
            'map_embed_url' => 'https://maps.example.com/embed',
            'hours' => 'Segunda a sábado, 09h - 18h',
            'whatsapp_number' => '+244 111 222 333',
            'whatsapp_url' => 'https://wa.me/244111222333',
        ]);

        $settings->setGroup('social', [
            'links' => [
                ['network' => 'linkedin', 'url' => 'https://www.linkedin.com/company/teste'],
            ],
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Ceedwork Teste')
            ->assertSee('Slogan de teste.')
            ->assertSee('+244 111 222 333')
            ->assertSee('geral@teste.ao')
            ->assertSee('Rua de Teste, Cabinda')
            ->assertSee('https://www.linkedin.com/company/teste');

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('+244 111 222 333')
            ->assertSee('geral@teste.ao')
            ->assertSee('suporte@teste.ao')
            ->assertSee('Rua de Teste, Cabinda')
            ->assertSee('Segunda a sábado, 09h - 18h')
            ->assertSee('https://maps.example.com/teste')
            ->assertSee('https://wa.me/244111222333');
    }

    public function test_appearance_settings_override_css_variables(): void
    {
        app(SiteSettings::class)->setGroup('appearance', [
            'primary' => '#112233',
            'secondary' => '#13397c',
            'accent' => '#445566',
            'blue' => '#2f96bf',
            'purple' => '#475593',
            'aqua' => '#5eb3bb',
            'light_blue' => '#c3ebfa',
            'background' => '#dae1f1',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('--color-primary: #112233;', false)
            ->assertSee('--color-teal: #445566;', false)
            ->assertSee('--accent-hover: #3c4b5a;', false);
    }

    public function test_assistant_can_be_disabled_and_configured(): void
    {
        $settings = app(SiteSettings::class);

        $settings->setGroup('assistant', ['enabled' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('id="assistant"', false);

        $settings->setGroup('assistant', [
            'enabled' => true,
            'name' => 'Bot Teste',
            'greeting' => 'Olá, eu sou o Bot Teste.',
            'suggestions' => [
                ['text' => 'Pergunta de teste'],
            ],
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="assistant"', false)
            ->assertSee('Bot Teste')
            ->assertSee('Olá, eu sou o Bot Teste.')
            ->assertSee('Pergunta de teste');
    }

    public function test_assistant_prompt_uses_settings(): void
    {
        config(['services.groq.key' => 'test-key']);

        $settings = app(SiteSettings::class);

        $settings->setGroup('general', ['site_name' => 'Ceedwork Prompt']);
        $settings->setGroup('contact', [
            'phones' => [
                ['label' => '+244 999 888 777', 'href' => 'tel:+244999888777'],
            ],
            'emails' => [
                ['type' => 'Geral', 'email' => 'geral@prompt.ao'],
            ],
        ]);
        $settings->setGroup('assistant', [
            'enabled' => true,
            'name' => 'Bot Prompt',
            'extra_prompt' => 'Informação adicional de teste.',
        ]);

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Resposta de teste']],
                ],
            ]),
        ]);

        $this->postJson(route('assistant.chat'), [
            'messages' => [
                ['role' => 'user', 'text' => 'Olá'],
            ],
        ])
            ->assertOk()
            ->assertJson(['reply' => 'Resposta de teste']);

        Http::assertSent(function (Request $request): bool {
            $system = (string) ($request['messages'][0]['content'] ?? '');

            return str_contains($system, 'Bot Prompt')
                && str_contains($system, 'Ceedwork Prompt')
                && str_contains($system, '+244 999 888 777')
                && str_contains($system, 'geral@prompt.ao')
                && str_contains($system, 'Informação adicional de teste.');
        });
    }

    public function test_disabled_assistant_rejects_chat_requests(): void
    {
        config(['services.groq.key' => 'test-key']);

        app(SiteSettings::class)->setGroup('assistant', ['enabled' => false]);

        Http::fake();

        $this->postJson(route('assistant.chat'), [
            'messages' => [
                ['role' => 'user', 'text' => 'Olá'],
            ],
        ])->assertStatus(503);

        Http::assertNothingSent();
    }
}
