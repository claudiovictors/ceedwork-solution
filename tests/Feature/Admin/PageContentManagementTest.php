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

    public function test_invalid_images_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = $this->pagePayload('home');
        $payload['hero_background_image'] = UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf');

        $this->actingAs($admin)
            ->put(route('admin.pages.update', 'home'), $payload)
            ->assertSessionHasErrors('hero_background_image');
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
