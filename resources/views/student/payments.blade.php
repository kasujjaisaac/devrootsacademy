@extends('layouts.student')

@section('title', 'Student Payments')
@section('page_title', 'Payments')
@section('page_subtitle', 'View recorded payments, total fees, and your current balance.')

@section('content')
<div class="sp-grid sp-grid-3">
    <div class="sp-card">
        <div class="sp-muted">Fee Total</div>
        <div class="sp-stat-num">UGX {{ number_format($summary['fee_total'], 0) }}</div>
    </div>
    <div class="sp-card">
        <div class="sp-muted">Recorded Payments</div>
        <div class="sp-stat-num">UGX {{ number_format($summary['paid_total'], 0) }}</div>
    </div>
    <div class="sp-card">
        <div class="sp-muted">Outstanding Balance</div>
        <div class="sp-stat-num">UGX {{ number_format($summary['balance'], 0) }}</div>
    </div>
</div>

<div class="sp-card" style="margin-top:20px;">
    <h3>Payment History</h3>
    @if($payments->isEmpty())
        <div class="sp-empty">No payment records available yet.</div>
    @else
        <table class="sp-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->course?->title ?? '—' }}</td>
                        <td>UGX {{ number_format($payment->amount, 0) }}</td>
                        <td>{{ $payment->payment_method ?? '—' }}</td>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
