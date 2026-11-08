<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    /** Assuntos do formulário (usados no select e na validação) */
    public const SUBJECTS = [
        'Pedido de orçamento',
        'Suporte técnico',
        'Parcerias',
        'Dúvidas gerais',
        'Outro',
    ];

    public function show(): View
    {
        return view('pages.contact', ['subjects' => self::SUBJECTS]);
    }

    public function send(Request $request): RedirectResponse
    {
        // Honeypot: bots preenchem este campo escondido, pessoas não
        if ($request->filled('website')) {
            return back()->with('success', 'Mensagem enviada com sucesso!');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\s()\-]{7,30}$/'],
            'subject' => ['required', Rule::in(self::SUBJECTS)],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'Indique um email válido.',
            'max' => 'O campo :attribute é demasiado longo.',
            'min' => 'A mensagem deve ter pelo menos :min caracteres.',
            'in' => 'Escolha um assunto da lista.',
            'regex' => 'Indique um número de telefone válido.',
        ], [
            'name' => 'nome',
            'email' => 'email',
            'phone' => 'telefone',
            'subject' => 'assunto',
            'message' => 'mensagem',
        ]);

        $body = implode("\n", [
            'Nova mensagem pelo site da Ceedwork',
            '',
            'Nome: '.$data['name'],
            'Email: '.$data['email'],
            'Telefone: '.($data['phone'] ?? '—'),
            'Assunto: '.$data['subject'],
            '',
            'Mensagem:',
            $data['message'],
            '',
            'IP: '.$request->ip(),
        ]);

        try {
            Mail::raw($body, function ($message) use ($data) {
                $message->to(config('mail.from.address'))
                    ->replyTo($data['email'], $data['name'])
                    ->subject('[Site] '.$data['subject']);
            });
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Não foi possível enviar a mensagem agora. Tente novamente ou contacte-nos por telefone.');
        }

        return back()->with('success', 'Mensagem enviada com sucesso! Entraremos em contacto em breve.');
    }
}
