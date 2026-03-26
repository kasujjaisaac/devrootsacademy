@extends('layouts.frontend')
@section('title', 'Chat')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Support Conversation</h1>
    <div class="bg-white rounded shadow p-4 mb-6">
        <div class="mb-4 pb-4 border-b">
            <div class="font-semibold">{{ $chat->subject ?? 'No subject' }}</div>
            <div class="text-sm text-gray-500">
                {{ $chat->reference ?? '—' }} • {{ \App\Models\Chat::categories()[$chat->category] ?? ucfirst($chat->category ?? 'General') }} • {{ \App\Models\Chat::statuses()[$chat->status] ?? ucfirst($chat->status) }}
            </div>
        </div>
        <div id="chat-messages" class="space-y-4 max-h-96 overflow-y-auto">
            @foreach($chat->messages as $message)
                <div class="flex {{ $message->is_admin ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs px-4 py-2 rounded-lg {{ $message->is_admin ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        <div class="text-xs text-gray-400 mb-1">
                            {{ $message->sender->full_name ?? $message->sender->name ?? ($message->is_admin ? 'Admin' : 'You') }}
                            • {{ $message->created_at->diffForHumans() }}
                        </div>
                        <div>{{ $message->message }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        @push('scripts')
        <script>
        function fetchMessages() {
            fetch(window.location.href + '?ajax=1')
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMessages = doc.querySelector('#chat-messages');
                    if (newMessages) {
                        document.getElementById('chat-messages').innerHTML = newMessages.innerHTML;
                    }
                });
        }
        setInterval(fetchMessages, 3000);
        </script>
        @endpush
        <form action="{{ route('user.chat.message', $chat->id) }}" method="POST" class="mt-6 flex gap-2">
            @csrf
            <input type="text" name="message" class="flex-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Reply</button>
        </form>
    </div>
    <a href="{{ route('user.chat.index') }}" class="text-blue-600 hover:underline">&larr; Back to all chats</a>
</div>
@endsection
