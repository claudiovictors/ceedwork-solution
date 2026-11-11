<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Lista as mensagens recebidas pelo formulário de contacto.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', '');

        $messages = ContactMessage::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($status === 'unread', fn (Builder $query) => $query->unread())
            ->when($status === 'read', fn (Builder $query) => $query->read())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'search' => $search,
            'status' => $status,
            'unreadCount' => ContactMessage::query()->unread()->count(),
        ]);
    }

    /**
     * Exibe uma mensagem e marca-a como lida.
     */
    public function show(ContactMessage $message): View
    {
        $message->markAsRead();

        return view('admin.messages.show', [
            'message' => $message,
        ]);
    }

    /**
     * Alterna o estado de leitura de uma mensagem.
     */
    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        if ($message->read_at !== null) {
            $message->markAsUnread();
        } else {
            $message->markAsRead();
        }

        return back()->with(
            'status',
            $message->read_at !== null
                ? 'Mensagem marcada como lida.'
                : 'Mensagem marcada como não lida.'
        );
    }

    /**
     * Remove uma mensagem.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('status', 'Mensagem eliminada com sucesso.');
    }
}
