use App\Models\Message;
use Illuminate\Support\Facades\Auth;
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Show all chats (latest first)
    public function index()
    {
        $chats = Chat::with(['user', 'admin'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('admin.chats.index', compact('chats'));
    }

    // Show a single chat with messages
    public function show($id)
    {
        $chat = Chat::with(['user', 'admin', 'messages.sender'])
            ->findOrFail($id);
        if (request()->ajax()) {
            return view('admin.chats._messages', compact('chat'))->render();
        }
        return view('admin.chats.show', compact('chat'));
    }

    // Handle admin sending a message
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
        ]);
        $chat->admin_id = $admin->id;
        $chat->touch();
        $chat->save();
        // (Optional) trigger notification/event here
        return redirect()->route('admin.chats.show', $chat->id)->with('success', 'Message sent!');
    }
}
