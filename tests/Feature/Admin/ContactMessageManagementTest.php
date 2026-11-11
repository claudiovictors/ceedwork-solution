<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_manage_messages(): void
    {
        $user = User::factory()->create();
        $message = ContactMessage::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('admin.messages.show', $message))
            ->assertForbidden();
    }

    public function test_admin_can_view_the_message_inbox(): void
    {
        $admin = User::factory()->admin()->create();

        ContactMessage::factory()->create([
            'name' => 'Ana Mensagem',
            'email' => 'ana@example.com',
            'subject' => 'Pedido de teste',
            'message' => 'Conteúdo da mensagem de teste.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Ana Mensagem')
            ->assertSee('ana@example.com')
            ->assertSee('Pedido de teste')
            ->assertSee('1 não lida');
    }

    public function test_opening_a_message_marks_it_as_read(): void
    {
        $admin = User::factory()->admin()->create();
        $message = ContactMessage::factory()->create([
            'name' => 'Bruno Mensagem',
            'subject' => 'Assunto de teste',
            'message' => 'Mensagem com detalhe.',
        ]);

        $this->assertNull($message->read_at);

        $this->actingAs($admin)
            ->get(route('admin.messages.show', $message))
            ->assertOk()
            ->assertSee('Bruno Mensagem')
            ->assertSee('Assunto de teste')
            ->assertSee('Mensagem com detalhe.');

        $this->assertNotNull($message->refresh()->read_at);
    }

    public function test_admin_can_toggle_the_read_state(): void
    {
        $admin = User::factory()->admin()->create();
        $message = ContactMessage::factory()->read()->create();

        $this->actingAs($admin)
            ->patch(route('admin.messages.toggle-read', $message))
            ->assertSessionHas('status');

        $this->assertNull($message->refresh()->read_at);

        $this->actingAs($admin)
            ->patch(route('admin.messages.toggle-read', $message))
            ->assertSessionHas('status');

        $this->assertNotNull($message->refresh()->read_at);
    }

    public function test_admin_can_delete_a_message(): void
    {
        $admin = User::factory()->admin()->create();
        $message = ContactMessage::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_inbox_can_be_filtered_by_unread_messages(): void
    {
        $admin = User::factory()->admin()->create();

        ContactMessage::factory()->create(['name' => 'Mensagem não lida']);
        ContactMessage::factory()->read()->create(['name' => 'Mensagem já lida']);

        $this->actingAs($admin)
            ->get(route('admin.messages.index', ['status' => 'unread']))
            ->assertOk()
            ->assertSee('Mensagem não lida')
            ->assertDontSee('Mensagem já lida');
    }

    public function test_dashboard_shows_the_unread_message_count(): void
    {
        $admin = User::factory()->admin()->create();

        ContactMessage::factory()->count(2)->create();
        ContactMessage::factory()->read()->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Mensagens não lidas')
            ->assertSee('2');
    }
}
