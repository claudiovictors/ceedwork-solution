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
}
