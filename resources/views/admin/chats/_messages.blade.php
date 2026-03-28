@forelse($chat->messages as $message)
    <article class="ad-thread-message {{ $message->is_admin ? 'from-admin' : 'from-student' }}">
        <div class="ad-thread-bubble">
            <div class="ad-thread-meta-line">
                <span>
                    {{ $message->sender->full_name ?? $message->sender->name ?? 'User' }}
                    {{ $message->is_admin ? '• Admin' : '• Student' }}
                </span>
                <span>{{ $message->created_at->diffForHumans() }}</span>
            </div>
            <p>{{ $message->message }}</p>
        </div>
    </article>
@empty
    <div class="ad-thread-empty">
        <i class="fas fa-comments"></i>
        <p>No messages yet.</p>
    </div>
@endforelse
