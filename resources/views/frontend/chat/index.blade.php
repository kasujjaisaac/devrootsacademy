@extends('layouts.student')

@section('title', 'Messages')
@section('page_title', 'Messages')
@section('page_subtitle', 'Send a message to the support team.')

@push('styles')
<style>
    .sp-chat-wrap {
        max-width: 760px;
        margin: 0 auto;
    }

    .sp-chat-stack {
        display: grid;
        gap: 20px;
    }

    .sp-chat-form {
        display: grid;
        gap: 18px;
    }

    .sp-chat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .sp-chat-field label {
        display: block;
        margin-bottom: 8px;
        color: var(--ad-text);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .sp-chat-field select,
    .sp-chat-field input,
    .sp-chat-field textarea {
        width: 100%;
        border: 1px solid var(--ad-border);
        border-radius: 14px;
        background: #fff;
        color: var(--ad-text);
        padding: 13px 14px;
        font: inherit;
    }

    .sp-chat-field textarea {
        min-height: 180px;
        resize: vertical;
    }

    .sp-chat-field select:focus,
    .sp-chat-field input:focus,
    .sp-chat-field textarea:focus {
        outline: none;
        border-color: rgba(185, 28, 28, 0.35);
        box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.08);
    }

    .sp-chat-actions {
        display: flex;
        justify-content: flex-end;
    }

    .sp-chat-list {
        display: grid;
        gap: 12px;
    }

    .sp-chat-item {
        display: block;
        padding: 16px 18px;
        border: 1px solid var(--ad-border);
        border-radius: 14px;
        background: #fff;
        text-decoration: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .sp-chat-item:hover {
        border-color: #fecaca;
        box-shadow: 0 10px 24px rgba(127, 29, 29, 0.08);
        transform: translateY(-1px);
    }

    .sp-chat-item-top,
    .sp-chat-item-bottom {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
    }

    .sp-chat-item-top {
        margin-bottom: 8px;
    }

    .sp-chat-ref {
        color: var(--ad-primary);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .sp-chat-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 600;
    }

    .sp-chat-status.pending-admin {
        background: #fff7ed;
        color: #b45309;
    }

    .sp-chat-status.pending-student {
        background: #fef2f2;
        color: #b91c1c;
    }

    .sp-chat-status.resolved {
        background: #f0fdf4;
        color: #15803d;
    }

    .sp-chat-subject {
        margin: 0 0 4px;
        color: var(--ad-text);
        font-size: 0.98rem;
        font-weight: 600;
    }

    .sp-chat-meta,
    .sp-chat-updated {
        color: var(--ad-muted);
        font-size: 0.82rem;
    }

    .sp-chat-unread {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--ad-text);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .sp-chat-unread-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #dc2626;
    }

    .sp-chat-empty {
        color: var(--ad-muted);
        text-align: center;
        padding: 12px 0 4px;
    }

    @media (max-width: 767px) {
        .sp-chat-grid {
            grid-template-columns: 1fr;
        }

        .sp-chat-item-top,
        .sp-chat-item-bottom {
            flex-direction: column;
            align-items: flex-start;
        }

        .sp-chat-actions .btn-ad {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@php
    $categories = \App\Models\Chat::categories();
    $statuses = \App\Models\Chat::statuses();
@endphp

@section('content')
<div class="sp-chat-wrap sp-chat-stack">
    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Compose new message</h3>
        </div>
        <div class="ad-card-body">
            <form action="{{ route('user.chat.start') }}" method="POST" class="sp-chat-form">
                @csrf

                <div class="sp-chat-grid">
                    <div class="sp-chat-field">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select support category</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ (($prefill['category'] ?? old('category')) === $key) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sp-chat-field">
                        <label for="subject">Subject</label>
                        <input
                            id="subject"
                            type="text"
                            name="subject"
                            placeholder="Subject"
                            value="{{ $prefill['subject'] ?? old('subject') }}"
                        >
                        @error('subject')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="sp-chat-field">
                    <label for="message">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        placeholder="Type your message..."
                        required
                    >{{ $prefill['message'] ?? old('message') }}</textarea>
                    @error('message')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sp-chat-actions">
                    <button type="submit" class="btn-ad btn-ad-primary">
                        <i class="fas fa-paper-plane"></i> Start Conversation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Recent conversations</h3>
        </div>
        <div class="ad-card-body">
            @if($chats->isEmpty())
                <div class="sp-chat-empty">No conversations yet.</div>
            @else
                <div class="sp-chat-list">
                    @foreach($chats as $chat)
                        @php
                            $statusClass = match ($chat->status) {
                                \App\Models\Chat::STATUS_PENDING_ADMIN => 'pending-admin',
                                \App\Models\Chat::STATUS_PENDING_STUDENT => 'pending-student',
                                default => 'resolved',
                            };
                        @endphp
                        <a href="{{ route('user.chat.show', $chat->id) }}" class="sp-chat-item">
                            <div class="sp-chat-item-top">
                                <span class="sp-chat-ref">{{ $chat->reference ?? 'No reference' }}</span>
                                <span class="sp-chat-status {{ $statusClass }}">
                                    {{ $statuses[$chat->status] ?? ucfirst($chat->status) }}
                                </span>
                            </div>
                            <h4 class="sp-chat-subject">{{ $chat->subject ?: 'Conversation' }}</h4>
                            <div class="sp-chat-meta">{{ $categories[$chat->category] ?? ucfirst($chat->category ?? 'General') }}</div>
                            <div class="sp-chat-item-bottom mt-2">
                                <span class="sp-chat-unread">
                                    @if($chat->unread_count > 0)
                                        <span class="sp-chat-unread-dot"></span>
                                    @endif
                                    {{ $chat->unread_count }} unread
                                </span>
                                <span class="sp-chat-updated">Updated {{ $chat->updated_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
