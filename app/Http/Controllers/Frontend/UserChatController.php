<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
    // List all chats for the logged-in user
    public function index()
    {
        $chats = Chat::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('frontend.chat.index', compact('chats'));
    }

    // Start a new chat (if none open)
    public function start(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
        ]);
        $chat = Chat::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'open'],
            ['subject' => $request->subject]
        );
        return redirect()->route('user.chat.show', $chat->id);
    }

    // Show a chat thread
    public function show($id)
    {
        $chat = Chat::with(['messages.sender', 'admin'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        if (request()->ajax()) {
            return view('frontend.chat._messages', compact('chat'))->render();
        }
        return view('frontend.chat.show', compact('chat'));
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
        $chat->touch();
        return redirect()->route('user.chat.show', $chat->id)->with('success', 'Message sent!');
    }
}
