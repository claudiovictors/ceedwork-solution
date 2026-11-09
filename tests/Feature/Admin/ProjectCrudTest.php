<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_manage_projects(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.portfolio.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_the_portfolio_pages(): void
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create();

        $this->actingAs($admin)->get(route('admin.portfolio.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.portfolio.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.portfolio.edit', $project))->assertOk();
    }

    public function test_admin_can_create_a_project_with_technologies_and_images(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.portfolio.store'), [
            'name' => 'Portal do Cidadão',
            'slug' => '',
            'category' => 'Governo',
            'summary' => 'Plataforma de serviços digitais.',
            'description' => 'Descrição detalhada do projeto.',
            'url' => 'https://example.com',
            'technologies' => 'Laravel, PHP, Laravel, MySQL',
            'sort_order' => 3,
            'is_published' => '1',
            'logo' => UploadedFile::fake()->image('logo.png', 400, 200),
            'image' => UploadedFile::fake()->image('cover.jpg', 1200, 800),
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.portfolio.index'));

        $project = Project::query()->firstOrFail();

        $this->assertSame('portal-do-cidadao', $project->slug);
        $this->assertSame(['Laravel', 'PHP', 'MySQL'], $project->technologies);
        $this->assertSame(3, $project->sort_order);
        $this->assertTrue($project->is_published);
        $this->assertStringStartsWith('projects/logos/', $project->logo);
        $this->assertStringStartsWith('projects/images/', $project->image);
        Storage::disk('public')->assertExists($project->logo);
        Storage::disk('public')->assertExists($project->image);
    }

    public function test_project_validation_requires_the_essential_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.portfolio.store'), [])
            ->assertSessionHasErrors(['name', 'slug', 'summary']);
    }

    public function test_duplicate_project_slugs_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        Project::factory()->create(['slug' => 'slug-existente']);

        $this->actingAs($admin)
            ->post(route('admin.portfolio.store'), [
                'name' => 'Outro projeto',
                'slug' => 'slug-existente',
                'summary' => 'Resumo',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_admin_can_update_a_project_and_its_technologies(): void
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create([
            'technologies' => ['PHP', 'MySQL'],
            'is_published' => false,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.portfolio.update', $project), [
            'name' => 'Projeto atualizado',
            'slug' => 'projeto-atualizado',
            'category' => 'Educação',
            'summary' => 'Resumo atualizado',
            'technologies' => 'Laravel, Vue, Tailwind',
            'sort_order' => 7,
            'is_published' => '1',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.portfolio.index'));

        $project->refresh();

        $this->assertSame('Projeto atualizado', $project->name);
        $this->assertSame('projeto-atualizado', $project->slug);
        $this->assertSame('Educação', $project->category);
        $this->assertSame(['Laravel', 'Vue', 'Tailwind'], $project->technologies);
        $this->assertSame(7, $project->sort_order);
        $this->assertTrue($project->is_published);
    }

    public function test_updating_images_deletes_the_old_files_and_removal_clears_them(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/logos/old.png', 'old');
        Storage::disk('public')->put('projects/images/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create([
            'logo' => 'projects/logos/old.png',
            'image' => 'projects/images/old.jpg',
        ]);

        $this->actingAs($admin)->put(route('admin.portfolio.update', $project), [
            'name' => $project->name,
            'slug' => $project->slug,
            'summary' => $project->summary,
            'logo' => UploadedFile::fake()->image('new-logo.png'),
            'remove_image' => '1',
        ])->assertSessionHasNoErrors();

        $project->refresh();

        $this->assertNotSame('projects/logos/old.png', $project->logo);
        Storage::disk('public')->assertMissing('projects/logos/old.png');
        Storage::disk('public')->assertExists($project->logo);

        $this->assertNull($project->image);
        Storage::disk('public')->assertMissing('projects/images/old.jpg');
    }

    public function test_admin_can_toggle_project_publication(): void
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create(['is_published' => true]);

        $this->actingAs($admin)
            ->patch(route('admin.portfolio.toggle-published', $project))
            ->assertRedirect();

        $this->assertFalse($project->refresh()->is_published);

        $this->actingAs($admin)
            ->patch(route('admin.portfolio.toggle-published', $project))
            ->assertRedirect();

        $this->assertTrue($project->refresh()->is_published);
    }

    public function test_admin_can_delete_a_project_with_its_images(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/logos/old.png', 'old');
        Storage::disk('public')->put('projects/images/old.jpg', 'old');

        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create([
            'logo' => 'projects/logos/old.png',
            'image' => 'projects/images/old.jpg',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.portfolio.destroy', $project))
            ->assertRedirect(route('admin.portfolio.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        Storage::disk('public')->assertMissing('projects/logos/old.png');
        Storage::disk('public')->assertMissing('projects/images/old.jpg');
    }

    public function test_portfolio_can_be_filtered_by_category(): void
    {
        $admin = User::factory()->admin()->create();
        Project::factory()->create(['name' => 'Projeto Saúde', 'category' => 'Saúde']);
        Project::factory()->create(['name' => 'Projeto Educação', 'category' => 'Educação']);

        $this->actingAs($admin)
            ->get(route('admin.portfolio.index', ['category' => 'Saúde']))
            ->assertOk()
            ->assertSee('Projeto Saúde')
            ->assertDontSee('Projeto Educação');
    }
}
