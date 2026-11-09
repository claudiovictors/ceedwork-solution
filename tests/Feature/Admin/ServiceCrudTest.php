<?php

namespace Tests\Feature\Admin;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_manage_services(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.services.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_the_service_pages(): void
    {
        $admin = User::factory()->admin()->create();
        $service = Service::factory()->create();
        $service->items()->create(['title' => 'Item', 'sort_order' => 1]);

        $this->actingAs($admin)->get(route('admin.services.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.services.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.services.edit', $service))->assertOk();
    }

    public function test_admin_can_create_a_service_with_items_and_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.services.store'), [
            'title' => 'Desenvolvimento de Software',
            'slug' => '',
            'icon' => 'bx bx-code-alt',
            'summary' => 'Soluções digitais à medida.',
            'sort_order' => 2,
            'is_active' => '1',
            'items' => ['Sistemas de gestão', 'Aplicações web'],
            'image' => UploadedFile::fake()->image('service.jpg', 1200, 800),
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.services.index'));

        $service = Service::query()->firstOrFail();

        $this->assertSame('desenvolvimento-de-software', $service->slug);
        $this->assertSame('bx bx-code-alt', $service->icon);
        $this->assertSame(2, $service->sort_order);
        $this->assertTrue($service->is_active);
        $this->assertStringStartsWith('services/', $service->image);
        Storage::disk('public')->assertExists($service->image);

        $items = $service->items()->get();
        $this->assertSame(['Sistemas de gestão', 'Aplicações web'], $items->pluck('title')->all());
        $this->assertSame([1, 2], $items->pluck('sort_order')->all());
    }

    public function test_service_validation_requires_the_essential_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.services.store'), [])
            ->assertSessionHasErrors(['title', 'slug', 'summary', 'items']);
    }

    public function test_service_requires_at_least_one_non_empty_item(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.services.store'), [
                'title' => 'Serviço sem itens',
                'slug' => 'servico-sem-itens',
                'summary' => 'Resumo',
                'items' => ['', '   '],
            ])
            ->assertSessionHasErrors('items');
    }

    public function test_duplicate_service_slugs_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        Service::factory()->create(['slug' => 'slug-existente']);

        $this->actingAs($admin)
            ->post(route('admin.services.store'), [
                'title' => 'Outro serviço',
                'slug' => 'slug-existente',
                'summary' => 'Resumo',
                'items' => ['Item'],
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_admin_can_update_a_service_and_sync_items(): void
    {
        $admin = User::factory()->admin()->create();
        $service = Service::factory()->create();

        $service->items()->createMany([
            ['title' => 'Item antigo', 'sort_order' => 1],
            ['title' => 'Outro item antigo', 'sort_order' => 2],
        ]);

        $response = $this->actingAs($admin)->put(route('admin.services.update', $service), [
            'title' => 'Serviço atualizado',
            'slug' => 'servico-atualizado',
            'icon' => 'bx bx-layer',
            'summary' => 'Resumo atualizado',
            'sort_order' => 5,
            'items' => ['Novo item A', 'Novo item B', 'Novo item C'],
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.services.index'));

        $service->refresh();

        $this->assertSame('Serviço atualizado', $service->title);
        $this->assertSame('servico-atualizado', $service->slug);
        $this->assertSame(5, $service->sort_order);
        $this->assertFalse($service->is_active);

        $items = $service->items()->get();
        $this->assertSame(['Novo item A', 'Novo item B', 'Novo item C'], $items->pluck('title')->all());
        $this->assertSame([1, 2, 3], $items->pluck('sort_order')->all());
        $this->assertDatabaseMissing('service_items', ['title' => 'Item antigo']);
    }

    public function test_updating_the_service_image_deletes_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('services/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $service = Service::factory()->create(['image' => 'services/old.jpg']);

        $this->actingAs($admin)->put(route('admin.services.update', $service), [
            'title' => $service->title,
            'slug' => $service->slug,
            'summary' => $service->summary,
            'items' => ['Item'],
            'image' => UploadedFile::fake()->image('new.jpg'),
        ])->assertSessionHasNoErrors();

        $service->refresh();

        $this->assertNotSame('services/old.jpg', $service->image);
        Storage::disk('public')->assertMissing('services/old.jpg');
        Storage::disk('public')->assertExists($service->image);
    }

    public function test_removing_the_service_image_deletes_the_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('services/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $service = Service::factory()->create(['image' => 'services/old.jpg']);

        $this->actingAs($admin)->put(route('admin.services.update', $service), [
            'title' => $service->title,
            'slug' => $service->slug,
            'summary' => $service->summary,
            'items' => ['Item'],
            'remove_image' => '1',
        ])->assertSessionHasNoErrors();

        $service->refresh();

        $this->assertNull($service->image);
        Storage::disk('public')->assertMissing('services/old.jpg');
    }

    public function test_admin_can_toggle_service_status(): void
    {
        $admin = User::factory()->admin()->create();
        $service = Service::factory()->create(['is_active' => true]);

        $this->actingAs($admin)
            ->patch(route('admin.services.toggle-active', $service))
            ->assertRedirect();

        $this->assertFalse($service->refresh()->is_active);

        $this->actingAs($admin)
            ->patch(route('admin.services.toggle-active', $service))
            ->assertRedirect();

        $this->assertTrue($service->refresh()->is_active);
    }

    public function test_admin_can_delete_a_service_with_its_items_and_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('services/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $service = Service::factory()->create(['image' => 'services/old.jpg']);
        $service->items()->create(['title' => 'Item', 'sort_order' => 1]);

        $this->actingAs($admin)
            ->delete(route('admin.services.destroy', $service))
            ->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
        $this->assertDatabaseMissing('service_items', ['service_id' => $service->id]);
        Storage::disk('public')->assertMissing('services/old.jpg');
    }
}
