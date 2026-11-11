<?php

namespace Tests\Feature\Pages;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submissions_are_stored(): void
    {
        Mail::fake();

        $this->post(route('contact.send'), [
            'name' => 'Cliente de teste',
            'email' => 'cliente@example.com',
            'phone' => '+244 999 999 999',
            'subject' => 'Pedido de orçamento',
            'message' => 'Gostaria de receber uma proposta para um novo website.',
        ])->assertSessionHasNoErrors();

        $message = ContactMessage::query()->firstOrFail();

        $this->assertSame('Cliente de teste', $message->name);
        $this->assertSame('cliente@example.com', $message->email);
        $this->assertSame('+244 999 999 999', $message->phone);
        $this->assertSame('Pedido de orçamento', $message->subject);
        $this->assertSame('Gostaria de receber uma proposta para um novo website.', $message->message);
        $this->assertNotNull($message->ip_address);
        $this->assertNull($message->read_at);
    }

    public function test_honeypot_submissions_are_not_stored(): void
    {
        Mail::fake();

        $this->post(route('contact.send'), [
            'website' => 'https://spam.example.com',
        ])->assertSessionHas('success');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_message_is_kept_even_when_email_delivery_fails(): void
    {
        Mail::shouldReceive('raw')->once()->andThrow(new \RuntimeException('Falha de envio'));

        $this->post(route('contact.send'), [
            'name' => 'Cliente com falha de email',
            'email' => 'falha@example.com',
            'subject' => 'Suporte técnico',
            'message' => 'Mensagem que deve ficar guardada mesmo com falha de email.',
        ])->assertSessionHas('error');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'falha@example.com',
            'subject' => 'Suporte técnico',
        ]);
    }

    public function test_contact_form_validation_still_rejects_invalid_data(): void
    {
        Mail::fake();

        $this->post(route('contact.send'), [
            'name' => '',
            'email' => 'não-é-email',
            'subject' => 'Assunto inexistente',
            'message' => 'Curta',
        ])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
