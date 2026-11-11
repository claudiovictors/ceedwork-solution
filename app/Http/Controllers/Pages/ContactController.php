<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Support\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(private readonly PageContent $pageContent) {}

    public function show(): View
    {
        return view('pages.contact', ['subjects' => $this->subjects()]);
    }

    /**
     * @return array<int, string>
     */
    private function subjects(): array
    {
        return collect($this->pageContent->get('contact', 'subjects', 'items', []))
            ->pluck('subject')
            ->filter()
            ->values()
            ->all();
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
            'subject' => ['required', Rule::in($this->subjects())],
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

        ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
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
