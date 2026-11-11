<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\ContentSchema;
use App\Support\PageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PageContentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_defaults_are_used_when_database_is_empty(): void
    {
        $content = app(PageContent::class);

        $this->assertSame(
            'Soluções de tecnologia que impulsionam o seu negócio.',
            $content->get('home', 'hero', 'title')
        );

        $this->assertSame(
            'Quem somos',
            $content->get('about', 'banner', 'title')
        );
    }

    public function test_admin_users_can_view_pages_and_edit_forms(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.pages.index'))
            ->assertOk()
            ->assertSee('Home')
            ->assertSee('Sobre nós');

        $this->actingAs($admin)
            ->get(route('admin.pages.edit', 'home'))
            ->assertOk()
            ->assertSee('Hero')
            ->assertSee('Destaques');

        $this->actingAs($admin)
            ->get(route('admin.pages.edit', 'about'))
            ->assertOk()
            ->assertSee('Valores');
    }

    public function test_admin_users_can_update_repeater_content(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('about');
        $payload['values_items'] = [
            ['icon' => 'bx-star', 'title' => 'Foco', 'text' => 'Texto do valor.'],
        ];

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'about'), $payload)
            ->assertSessionHasNoErrors();

        $items = app(PageContent::class)->get('about', 'values', 'items');

        $this->assertSame('Foco', $items[0]['title']);
    }

    public function test_admin_users_can_update_page_content(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_title'] = 'Novo título da home';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertRedirect(route('admin.pages.edit', 'home'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('page_sections', [
            'page' => 'home',
            'key' => 'hero',
        ]);

        $this->assertSame(
            'Novo título da home',
            app(PageContent::class)->get('home', 'hero', 'title')
        );
    }

    public function test_sections_can_be_restored_to_defaults(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_title'] = 'Título personalizado';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasNoErrors();

        $this->actingAs($admin)
            ->delete(route('admin.pages.restore', ['home', 'hero']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('page_sections', [
            'page' => 'home',
            'key' => 'hero',
        ]);

        $this->assertSame(
            'Soluções de tecnologia que impulsionam o seu negócio.',
            app(PageContent::class)->get('home', 'hero', 'title')
        );
    }

    public function test_featured_image_can_be_removed(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['remove_hero_featured_image'] = '1';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasNoErrors();

        $this->assertNull(app(PageContent::class)->get('home', 'hero', 'featured_image'));
    }

    public function test_images_can_be_set_via_url(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_featured_image_url'] = 'https://example.com/destaque.jpg';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasNoErrors();

        $this->assertSame(
            'https://example.com/destaque.jpg',
            app(PageContent::class)->get('home', 'hero', 'featured_image')
        );
    }

    public function test_unsafe_image_urls_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_featured_image_url'] = 'javascript:alert(1)';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasErrors('hero_featured_image_url');
    }

    public function test_invalid_images_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_background_image'] = UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf');

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasErrors('hero_background_image');
    }

    public function test_home_hero_content_is_rendered_on_the_public_page(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_title'] = 'Título público de teste';
        $payload['hero_text'] = 'Texto público de teste.';
        $payload['hero_primary_label'] = 'Ir para contactos';
        $payload['hero_secondary_label'] = 'Ver sobre nós';
        $payload['hero_background_image_url'] = 'https://example.com/fundo.jpg';
        $payload['hero_featured_image_url'] = 'https://example.com/destaque-publico.jpg';
        $payload['hero_featured_image_alt'] = 'Imagem pública de teste';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasNoErrors();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Título público de teste')
            ->assertSee('Texto público de teste.')
            ->assertSee('Ir para contactos')
            ->assertSee('Ver sobre nós')
            ->assertSee('https://example.com/fundo.jpg')
            ->assertSee('https://example.com/destaque-publico.jpg')
            ->assertSee('Imagem pública de teste');
    }

    public function test_home_hero_featured_image_can_be_hidden(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_show_featured'] = '0';

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasNoErrors();

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('class="hero__media"', false);
    }

    public function test_admin_pages_use_the_custom_confirmation_modal(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.pages.edit', 'home'))
            ->assertOk()
            ->assertSee('id="adminConfirm"', false)
            ->assertSee('data-confirm=', false)
            ->assertDontSee('return confirm(', false);
    }

    /**
     * @return array<string, mixed>
     */
    private function pagePayload(string $page): array
    {
        $payload = [];

        foreach (ContentSchema::sections($page) as $sectionKey => $section) {
            foreach (($section['fields'] ?? []) as $fieldKey => $field) {
                $type = $field['type'] ?? 'text';

                if ($type === 'image') {
                    continue;
                }

                $value = $field['default'] ?? '';

                if ($type === 'toggle') {
                    $value = $value ? '1' : '0';
                }

                $payload["{$sectionKey}_{$fieldKey}"] = $value;
            }
        }

        return $payload;
    }
}
