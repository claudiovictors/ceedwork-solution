<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_registration_screen_is_not_available(): void
    {
        $this->get('/ceed-admin/register')
            ->assertNotFound();
    }

    public function test_public_registration_is_disabled(): void
    {
        $this->post('/ceed-admin/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertNotFound();

        $this->assertGuest();
    }
}
