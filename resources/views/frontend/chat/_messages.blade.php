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