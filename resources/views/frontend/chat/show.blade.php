@extends('layouts.student')

@section('title', 'Conversation')
@section('page_title', 'Messages')
@section('page_subtitle', 'View and reply to your conversation.')

@push('styles')
<style>
    .sp-thread-grid {
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        gap: 20px;
        max-width: 920px;
        margin: 0 auto;
    }

    .sp-thread-side,
    .sp-thread-main {
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: var(--ad-radius);
        box-shadow: var(--ad-shadow);
    }

    .sp-thread-side {
        padding: 20px;
        display: grid;
        gap: 14px;
        align-content: start;
    }

    .sp-thread-back {
        color: var(--ad-primary);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .sp-thread-meta {
        padding: 14px 0;
        border-bottom: 1px solid var(--ad-border);
    }

    .sp-thread-meta:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .sp-thread-label {
        display: block;
        color: var(--ad-muted);
        font-size: 0.74rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .sp-thread-value {
        color: var(--ad-text);
        font-weight: 600;
    }

    .sp-thread-main {
        overflow: hidden;
    }

    .sp-thread-head {
        padding: 20px 24px;
        border-bottom: 1px solid var(--ad-border);
    }

    .sp-thread-head h3 {
        margin: 0 0 6px;
    }

    .sp-thread-head p {
        margin: 0;
        color: var(--ad-muted);
    }

    .sp-thread-messages {
        padding: 20px 24px;
        display: grid;
        gap: 14px;
        max-height: 520px;
        overflow-y: auto;
        background: #fff;
    }

    .sp-thread-message {
        display: flex;
    }

    .sp-thread-message.from-user {
        justify-content: flex-end;
    }

    .sp-thread-message.from-support {
        justify-content: flex-start;
    }

    .sp-thread-bubble {
        max-width: min(80%, 36rem);
        border-radius: 18px;
        padding: 12px 14px;
        border: 1px solid var(--ad-border);
        background: #fff7f7;
    }

    .sp-thread-message.from-support .sp-thread-bubble {
        background: #f8fafc;
    }

    .sp-thread-meta-line {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 6px;
        color: var(--ad-muted);
        font-size: 0.74rem;
    }

    .sp-thread-bubble p {
        margin: 0;
        color: var(--ad-text);
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .sp-thread-empty {
        padding: 20px 0;
        text-align: center;
        color: var(--ad-muted);
    }

    .sp-thread-compose {
        padding: 20px 24px 24px;
        border-top: 1px solid var(--ad-border);
        background: #fff;
    }

    .sp-thread-compose textarea {
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

    .sp-thread-compose textarea:focus {
        outline: none;
        border-color: rgba(185, 28, 28, 0.35);
        box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.08);
    }

    .sp-thread-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 14px;
    }

    @media (max-width: 991px) {
        .sp-thread-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .sp-thread-head,
        .sp-thread-messages,
        .sp-thread-compose {
            padding-left: 16px;
            padding-right: 16px;
        }

        .sp-thread-actions .btn-ad {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@php
    $statuses = \App\Models\Chat::statuses();
    $categories = \App\Models\Chat::categories();
@endphp

@section('content')
<div class="sp-thread-grid">
    <aside class="sp-thread-side">
        <a href="{{ route('user.chat.index') }}" class="sp-thread-back">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>

        <div class="sp-thread-meta">
            <span class="sp-thread-label">Reference</span>
            <div class="sp-thread-value">{{ $chat->reference ?? 'No reference' }}</div>
        </div>

        <div class="sp-thread-meta">
            <span class="sp-thread-label">Category</span>
            <div class="sp-thread-value">{{ $categories[$chat->category] ?? ucfirst($chat->category ?? 'General') }}</div>
        </div>

        <div class="sp-thread-meta">
            <span class="sp-thread-label">Status</span>
            <div class="sp-thread-value">{{ $statuses[$chat->status] ?? ucfirst($chat->status) }}</div>
        </div>

        <div class="sp-thread-meta">
            <span class="sp-thread-label">Last Updated</span>
            <div class="sp-thread-value">{{ $chat->updated_at->diffForHumans() }}</div>
        </div>
    </aside>

    <section class="sp-thread-main">
        <div class="sp-thread-head">
            <h3>{{ $chat->subject ?: 'Conversation' }}</h3>
            <p>{{ $chat->admin?->full_name ?? $chat->admin?->name ?? 'DevRoots Support Team' }}</p>
        </div>

        <div id="chat-messages" class="sp-thread-messages">
            @include('frontend.chat._messages', ['chat' => $chat])
        </div>

        <div class="sp-thread-compose">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('user.chat.message', $chat->id) }}" method="POST">
                @csrf
                <textarea
                    name="message"
                    placeholder="Type your reply..."
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror

                <div class="sp-thread-actions">
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
