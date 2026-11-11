<?php

namespace Tests\Feature\Pages;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_posts_are_rendered_on_the_news_page(): void
    {
        $category = Category::factory()->create(['name' => 'Tecnologia']);
        Post::factory()->published()->create([
            'category_id' => $category->id,
            'title' => 'Notícia publicada',
            'slug' => 'noticia-publicada',
            'excerpt' => 'Resumo da notícia',
            'cover_image' => 'https://example.com/noticia.jpg',
        ]);

        $this->get(route('news'))
            ->assertOk()
            ->assertSee('Notícia publicada')
            ->assertSee('Resumo da notícia')
            ->assertSee('Tecnologia')
            ->assertSee('https://example.com/noticia.jpg');
    }

    public function test_news_page_renders_when_there_are_no_published_posts(): void
    {
        $this->get(route('news'))
            ->assertOk()
            ->assertSee('Nenhuma notícia encontrada')
            ->assertDontSee('news-featured__inner');
    }

    public function test_published_post_page_renders_model_content(): void
    {
        $category = Category::factory()->create(['name' => 'Empresa']);
        $post = Post::factory()->published()->create([
            'category_id' => $category->id,
            'title' => 'Notícia em detalhe',
            'slug' => 'noticia-em-detalhe',
            'excerpt' => 'Resumo da notícia em detalhe.',
            'body' => '<p>Corpo completo da notícia.</p>',
            'cover_image' => 'https://example.com/detalhe.jpg',
        ]);

        $this->get(route('news.show', $post))
            ->assertOk()
            ->assertSee('Notícia em detalhe')
            ->assertSee('Resumo da notícia em detalhe.')
            ->assertSee('Corpo completo da notícia.', false)
            ->assertSee('Empresa')
            ->assertSee($post->author->name)
            ->assertSee('https://example.com/detalhe.jpg');
    }
}
