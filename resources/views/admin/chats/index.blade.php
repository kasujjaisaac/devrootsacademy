@extends('layouts.admin')
@section('title', 'Chats')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold">Chats</h1>
    <p class="text-gray-500">All user-admin conversations</p>
</div>
<div class="bg-white rounded shadow p-4">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2 px-4 text-left">User</th>
                <th class="py-2 px-4 text-left">Subject</th>
                <th class="py-2 px-4 text-left">Status</th>
                <th class="py-2 px-4 text-left">Last Updated</th>
                <th class="py-2 px-4"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($chats as $chat)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $chat->user->full_name ?? $chat->user->name ?? 'User' }}</td>
                <td class="py-2 px-4">{{ $chat->subject ?? 'No subject' }}</td>
                <td class="py-2 px-4">
                    <span class="inline-block px-2 py-1 rounded text-xs {{ $chat->status == 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                        {{ ucfirst($chat->status) }}
                    </span>
                </td>
                <td class="py-2 px-4">{{ $chat->updated_at->diffForHumans() }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.chats.show', $chat->id) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $chats->links() }}</div>
</div>
@endsection
