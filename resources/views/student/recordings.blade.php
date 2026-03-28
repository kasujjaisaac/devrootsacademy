@extends('layouts.student')

@section('title', 'Lecture Recordings')
@section('page_title', 'Lecture Recordings')
@section('page_subtitle', 'Catch up on previously uploaded class sessions for your active course.')

@section('content')
<div class="ad-card">
    <div class="ad-card-head">
        <div>
            <h3 style="margin:0;">Your Class Recordings</h3>
            <p style="margin:6px 0 0;color:var(--ad-muted);">New cards appear here only after an admin or academic lead adds a recording for one of your active courses.</p>
        </div>
    </div>
    <div class="ad-card-body">
        @if($recordings->isEmpty())
            <div class="sp-empty">No lecture recordings are available for your active course yet.</div>
        @else
            <div class="sr-recording-grid">
                @foreach($recordings as $recording)
                    <a href="{{ $recording->google_drive_url }}" target="_blank" rel="noopener noreferrer" class="sr-recording-card">
                        <span class="sr-recording-date">{{ $recording->class_date->format('M d, Y') }}</span>
                        <div class="sr-recording-top">
                            <span class="sr-recording-pill">{{ $recording->course?->title ?? 'Course' }}</span>
                            <span class="sr-recording-link"><i class="fas fa-arrow-up-right-from-square"></i></span>
                        </div>
                        <div class="sr-recording-icon">
                            <i class="fas fa-circle-play"></i>
                        </div>
                        <h4>{{ $recording->title }}</h4>
                        <p>{{ $recording->topic ?: 'Open this class recording in Google Drive.' }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .sr-recording-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:18px;
    }
    .sr-recording-card{
        position:relative;
        display:block;
        min-height:210px;
        padding:18px;
        border-radius:20px;
        border:1px solid rgba(195, 33, 48, 0.1);
        background:
            linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(255,248,248,1) 100%);
        color:inherit;
        text-decoration:none;
        overflow:hidden;
        transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .sr-recording-card:hover{
        transform:translateY(-4px);
        border-color:rgba(195, 33, 48, 0.22);
        box-shadow:0 22px 40px rgba(20, 20, 43, 0.08);
    }
    .sr-recording-top{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:22px;
    }
    .sr-recording-pill{
        display:inline-flex;
        align-items:center;
        padding:7px 11px;
        border-radius:999px;
        background:rgba(195, 33, 48, 0.08);
        color:#a2353f;
        font-size:.74rem;
        font-weight:600;
    }
    .sr-recording-link{
        color:#c32130;
        font-size:.85rem;
    }
    .sr-recording-icon{
        width:48px;
        height:48px;
        border-radius:16px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#c32130;
        color:#fff;
        margin-bottom:18px;
        box-shadow:0 14px 24px rgba(195, 33, 48, 0.2);
    }
    .sr-recording-card h4{
        margin:0 0 8px;
        font-size:1rem;
        color:#14142b;
    }
    .sr-recording-card p{
        margin:0;
        color:#6b7280;
        line-height:1.55;
        font-size:.9rem;
    }
    .sr-recording-date{
        position:absolute;
        right:16px;
        bottom:16px;
        padding:7px 10px;
        border-radius:999px;
        background:#14142b;
        color:#fff;
        font-size:.72rem;
        font-weight:600;
        opacity:0;
        transform:translateY(6px);
        transition:opacity .18s ease, transform .18s ease;
    }
    .sr-recording-card:hover .sr-recording-date{
        opacity:1;
        transform:translateY(0);
    }
</style>
@endpush
