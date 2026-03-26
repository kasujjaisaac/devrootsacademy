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
            @if($courseBalances->isNotEmpty())
                <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="#make-payment" class="btn-ad btn-ad-light">
                        <i class="fas fa-arrow-up-right-from-square"></i> Make Payment
                    </a>
                    <a href="{{ route('user.chat.index', ['category' => 'finance', 'subject' => 'Finance support request', 'message' => 'Hello, I need help understanding my balance, payment status, or receipt.']) }}" class="btn-ad btn-ad-outline" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.22);color:#fff;">
                        <i class="fas fa-comments-dollar"></i> Ask Finance
                    </a>
                </div>
            @else
                <div style="margin-top:18px;">
                    <a href="{{ route('user.chat.index', ['category' => 'finance', 'subject' => 'Finance support request', 'message' => 'Hello, I need help understanding my balance, payment status, or receipt.']) }}" class="btn-ad btn-ad-outline" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.22);color:#fff;">
                        <i class="fas fa-comments-dollar"></i> Ask Finance
                    </a>
                </div>
            @endif
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
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Online Payment</div>
                        <strong>Pesapal ready</strong>
                    </div>
                    <i class="fas fa-lock sp-muted"></i>
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
    <div class="ad-stat-card purple">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($summary['pending_total'], 0) }}</div>
            <div class="ad-stat-lbl">Pending Payments</div>
            <div class="sp-stat-note">Awaiting confirmation</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-hourglass-half"></i></div>
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
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->course?->title ?? '—' }}</td>
                            <td>UGX {{ number_format($payment->amount, 0) }}</td>
                            <td>{{ $payment->payment_method ?? '—' }}</td>
                            <td>{{ $payment->reference ?? '—' }}</td>
                            <td>
                                @php $statusClass = $payment->status === 'completed' ? 'ad-badge-active' : (($payment->status === 'failed' || $payment->status === 'cancelled' || $payment->status === 'reversed') ? 'ad-badge-rejected' : 'ad-badge-pending'); @endphp
                                <span class="ad-badge {{ $statusClass }}">{{ ucfirst($payment->status ?? 'pending') }}</span>
                            </td>
                            <td>{{ $payment->paid_at?->format('M d, Y') ?? $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<div class="ad-card sp-section-gap" id="make-payment">
    <div class="ad-card-head">
        <h3>Pay Outstanding Course Balance</h3>
    </div>
    <div class="ad-card-body">
        @if($courseBalances->isEmpty())
            <div class="sp-empty">No outstanding course balances are available for online payment right now.</div>
        @else
            <div class="sp-list">
                @foreach($courseBalances as $courseBalance)
                    <div class="sp-list-item">
                        <div>
                            <strong>{{ $courseBalance->course->title }}</strong>
                            <div class="sp-muted">Outstanding balance: UGX {{ number_format($courseBalance->outstanding, 0) }}</div>
                            <div class="sp-muted">Enrollment status: {{ ucfirst($courseBalance->status ?? 'pending') }}</div>
                        </div>
                        <form method="POST" action="{{ route('student.payments.initiate') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $courseBalance->course->id }}">
                            <input type="hidden" name="amount" value="{{ number_format($courseBalance->outstanding, 2, '.', '') }}">
                            <button type="submit" class="btn-ad btn-ad-primary">
                                <i class="fas fa-arrow-up-right-from-square"></i> Pay With Pesapal
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="ad-card sp-section-gap">
    <div class="ad-card-head">
        <h3>Online Payment Readiness</h3>
    </div>
    <div class="ad-card-body">
        <div class="sp-list">
            <div class="sp-list-item">
                <div>
                    <strong>Current State</strong>
                    <div class="sp-muted">You can now start Pesapal checkout for outstanding enrolled-course balances from this page.</div>
                </div>
                <span class="ad-badge ad-badge-active">Sandbox Ready</span>
            </div>
            <div class="sp-list-item">
                <div>
                    <strong>Gateway Handling</strong>
                    <div class="sp-muted">Your transaction will be redirected to Pesapal, then verified through callback and IPN before the local status is confirmed.</div>
                </div>
                <i class="fas fa-shield-halved sp-muted"></i>
            </div>
        </div>
    </div>
</div>
@endsection
