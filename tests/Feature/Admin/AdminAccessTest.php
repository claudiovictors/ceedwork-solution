<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_non_admin_users_cannot_access_the_admin_area(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();
    }

    public function test_admin_users_can_access_the_dashboard(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();
    }

    public function test_dashboard_shows_content_counts_and_management_links(): void
    {
        $admin = User::factory()->admin()->create();
        Post::factory()->published()->create();
        Post::factory()->create(['title' => 'Artigo em rascunho']);
        Service::factory()->create();
        Service::factory()->inactive()->create();
        Project::factory()->create();
        Project::factory()->unpublished()->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Artigo em rascunho')
            ->assertSee('Artigos e blog')
            ->assertSee('Serviços')
            ->assertSee('Portfólio')
            ->assertSee(route('admin.news.index'))
            ->assertSee(route('admin.news.create'))
            ->assertSee(route('admin.services.index'))
            ->assertSee(route('admin.services.create'))
            ->assertSee(route('admin.portfolio.index'))
            ->assertSee(route('admin.portfolio.create'))
            ->assertSeeInOrder([
                'Total de artigos',
                '2',
                'Artigos publicados',
                '1',
                'Rascunhos',
                '1',
                'Serviços ativos',
                '1',
                'Projetos publicados',
                '1',
            ]);
    }

    public function test_non_admin_users_cannot_access_the_profile_area(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertForbidden();
    }

    public function test_admin_users_can_access_the_profile_area(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk();
    }
}
