@extends('layouts.frontend')
@section('title', 'My Chats')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Support Conversations</h1>
    <form action="{{ route('user.chat.start') }}" method="POST" class="mb-6 bg-white rounded shadow p-4 space-y-4">
        @csrf
        <div class="grid md:grid-cols-2 gap-3">
            <select name="category" class="px-4 py-2 border rounded" required>
                <option value="">Select support category</option>
                @foreach(\App\Models\Chat::categories() as $key => $label)
                    <option value="{{ $key }}" {{ (($prefill['category'] ?? old('category')) === $key) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="subject" class="px-4 py-2 border rounded" placeholder="Subject (optional)" value="{{ $prefill['subject'] ?? old('subject') }}">
        </div>
        <textarea name="message" class="w-full px-4 py-2 border rounded" rows="4" placeholder="Describe your issue or request..." required>{{ $prefill['message'] ?? old('message') }}</textarea>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Start Conversation</button>
    </form>
    <div class="bg-white rounded shadow p-4">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-4 text-left">Reference</th>
                    <th class="py-2 px-4 text-left">Category</th>
                    <th class="py-2 px-4 text-left">Subject</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Unread</th>
                    <th class="py-2 px-4 text-left">Last Updated</th>
                    <th class="py-2 px-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($chats as $chat)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2 px-4 font-medium">{{ $chat->reference ?? '—' }}</td>
                    <td class="py-2 px-4">{{ \App\Models\Chat::categories()[$chat->category] ?? ucfirst($chat->category ?? 'General') }}</td>
                    <td class="py-2 px-4">{{ $chat->subject ?? 'No subject' }}</td>
                    <td class="py-2 px-4">
                        <span class="inline-block px-2 py-1 rounded text-xs {{ $chat->status === \App\Models\Chat::STATUS_PENDING_ADMIN ? 'bg-amber-100 text-amber-700' : ($chat->status === \App\Models\Chat::STATUS_PENDING_STUDENT ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            {{ \App\Models\Chat::statuses()[$chat->status] ?? ucfirst($chat->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4">{{ $chat->unread_count }}</td>
                    <td class="py-2 px-4">{{ $chat->updated_at->diffForHumans() }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('user.chat.show', $chat->id) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
