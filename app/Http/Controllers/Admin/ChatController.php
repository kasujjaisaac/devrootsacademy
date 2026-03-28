<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::with(['user', 'admin'])
            ->withCount([
                'messages as unread_count' => fn ($query) => $query
                    ->where('is_admin', false)
                    ->whereNull('read_at'),
            ])
            ->orderByDesc('unread_count')
            ->orderByDesc('last_message_at')
            ->latest()
            ->paginate(10);
        return view('admin.chats.index', compact('chats'));
    }

    public function show($id)
    {
        $chat = Chat::with(['user', 'admin', 'messages.sender'])
            ->findOrFail($id);

        $chat->messages()
            ->where('is_admin', false)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $chat->load(['user', 'admin', 'messages.sender']);

        if (request()->ajax()) {
            return view('admin.chats._messages', compact('chat'))->render();
        }
        return view('admin.chats.show', compact('chat'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        $chat = Chat::findOrFail($id);
        $admin = Auth::user();
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $admin->id,
            'message' => $request->message,
            'is_admin' => true,
            'read_at' => now(),
        ]);
        $chat->admin_id = $admin->id;
        $chat->status = Chat::STATUS_PENDING_STUDENT;
        $chat->resolved_at = null;
        $chat->last_message_at = now();
        $chat->save();
        $chat->load('user');
        $this->logAction($request, $chat, 'chat.admin_replied', 'Admin replied in support conversation.');

        return redirect()->route('admin.chats.show', $chat->id)->with('success', 'Message sent!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:'.implode(',', array_keys(Chat::statuses())),
        ]);

        $chat = Chat::findOrFail($id);
        $chat->status = $request->status;
        $chat->resolved_at = $request->status === Chat::STATUS_RESOLVED ? now() : null;
        $chat->save();
        $chat->load('user');
        $this->logAction($request, $chat, 'chat.status_updated', 'Updated support conversation status.');

        return redirect()->route('admin.chats.show', $chat->id)->with('success', 'Conversation status updated.');
    }

    public function assignToMe($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->admin_id = Auth::id();
        $chat->save();
        $chat->load('user');
        $this->logAction(request(), $chat, 'chat.assigned', 'Assigned support conversation.');

        return redirect()->route('admin.chats.show', $chat->id)->with('success', 'Conversation assigned to you.');
    }

    protected function logAction(Request $request, Chat $chat, string $action, string $description): void
    {
        AuditLogger::log(
            $action,
            $description,
            actor: $request->user(),
            targetUser: $chat->user,
            metadata: [
                'chat_id' => $chat->id,
                'reference' => $chat->reference,
                'status' => $chat->status,
            ],
            request: $request,
        );
    }
}
