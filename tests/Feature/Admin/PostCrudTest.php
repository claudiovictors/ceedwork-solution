<?php

namespace Tests\Feature\Admin;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_manage_posts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.news.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_a_post(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Notícia de teste',
            'slug' => '',
            'category_id' => $category->id,
            'excerpt' => 'Resumo de teste',
            'body' => '<p>Conteúdo de teste</p>',
            'status' => PostStatus::Draft->value,
            'is_featured' => '1',
            'cover_image' => UploadedFile::fake()->image('cover.jpg', 1200, 630),
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.news.index'));

        $post = Post::query()->firstOrFail();

        $this->assertSame('noticia-de-teste', $post->slug);
        $this->assertSame('Resumo de teste', $post->excerpt);
        $this->assertSame($admin->id, $post->author_id);
        $this->assertSame($category->id, $post->category_id);
        $this->assertTrue($post->is_featured);
        $this->assertSame(PostStatus::Draft, $post->status);
        $this->assertNull($post->published_at);
        $this->assertStringStartsWith('posts/covers/', $post->cover_image);
        Storage::disk('public')->assertExists($post->cover_image);
    }

    public function test_publishing_without_a_date_uses_the_current_date(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Notícia publicada',
            'slug' => 'noticia-publicada',
            'category_id' => $category->id,
            'excerpt' => 'Resumo',
            'body' => '<p>Conteúdo</p>',
            'status' => PostStatus::Published->value,
        ])->assertSessionHasNoErrors();

        $post = Post::query()->firstOrFail();

        $this->assertSame(PostStatus::Published, $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_duplicate_slugs_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        Post::factory()->create([
            'slug' => 'slug-existente',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Outra notícia',
            'slug' => 'slug-existente',
            'category_id' => $category->id,
            'excerpt' => 'Resumo',
            'body' => '<p>Conteúdo</p>',
            'status' => PostStatus::Draft->value,
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_admin_can_update_a_post(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $newCategory = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
            'status' => PostStatus::Draft,
            'published_at' => null,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.news.update', $post), [
            'title' => 'Título atualizado',
            'slug' => 'titulo-atualizado',
            'category_id' => $newCategory->id,
            'excerpt' => 'Resumo atualizado',
            'body' => '<p>Conteúdo atualizado</p>',
            'status' => PostStatus::Published->value,
            'is_featured' => '1',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.news.index'));

        $post->refresh();

        $this->assertSame('Título atualizado', $post->title);
        $this->assertSame('titulo-atualizado', $post->slug);
        $this->assertSame($newCategory->id, $post->category_id);
        $this->assertSame(PostStatus::Published, $post->status);
        $this->assertNotNull($post->published_at);
        $this->assertTrue($post->is_featured);
    }

    public function test_updating_the_cover_image_deletes_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/covers/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
            'cover_image' => 'posts/covers/old.jpg',
            'status' => PostStatus::Draft,
            'published_at' => null,
        ]);

        $this->actingAs($admin)->put(route('admin.news.update', $post), [
            'title' => 'Notícia com nova capa',
            'slug' => $post->slug,
            'category_id' => $category->id,
            'excerpt' => 'Resumo',
            'body' => '<p>Conteúdo</p>',
            'status' => PostStatus::Draft->value,
            'cover_image' => UploadedFile::fake()->image('new.jpg', 1200, 630),
        ])->assertSessionHasNoErrors();

        $post->refresh();

        $this->assertNotSame('posts/covers/old.jpg', $post->cover_image);
        Storage::disk('public')->assertMissing('posts/covers/old.jpg');
        Storage::disk('public')->assertExists($post->cover_image);
    }

    public function test_removing_the_cover_image_deletes_the_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/covers/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
            'cover_image' => 'posts/covers/old.jpg',
            'status' => PostStatus::Draft,
            'published_at' => null,
        ]);

        $this->actingAs($admin)->put(route('admin.news.update', $post), [
            'title' => 'Notícia sem capa',
            'slug' => $post->slug,
            'category_id' => $category->id,
            'excerpt' => 'Resumo',
            'body' => '<p>Conteúdo</p>',
            'status' => PostStatus::Draft->value,
            'remove_cover' => '1',
        ])->assertSessionHasNoErrors();

        $post->refresh();

        $this->assertNull($post->cover_image);
        Storage::disk('public')->assertMissing('posts/covers/old.jpg');
    }

    public function test_admin_can_toggle_post_status(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $post = Post::factory()->published()->create([
            'category_id' => $category->id,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.news.toggle-status', $post))
            ->assertRedirect();

        $post->refresh();

        $this->assertSame(PostStatus::Draft, $post->status);
        $this->assertNull($post->published_at);

        $this->actingAs($admin)
            ->patch(route('admin.news.toggle-status', $post))
            ->assertRedirect();

        $post->refresh();

        $this->assertSame(PostStatus::Published, $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_delete_a_post_and_its_cover(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/covers/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
            'cover_image' => 'posts/covers/old.jpg',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.news.destroy', $post))
            ->assertRedirect(route('admin.news.index'));

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing('posts/covers/old.jpg');
    }

    public function test_post_validation_requires_the_essential_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.news.store'), [])
            ->assertSessionHasErrors(['title', 'slug', 'category_id', 'body', 'status']);
    }
}
