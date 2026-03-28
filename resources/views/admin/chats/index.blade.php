@extends('layouts.admin')
@section('title', 'Messages')

@push('styles')
<style>
    .ad-chat-stack {
        display: grid;
        gap: 20px;
    }

    .ad-chat-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
        gap: 20px;
    }

    .ad-chat-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .ad-chat-stat {
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: var(--ad-radius);
        box-shadow: var(--ad-shadow);
        padding: 18px 20px;
    }

    .ad-chat-stat-label {
        color: var(--ad-muted);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .ad-chat-stat strong {
        display: block;
        color: var(--ad-text);
        font-size: 1.75rem;
        line-height: 1;
    }

    .ad-chat-note {
        background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 58%, #ef4444 100%);
        color: #fff;
        border-radius: var(--ad-radius);
        box-shadow: 0 18px 45px rgba(185, 28, 28, 0.22);
        padding: 22px 24px;
    }

    .ad-chat-note h3 {
        margin: 0 0 8px;
        font-size: 1.15rem;
    }

    .ad-chat-note p {
        margin: 0;
        color: rgba(255,255,255,0.84);
        line-height: 1.7;
    }

    .ad-chat-list {
        display: grid;
        gap: 14px;
    }

    .ad-chat-item {
        display: block;
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: 18px;
        box-shadow: var(--ad-shadow);
        padding: 18px 20px;
        text-decoration: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .ad-chat-item:hover {
        transform: translateY(-1px);
        border-color: #fecaca;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
    }

    .ad-chat-item-top,
    .ad-chat-item-bottom {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        align-items: center;
    }

    .ad-chat-item-top {
        margin-bottom: 10px;
    }

    .ad-chat-reference {
        color: var(--ad-primary);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .ad-chat-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 600;
    }

    .ad-chat-status.pending-admin {
        background: #fff7ed;
        color: #b45309;
    }

    .ad-chat-status.pending-student {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .ad-chat-status.resolved {
        background: #f0fdf4;
        color: #15803d;
    }

    .ad-chat-subject {
        margin: 0 0 6px;
        color: var(--ad-text);
        font-size: 1rem;
        font-weight: 600;
    }

    .ad-chat-meta,
    .ad-chat-updated {
        color: var(--ad-muted);
        font-size: 0.82rem;
    }

    .ad-chat-unread {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--ad-text);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .ad-chat-unread-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #dc2626;
    }

    @media (max-width: 1100px) {
        .ad-chat-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .ad-chat-summary {
            grid-template-columns: 1fr;
        }

        .ad-chat-item-top,
        .ad-chat-item-bottom {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@php
    $pendingAdminCount = $chats->getCollection()->where('status', \App\Models\Chat::STATUS_PENDING_ADMIN)->count();
    $pendingStudentCount = $chats->getCollection()->where('status', \App\Models\Chat::STATUS_PENDING_STUDENT)->count();
    $statuses = \App\Models\Chat::statuses();
    $categories = \App\Models\Chat::categories();
@endphp

@section('content')
<div class="ad-chat-stack">
    <div class="ad-chat-hero">
        <div class="ad-chat-summary">
            <div class="ad-chat-stat">
                <div class="ad-chat-stat-label">Open Threads</div>
                <strong>{{ $chats->total() }}</strong>
            </div>
            <div class="ad-chat-stat">
                <div class="ad-chat-stat-label">Waiting On Admin</div>
                <strong>{{ $pendingAdminCount }}</strong>
            </div>
            <div class="ad-chat-stat">
                <div class="ad-chat-stat-label">Waiting On Student</div>
                <strong>{{ $pendingStudentCount }}</strong>
            </div>
        </div>

        <div class="ad-chat-note">
            <h3>Support Inbox</h3>
            <p>Messages are ordered by unread student activity first, then by the most recent conversation updates.</p>
        </div>
    </div>

    <div class="ad-chat-list">
        @foreach($chats as $chat)
            @php
                $statusClass = match ($chat->status) {
                    \App\Models\Chat::STATUS_PENDING_ADMIN => 'pending-admin',
                    \App\Models\Chat::STATUS_PENDING_STUDENT => 'pending-student',
                    default => 'resolved',
                };
            @endphp

            <a href="{{ route('admin.chats.show', $chat->id) }}" class="ad-chat-item">
                <div class="ad-chat-item-top">
                    <span class="ad-chat-reference">{{ $chat->reference ?? 'No reference' }}</span>
                    <span class="ad-chat-status {{ $statusClass }}">
                        {{ $statuses[$chat->status] ?? ucfirst($chat->status) }}
                    </span>
                </div>

                <h3 class="ad-chat-subject">{{ $chat->subject ?: 'Conversation' }}</h3>
                <div class="ad-chat-meta">
                    {{ $chat->user->full_name ?? $chat->user->name ?? 'User' }} •
                    {{ $categories[$chat->category] ?? ucfirst($chat->category ?? 'General') }} •
                    {{ $chat->admin->name ?? 'Unassigned' }}
                </div>

                <div class="ad-chat-item-bottom mt-3">
                    <span class="ad-chat-unread">
                        @if($chat->unread_count > 0)
                            <span class="ad-chat-unread-dot"></span>
                        @endif
                        {{ $chat->unread_count }} unread
                    </span>
                    <span class="ad-chat-updated">Updated {{ $chat->updated_at->diffForHumans() }}</span>
                </div>
            </a>
        @endforeach
    </div>

    <div>{{ $chats->links() }}</div>
</div>
@endsection
