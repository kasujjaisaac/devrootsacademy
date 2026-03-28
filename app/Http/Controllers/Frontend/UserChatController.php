<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Notifications\AdminActivityNotification;
use App\Support\AccessControl;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserChatController extends Controller
{
    // List all chats for the logged-in user
    public function index()
    {
        $student = Auth::user()?->student;

        $chats = Chat::where('user_id', Auth::id())
            ->withCount([
                'messages as unread_count' => fn ($query) => $query
                    ->where('is_admin', true)
                    ->whereNull('read_at'),
            ])
            ->orderByDesc('last_message_at')
            ->latest()
            ->get();

        $prefill = [
            'category' => request()->query('category'),
            'subject' => request()->query('subject'),
            'message' => request()->query('message'),
        ];

        return view('frontend.chat.index', compact('chats', 'prefill', 'student'));
    }

    public function start(Request $request)
    {
        $request->validate([
            'category' => 'required|in:'.implode(',', array_keys(Chat::categories())),
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $chat = Chat::create([
            'user_id' => Auth::id(),
            'reference' => $this->reference(),
            'subject' => $request->subject,
            'category' => $request->category,
            'priority' => 'normal',
            'status' => Chat::STATUS_PENDING_ADMIN,
            'last_message_at' => now(),
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false,
        ]);

        AdminNotifier::sendToPermission(
            AccessControl::MANAGE_MESSAGES,
            new AdminActivityNotification(
                'New student support conversation',
                'A new support conversation was started by '.(Auth::user()->name ?? 'a student').'.',
                route('admin.chats.show', $chat->id),
                ['type' => 'chat', 'chat_id' => $chat->id],
            )
        );

        return redirect()->route('user.chat.show', $chat->id);
    }

    // Show a chat thread
    public function show($id)
    {
        $student = Auth::user()?->student;

        $chat = Chat::with(['messages.sender', 'admin'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $chat->messages()
            ->where('is_admin', true)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $chat->load(['messages.sender', 'admin']);

        if (request()->ajax()) {
            return view('frontend.chat._messages', compact('chat'))->render();
        }
        return view('frontend.chat.show', compact('chat', 'student'));
    }

    // Send a message in a chat
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        $chat = Chat::where('user_id', Auth::id())->findOrFail($id);
        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false,
        ]);
        $chat->update([
            'status' => Chat::STATUS_PENDING_ADMIN,
            'resolved_at' => null,
            'last_message_at' => now(),
        ]);

        AdminNotifier::sendToPermission(
            AccessControl::MANAGE_MESSAGES,
            new AdminActivityNotification(
                'Student replied in support chat',
                'New unread student message in '.$chat->reference.'.',
                route('admin.chats.show', $chat->id),
                ['type' => 'chat', 'chat_id' => $chat->id],
            )
        );

        return redirect()->route('user.chat.show', $chat->id)->with('success', 'Message sent!');
    }

    protected function reference(): string
    {
        return 'SUP-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
    }
}
