@extends('layouts.frontend')
@section('title', 'My Chats')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">My Chats</h1>
    <form action="{{ route('user.chat.start') }}" method="POST" class="mb-6 flex gap-2">
        @csrf
        <input type="text" name="subject" class="flex-1 px-4 py-2 border rounded" placeholder="Start a new chat (optional subject)">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Start</button>
    </form>
    <div class="bg-white rounded shadow p-4">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-4 text-left">Subject</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Last Updated</th>
                    <th class="py-2 px-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($chats as $chat)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $chat->subject ?? 'No subject' }}</td>
                    <td class="py-2 px-4">
                        <span class="inline-block px-2 py-1 rounded text-xs {{ $chat->status == 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ ucfirst($chat->status) }}
                        </span>
                    </td>
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
