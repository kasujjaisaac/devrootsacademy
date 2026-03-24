@extends('layouts.admin')
@section('title', 'Partners')

@section('content')

<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Partners</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Partners</span>
        </nav>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="btn-ad btn-ad-primary">
        <i class="fas fa-plus"></i> Add Partner
    </a>
</div>

@if(session('success'))
<div class="ad-alert ad-alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if(session('error'))
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="partnersTable" placeholder="Search partners...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="partnersTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Partner</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="cell-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <img src="{{ $partner->logo_url }}"
                                 alt="{{ $partner->name }}"
                                 style="width:48px;height:48px;object-fit:contain;border:1px solid var(--ad-border);padding:6px;background:#fff;">
                            <div>
                                <div style="font-weight:600;">{{ $partner->name }}</div>
                                <div style="font-size:0.75rem;color:var(--ad-muted);">{{ $partner->website_url ?: $partner->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $partner->category ?: '-' }}</td>
                    <td>{{ $partner->sort_order }}</td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <span style="display:inline-flex;align-items:center;padding:4px 8px;border-radius:999px;font-size:0.75rem;font-weight:600;background:{{ $partner->is_active ? '#dcfce7' : '#e5e7eb' }};color:{{ $partner->is_active ? '#166534' : '#374151' }};">
                                {{ $partner->is_active ? 'Active' : 'Hidden' }}
                            </span>
                            @if($partner->is_featured)
                                <span style="display:inline-flex;align-items:center;padding:4px 8px;border-radius:999px;font-size:0.75rem;font-weight:600;background:#dbeafe;color:#1d4ed8;">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn-ad btn-ad-outline btn-ad-sm">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-ad btn-ad-danger btn-ad-sm" data-confirm-delete>
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="ad-table-empty">
                        <i class="fas fa-handshake"></i>
                        No partners found. <a href="{{ route('admin.partners.create') }}" style="color:var(--ad-primary);">Add a partner</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
