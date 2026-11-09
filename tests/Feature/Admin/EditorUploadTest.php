<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EditorUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_an_editor_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.uploads.editor'), [
            'image' => UploadedFile::fake()->image('inline.jpg', 800, 600),
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure(['url']);

        $url = $response->json('url');
        $path = str_replace('/storage/', '', $url);

        $this->assertStringStartsWith('/storage/posts/content/', $url);
        Storage::disk('public')->assertExists($path);
    }

    public function test_non_admin_users_cannot_upload_editor_images(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.uploads.editor'), [
                'image' => UploadedFile::fake()->image('inline.jpg'),
            ])
            ->assertForbidden();
    }

    public function test_editor_upload_rejects_invalid_files(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->withHeader('Accept', 'application/json')
            ->post(route('admin.uploads.editor'), [
                'image' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('image');
    }

    public function test_editor_upload_rejects_large_images(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->withHeader('Accept', 'application/json')
            ->post(route('admin.uploads.editor'), [
                'image' => UploadedFile::fake()->image('large.jpg')->size(3000),
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('image');
    }
}
