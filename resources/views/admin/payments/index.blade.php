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
    <div style="font-size:0.8125rem;color:var(--ad-muted);align-self:center;">
        {{ $payments->total() }} total records
    </div>
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

{{-- Payments Table Card --}}
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
                    <th>Amount (UGX)</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payments->firstItem() + $loop->index }}</td>
                    <td>{{ $payment->student->full_name ?? 'N/A' }}</td>
                    <td>UGX {{ number_format($payment->amount, 0) }}</td>
                    <td>{{ $payment->payment_method ?? '-' }}</td>
                    <td>
                        @php $ps = $payment->status ?? 'pending'; @endphp
                        <span class="ad-badge
                            {{ $ps === 'paid' ? 'ad-badge-active' : ($ps === 'failed' ? 'ad-badge-rejected' : 'ad-badge-pending') }}">
                            {{ ucfirst($ps) }}
                        </span>
                    </td>
                    <td>{{ $payment->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="ad-table-empty">
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
