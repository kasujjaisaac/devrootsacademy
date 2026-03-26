<p>A student payment has been confirmed.</p>

<p><strong>Student:</strong> {{ $payment->student?->full_name ?? 'Unknown student' }}</p>
<p><strong>Student Number:</strong> {{ $payment->student?->student_number ?? 'N/A' }}</p>
<p><strong>Course:</strong> {{ $payment->course?->title ?? 'Unknown course' }}</p>
<p><strong>Amount:</strong> {{ $payment->currency ?? 'UGX' }} {{ number_format((float) $payment->amount, 2) }}</p>
<p><strong>Method:</strong> {{ strtoupper($payment->payment_method ?? $payment->gateway ?? 'N/A') }}</p>
<p><strong>Reference:</strong> {{ $payment->reference ?? $payment->merchant_reference ?? 'N/A' }}</p>
<p><strong>Paid At:</strong> {{ $payment->paid_at?->format('M d, Y g:i A') ?? now()->format('M d, Y g:i A') }}</p>

<p>Log in to the admin dashboard to review the payment record.</p>
