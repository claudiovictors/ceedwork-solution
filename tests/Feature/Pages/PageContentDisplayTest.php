<?php

namespace Tests\Feature\Pages;

use App\Models\Project;
use App\Support\PageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PageContentDisplayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_about_page_renders_editable_content(): void
    {
        $content = app(PageContent::class);

        $content->save('about', 'banner', [
            'title' => 'Sobre teste',
            'image' => 'https://example.com/sobre.jpg',
            'image_alt' => 'Banner de teste',
        ]);
        $content->save('about', 'mission', [
            'title' => 'Missão de teste',
            'body' => 'Corpo da missão de teste.',
        ]);
        $content->save('about', 'values', [
            'title' => 'Valores de teste',
            'items' => [
                ['icon' => 'bx-star', 'title' => 'Valor de teste', 'text' => 'Texto do valor de teste.'],
            ],
        ]);

        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Sobre teste')
            ->assertSee('https://example.com/sobre.jpg')
            ->assertSee('Missão de teste')
            ->assertSee('Corpo da missão de teste.')
            ->assertSee('Valores de teste')
            ->assertSee('Valor de teste')
            ->assertSee('Texto do valor de teste.');
    }

    public function test_contact_page_renders_editable_content_and_subjects(): void
    {
        Mail::fake();

        $content = app(PageContent::class);

        $content->save('contact', 'banner', [
            'title' => 'Contactos de teste',
            'image' => 'https://example.com/contactos.jpg',
            'image_alt' => 'Banner de contactos',
        ]);
        $content->save('contact', 'intro', [
            'eyebrow' => 'Rótulo de teste',
            'title' => 'Título de contacto de teste',
            'text' => 'Texto de contacto de teste.',
            'quick_1' => 'Apoio de teste.',
            'quick_2' => 'Segundo apoio de teste.',
        ]);
        $content->save('contact', 'faq', [
            'eyebrow' => 'Dúvidas de teste',
            'title' => 'FAQ de teste',
            'items' => [
                ['question' => 'Pergunta de teste?', 'answer' => 'Resposta de teste.'],
            ],
        ]);
        $content->save('contact', 'subjects', [
            'items' => [
                ['subject' => 'Assunto de teste'],
            ],
        ]);

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Contactos de teste')
            ->assertSee('Título de contacto de teste')
            ->assertSee('Texto de contacto de teste.')
            ->assertSee('Apoio de teste.')
            ->assertSee('Segundo apoio de teste.')
            ->assertSee('FAQ de teste')
            ->assertSee('Pergunta de teste?')
            ->assertSee('Resposta de teste.')
            ->assertSee('Assunto de teste');

        $this->post(route('contact.send'), [
            'name' => 'Cliente de teste',
            'email' => 'cliente@example.com',
            'phone' => '+244 999 999 999',
            'subject' => 'Assunto de teste',
            'message' => 'Mensagem de teste com detalhe suficiente.',
        ])->assertSessionHasNoErrors();
    }

    public function test_services_page_renders_editable_header(): void
    {
        $content = app(PageContent::class);

        $content->save('services', 'header', [
            'title' => 'Serviços de teste',
            'intro_eyebrow' => 'Rótulo de serviços',
            'intro_title' => 'Título de serviços de teste',
            'intro' => 'Introdução de serviços de teste.',
            'image' => 'https://example.com/servicos.jpg',
            'image_alt' => 'Banner de serviços',
        ]);
        $content->save('services', 'cta', [
            'eyebrow' => 'CTA de serviços',
            'title' => 'Título do CTA de teste',
            'text' => 'Texto do CTA de teste.',
            'button_label' => 'Botão do CTA',
            'button_link' => '/contact',
        ]);

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Serviços de teste')
            ->assertSee('Rótulo de serviços')
            ->assertSee('Título de serviços de teste')
            ->assertSee('Introdução de serviços de teste.')
            ->assertSee('https://example.com/servicos.jpg')
            ->assertSee('CTA de serviços')
            ->assertSee('Título do CTA de teste')
            ->assertSee('Texto do CTA de teste.')
            ->assertSee('Botão do CTA');
    }

    public function test_portfolio_page_renders_published_projects(): void
    {
        app(PageContent::class)->save('portfolio', 'header', [
            'title' => 'Portfólio de teste',
            'intro' => 'Introdução do portfólio de teste.',
            'image' => 'https://example.com/portfolio.jpg',
            'image_alt' => 'Banner do portfólio',
        ]);

        Project::factory()->create([
            'name' => 'Projeto publicado',
            'summary' => 'Resumo do projeto publicado.',
            'image' => 'https://example.com/projeto.jpg',
            'is_published' => true,
        ]);

        Project::factory()->unpublished()->create([
            'name' => 'Projeto não publicado',
            'summary' => 'Resumo do projeto não publicado.',
        ]);

        $this->get(route('portfolio'))
            ->assertOk()
            ->assertSee('Portfólio de teste')
            ->assertSee('Introdução do portfólio de teste.')
            ->assertSee('https://example.com/portfolio.jpg')
            ->assertSee('Projeto publicado')
            ->assertSee('Resumo do projeto publicado.')
            ->assertSee('https://example.com/projeto.jpg')
            ->assertDontSee('Projeto não publicado');
    }

    public function test_home_brands_and_partners_are_editable(): void
    {
        $content = app(PageContent::class);

        $content->save('home', 'brands', [
            'items' => [
                ['name' => 'Marca de teste', 'image' => 'https://example.com/marca.png', 'url' => '/services'],
            ],
        ]);
        $content->save('home', 'partners', [
            'eyebrow' => 'Parcerias de teste',
            'title' => 'Parceiros de teste',
            'items' => [
                ['name' => 'Parceiro de teste', 'image' => 'https://example.com/parceiro.png', 'url' => null],
            ],
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Marca de teste')
            ->assertSee('https://example.com/marca.png')
            ->assertSee('Parcerias de teste')
            ->assertSee('Parceiros de teste')
            ->assertSee('Parceiro de teste')
            ->assertSee('https://example.com/parceiro.png');
    }

    public function test_home_services_are_editable(): void
    {
        app(PageContent::class)->save('home', 'services', [
            'items' => [
                [
                    'eyebrow' => 'Rótulo de serviço de teste',
                    'title' => 'Serviço home de teste',
                    'text' => 'Texto do serviço home com <strong>destaque</strong>.',
                    'link' => '/services',
                    'images' => "https://example.com/servico-a.jpg\nhttps://example.com/servico-b.jpg",
                ],
            ],
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Rótulo de serviço de teste')
            ->assertSee('Serviço home de teste')
            ->assertSee('Texto do serviço home com', false)
            ->assertSee('<strong>destaque</strong>', false)
            ->assertSee('https://example.com/servico-a.jpg')
            ->assertSee('https://example.com/servico-b.jpg');
    }

    public function test_home_services_section_is_hidden_when_not_customized(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Software à medida')
            ->assertDontSee('Equipamentos prontos para servir');
    }

    public function test_news_header_and_footer_text_are_editable(): void
    {
        $content = app(PageContent::class);

        $content->save('news', 'header', [
            'title' => 'Notícias de teste',
            'intro' => 'Introdução de notícias de teste.',
            'image' => 'https://example.com/noticias.jpg',
            'image_alt' => 'Banner de notícias',
        ]);
        $content->save('footer', 'institutional', [
            'text' => 'Texto institucional de teste.',
        ]);

        $this->get(route('news'))
            ->assertOk()
            ->assertSee('Notícias de teste')
            ->assertSee('https://example.com/noticias.jpg');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Texto institucional de teste.');
    }
}
