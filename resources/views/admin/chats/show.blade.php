@extends('layouts.admin')
@section('title', 'Conversation')

@push('styles')
<style>
    .ad-thread-grid {
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 20px;
        max-width: 1080px;
        margin: 0 auto;
    }

    .ad-thread-side,
    .ad-thread-main {
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: var(--ad-radius);
        box-shadow: var(--ad-shadow);
    }

    .ad-thread-side {
        padding: 20px;
        display: grid;
        gap: 14px;
        align-content: start;
    }

    .ad-thread-back {
        color: var(--ad-primary);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .ad-thread-meta {
        padding: 14px 0;
        border-bottom: 1px solid var(--ad-border);
    }

    .ad-thread-meta:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .ad-thread-label {
        display: block;
        color: var(--ad-muted);
        font-size: 0.74rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .ad-thread-value {
        color: var(--ad-text);
        font-weight: 600;
    }

    .ad-thread-main {
        overflow: hidden;
    }

    .ad-thread-head {
        padding: 20px 24px;
        border-bottom: 1px solid var(--ad-border);
    }

    .ad-thread-head h2 {
        margin: 0 0 6px;
        font-size: 1.2rem;
    }

    .ad-thread-head p {
        margin: 0;
        color: var(--ad-muted);
    }

    .ad-thread-controls {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 12px;
        padding: 18px 24px;
        border-bottom: 1px solid var(--ad-border);
        background: #fcfcfd;
    }

    .ad-thread-status-form {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .ad-thread-status-form select {
        min-width: 180px;
        border: 1px solid var(--ad-border);
        border-radius: 12px;
        background: #fff;
        color: var(--ad-text);
        padding: 11px 12px;
        font: inherit;
    }

    .ad-thread-messages {
        padding: 20px 24px;
        display: grid;
        gap: 14px;
        max-height: 520px;
        overflow-y: auto;
        background: #fff;
    }

    .ad-thread-message {
        display: flex;
    }

    .ad-thread-message.from-admin {
        justify-content: flex-end;
    }

    .ad-thread-message.from-student {
        justify-content: flex-start;
    }

    .ad-thread-bubble {
        max-width: min(80%, 36rem);
        border-radius: 18px;
        padding: 12px 14px;
        border: 1px solid var(--ad-border);
        background: #eff6ff;
    }

    .ad-thread-message.from-student .ad-thread-bubble {
        background: #f8fafc;
    }

    .ad-thread-meta-line {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 6px;
        color: var(--ad-muted);
        font-size: 0.74rem;
    }

    .ad-thread-bubble p {
        margin: 0;
        color: var(--ad-text);
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .ad-thread-empty {
        padding: 20px 0;
        text-align: center;
        color: var(--ad-muted);
    }

    .ad-thread-compose {
        padding: 20px 24px 24px;
        border-top: 1px solid var(--ad-border);
        background: #fff;
    }

    .ad-thread-compose textarea {
        width: 100%;
        min-height: 120px;
        border: 1px solid var(--ad-border);
        border-radius: 14px;
        background: #fff;
        color: var(--ad-text);
        padding: 13px 14px;
        font: inherit;
        resize: vertical;
    }

    .ad-thread-compose textarea:focus,
    .ad-thread-status-form select:focus {
        outline: none;
        border-color: rgba(185, 28, 28, 0.35);
        box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.08);
    }

    .ad-thread-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 14px;
    }

    @media (max-width: 991px) {
        .ad-thread-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .ad-thread-controls {
            grid-template-columns: 1fr;
        }

        .ad-thread-head,
        .ad-thread-controls,
        .ad-thread-messages,
        .ad-thread-compose {
            padding-left: 16px;
            padding-right: 16px;
        }

        .ad-thread-meta-line,
        .ad-thread-status-form {
            flex-direction: column;
            align-items: flex-start;
        }

        .ad-thread-actions .btn-ad,
        .ad-thread-controls .btn-ad {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@php($categories = \App\Models\Chat::categories())

@section('content')
<div class="ad-thread-grid">
    <aside class="ad-thread-side">
        <a href="{{ route('admin.chats.index') }}" class="ad-thread-back">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>

        <div class="ad-thread-meta">
            <span class="ad-thread-label">Reference</span>
            <div class="ad-thread-value">{{ $chat->reference ?? 'No reference' }}</div>
        </div>

        <div class="ad-thread-meta">
            <span class="ad-thread-label">Student</span>
            <div class="ad-thread-value">{{ $chat->user->full_name ?? $chat->user->name ?? 'User' }}</div>
        </div>

        <div class="ad-thread-meta">
            <span class="ad-thread-label">Category</span>
            <div class="ad-thread-value">{{ $categories[$chat->category] ?? ucfirst($chat->category ?? 'General') }}</div>
        </div>

        <div class="ad-thread-meta">
            <span class="ad-thread-label">Assigned Admin</span>
            <div class="ad-thread-value">{{ $chat->admin->name ?? 'Unassigned' }}</div>
        </div>

        <div class="ad-thread-meta">
            <span class="ad-thread-label">Last Updated</span>
            <div class="ad-thread-value">{{ $chat->updated_at->diffForHumans() }}</div>
        </div>
    </aside>

    <section class="ad-thread-main">
        <div class="ad-thread-head">
            <h2>{{ $chat->subject ?: 'Conversation' }}</h2>
            <p>{{ $chat->reference ?? '—' }} • {{ $categories[$chat->category] ?? ucfirst($chat->category ?? 'General') }}</p>
        </div>

        <div class="ad-thread-controls">
            <form action="{{ route('admin.chats.status', $chat->id) }}" method="POST" class="ad-thread-status-form">
                @csrf
                <select name="status">
                    @foreach(\App\Models\Chat::statuses() as $value => $label)
                        <option value="{{ $value }}" {{ $chat->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-ad btn-ad-outline">
                    <i class="fas fa-rotate"></i> Update Status
                </button>
            </form>

            <form action="{{ route('admin.chats.assign', $chat->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-ad btn-ad-primary">
                    <i class="fas fa-user-check"></i> Assign to Me
                </button>
            </form>
        </div>

        <div id="chat-messages" class="ad-thread-messages">
            @include('admin.chats._messages', ['chat' => $chat])
        </div>

        <div class="ad-thread-compose">
            <form action="{{ route('admin.chats.message', $chat->id) }}" method="POST">
                @csrf
                <textarea name="message" placeholder="Type your reply..." required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror

                <div class="ad-thread-actions">
                    <button type="submit" class="btn-ad btn-ad-primary">
                        <i class="fas fa-paper-plane"></i> Send Reply
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const chatMessages = document.getElementById('chat-messages');

        if (!chatMessages) {
            return;
        }

        const scrollToBottom = () => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };

        const fetchMessages = async () => {
            try {
                const response = await fetch(window.location.href + '?ajax=1', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    return;
                }

                const html = await response.text();
                chatMessages.innerHTML = html;
                scrollToBottom();
            } catch (error) {
                console.error('Unable to refresh chat messages.', error);
            }
        };

        scrollToBottom();
        window.setInterval(fetchMessages, 3000);
    })();
</script>
@endpush
