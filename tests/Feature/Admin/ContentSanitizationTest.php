<?php

namespace Tests\Feature\Admin;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentSanitizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_body_is_sanitized_before_persisting(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Notícia com conteúdo inseguro',
            'slug' => 'noticia-com-conteudo-inseguro',
            'category_id' => $category->id,
            'excerpt' => 'Resumo',
            'body' => '<p>Texto <strong>seguro</strong></p>'
                .'<script>alert("xss")</script>'
                .'<img src="/storage/image.jpg" onerror="alert(1)">'
                .'<a href="javascript:alert(1)" target="_blank" rel="opener">link</a>'
                .'<p style="color:red">estilo</p>',
            'status' => PostStatus::Draft->value,
        ])->assertSessionHasNoErrors();

        $body = Post::query()->firstOrFail()->body;

        $this->assertStringNotContainsString('<script', $body);
        $this->assertStringNotContainsString('onerror', $body);
        $this->assertStringNotContainsString('javascript:', $body);
        $this->assertStringNotContainsString('style=', $body);
        $this->assertStringContainsString('<strong>seguro</strong>', $body);
        $this->assertStringContainsString('rel="noopener noreferrer"', $body);
    }

    public function test_excerpt_is_generated_from_the_body_when_empty(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Notícia com resumo automático',
            'slug' => 'noticia-com-resumo-automatico',
            'category_id' => $category->id,
            'excerpt' => '',
            'body' => '<p>Este texto deve ser usado para gerar o resumo automático da notícia.</p>',
            'status' => PostStatus::Draft->value,
        ])->assertSessionHasNoErrors();

        $post = Post::query()->firstOrFail();

        $this->assertNotNull($post->excerpt);
        $this->assertStringContainsString('Este texto deve ser usado', $post->excerpt);
    }
}
