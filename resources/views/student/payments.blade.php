@extends('layouts.student')

@section('title', 'Student Payments')
@section('page_title', 'Payments')
@section('page_subtitle', 'View recorded payments, total fees, and your current balance.')

@section('content')
<div class="sp-hero">
    <div class="ad-card sp-hero-card">
        <div class="ad-card-body">
            <h2>Payment Overview</h2>
            <p>Review your recorded tuition payments, expected fees, and outstanding balance across your active learning journey.</p>
            <div class="sp-hero-meta">
                <span class="sp-chip"><i class="fas fa-wallet"></i> Balance UGX {{ number_format($summary['balance'], 0) }}</span>
                <span class="sp-chip"><i class="fas fa-credit-card"></i> {{ $payments->count() }} payment records</span>
            </div>
        </div>
    </div>

    <div class="ad-card sp-quick-card">
        <div class="ad-card-body">
            <div class="sp-quick-label">Billing Snapshot</div>
            <div class="sp-quick-list">
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Student Number</div>
                        <strong>{{ $student->student_number ?? 'Pending assignment' }}</strong>
                    </div>
                    <i class="fas fa-id-badge sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Portal Email</div>
                        <strong>{{ $student->email ?? auth()->user()->email }}</strong>
                    </div>
                    <i class="fas fa-envelope sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Fee Coverage</div>
                        <strong>{{ $summary['fee_total'] > 0 ? number_format(($summary['paid_total'] / max($summary['fee_total'], 1)) * 100, 0) : 0 }}%</strong>
                    </div>
                    <i class="fas fa-chart-pie sp-muted"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ad-stats-row">
    <div class="ad-stat-card blue">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($summary['fee_total'], 0) }}</div>
            <div class="ad-stat-lbl">Fee Total</div>
            <div class="sp-stat-note">Expected tuition total</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
    </div>
    <div class="ad-stat-card green">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($summary['paid_total'], 0) }}</div>
            <div class="ad-stat-lbl">Recorded Payments</div>
            <div class="sp-stat-note">Payments logged by finance</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-credit-card"></i></div>
    </div>
    <div class="ad-stat-card orange">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($summary['balance'], 0) }}</div>
            <div class="ad-stat-lbl">Outstanding Balance</div>
            <div class="sp-stat-note">Current unpaid amount</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-wallet"></i></div>
    </div>
</div>

<div class="ad-card sp-section-gap">
    <div class="ad-card-head">
        <h3>Payment History</h3>
    </div>
    <div class="ad-card-body">
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
</div>
@endsection
