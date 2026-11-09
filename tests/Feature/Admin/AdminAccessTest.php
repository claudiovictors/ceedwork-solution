<?php

namespace Tests\Feature\Admin;

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
