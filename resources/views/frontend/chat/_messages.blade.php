@forelse($chat->messages as $message)
    <article class="sp-thread-message {{ $message->is_admin ? 'from-support' : 'from-user' }}">
        <div class="sp-thread-bubble">
            <div class="sp-thread-meta-line">
                <span>
                    {{ $message->sender->full_name ?? $message->sender->name ?? ($message->is_admin ? 'DevRoots Support' : 'You') }}
                    {{ $message->is_admin ? '• Team' : '• Student' }}
                </span>
                <span>{{ $message->created_at->diffForHumans() }}</span>
            </div>
            <p>{{ $message->message }}</p>
        </div>
    </article>
@empty
    <div class="sp-thread-empty">
        <i class="fas fa-comments"></i>
        <p>No messages yet. Start the conversation below.</p>
    </div>
@endforelse
