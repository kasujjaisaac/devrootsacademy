@extends('layouts.admin')
@section('title', 'Payments')

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Payments</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Payments</span>
        </nav>
    </div>
    <a href="{{ route('admin.payments.create') }}" class="btn-ad btn-ad-primary">
        <i class="fas fa-plus"></i> Record Payment
    </a>
</div>

{{-- Session Alerts --}}
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

<div class="ad-stats-row">
    <div class="ad-stat-card blue">
        <div>
            <div class="ad-stat-num">{{ $stats['total'] }}</div>
            <div class="ad-stat-lbl">Total Payments</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-credit-card"></i></div>
    </div>
    <div class="ad-stat-card green">
        <div>
            <div class="ad-stat-num">{{ $stats['completed'] }}</div>
            <div class="ad-stat-lbl">Completed</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-circle-check"></i></div>
    </div>
    <div class="ad-stat-card orange">
        <div>
            <div class="ad-stat-num">{{ $stats['pending'] }}</div>
            <div class="ad-stat-lbl">Pending</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-clock"></i></div>
    </div>
    <div class="ad-stat-card purple">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($stats['completed_amount'], 0) }}</div>
            <div class="ad-stat-lbl">Completed Value</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-wallet"></i></div>
    </div>
</div>

<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="paymentsTable" placeholder="Search payments...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="paymentsTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Amount (UGX)</th>
                    <th>Method</th>
                    <th>Gateway</th>
                    <th>Reference</th>
                    <th>Status</th>
                    <th>Paid At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payments->firstItem() + $loop->index }}</td>
                    <td>{{ $payment->student->full_name ?? 'N/A' }}</td>
                    <td>{{ $payment->course->title ?? 'N/A' }}</td>
                    <td>UGX {{ number_format($payment->amount, 0) }}</td>
                    <td>{{ $payment->payment_method ?? '-' }}</td>
                    <td>{{ strtoupper($payment->gateway ?? 'manual') }}</td>
                    <td>{{ $payment->reference ?? '—' }}</td>
                    <td>
                        @php $ps = $payment->status ?? 'pending'; @endphp
                        <span class="ad-badge
                            {{ $ps === 'completed' ? 'ad-badge-active' : ($ps === 'failed' || $ps === 'cancelled' || $ps === 'reversed' ? 'ad-badge-rejected' : 'ad-badge-pending') }}">
                            {{ ucfirst($ps) }}
                        </span>
                    </td>
                    <td>{{ $payment->paid_at?->format('M d, Y g:i A') ?? $payment->created_at->format('M d, Y g:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="ad-table-empty">
                        <i class="fas fa-credit-card"></i>
                        No payment records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
    <div style="padding:12px 16px;border-top:1px solid var(--ad-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <span style="font-size:0.75rem;color:var(--ad-muted);">
            Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} records
        </span>
        {{ $payments->links() }}
    </div>
    @endif
</div>

@endsection
