<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $unreadOnly = $request->query('filtre') === 'okunmamis';

        return view('admin.messages.index', [
            'unreadOnly' => $unreadOnly,
            'messages' => ContactMessage::query()
                ->when($unreadOnly, fn ($query) => $query->unread())
                ->latest()
                ->latest('id')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function show(ContactMessage $message): View
    {
        $message->markAsRead();

        return view('admin.messages.show', ['message' => $message]);
    }

    public function markAsUnread(ContactMessage $message): RedirectResponse
    {
        $message->markAsUnread();

        return redirect()->route('admin.messages.index')->with('status', 'Mesaj okunmadı olarak işaretlendi.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Mesaj silindi.');
    }
}
