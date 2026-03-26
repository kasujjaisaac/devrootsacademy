<?php

namespace App\Http\Controllers;

use App\Mail\AdminStudentPaymentReceivedMail;
use App\Models\Payment;
use App\Services\PesapalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class StudentPaymentController extends Controller
{
    public function __construct(protected PesapalService $pesapal)
    {
    }

    public function initiate(Request $request)
    {
        $student = $request->user()
            ->student()
            ->with(['enrollments.course', 'payments'])
            ->firstOrFail();

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $enrollment = $student->enrollments->firstWhere('course_id', (int) $validated['course_id']);

        if (! $enrollment || ! $enrollment->course) {
            return back()->with('error', 'You can only pay for a course you are enrolled in.');
        }

        $completedTotal = (float) $student->payments
            ->where('course_id', $enrollment->course_id)
            ->where('status', Payment::STATUS_COMPLETED)
            ->sum('amount');

        $outstandingBalance = max(((float) $enrollment->course->fee) - $completedTotal, 0);

        if ($outstandingBalance <= 0) {
            return back()->with('error', 'This course does not have an outstanding balance.');
        }

        $amount = round((float) $validated['amount'], 2);

        if ($amount > $outstandingBalance) {
            return back()->with('error', 'The requested payment amount exceeds the outstanding course balance.');
        }

        try {
            $payment = DB::transaction(function () use ($student, $enrollment, $amount) {
                $payment = Payment::create([
                    'student_id' => $student->id,
                    'course_id' => $enrollment->course_id,
                    'amount' => $amount,
                    'payment_method' => 'pesapal',
                    'status' => Payment::STATUS_PENDING,
                    'gateway' => 'pesapal',
                    'currency' => config('pesapal.currency', 'UGX'),
                    'description' => 'Tuition payment for '.$enrollment->course->title,
                    'merchant_reference' => $this->merchantReference($student->id),
                    'reference' => null,
                ]);

                $payload = $this->pesapal->submitOrder($payment, $student);

                $payment->update([
                    'reference' => $payload['merchant_reference'] ?? $payment->merchant_reference,
                    'gateway_tracking_id' => $payload['order_tracking_id'] ?? null,
                    'raw_response' => $payload,
                ]);

                return [$payment->fresh(), $payload];
            });
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Pesapal checkout could not be started at this time. Please try again.');
        }

        /** @var array{0: \App\Models\Payment, 1: array} $payment */
        return redirect()->away($payment[1]['redirect_url']);
    }

    public function callback(Request $request)
    {
        $payment = $this->resolvePaymentByReference(
            $request->string('OrderMerchantReference')->toString(),
            withRelations: true
        );

        if (! $payment) {
            return redirect()->route('login')->with('status', 'Your payment response was received, but the transaction could not be matched locally.');
        }

        $payment->update([
            'callback_payload' => $request->all(),
        ]);

        $this->refreshPaymentStatus($payment, $request->string('OrderTrackingId')->toString());
        $payment->refresh();

        $message = match ($payment->status) {
            Payment::STATUS_COMPLETED => 'Your payment was completed successfully and your balance has been updated.',
            Payment::STATUS_PENDING => 'Your payment response was received and is still awaiting final confirmation.',
            Payment::STATUS_FAILED, Payment::STATUS_CANCELLED, Payment::STATUS_REVERSED => 'Your payment attempt was received but it did not complete successfully.',
            default => 'Your payment response has been received and your payment status was refreshed.',
        };

        if (auth()->check() && auth()->id() === $payment->student?->user_id) {
            return redirect()->route('student.payments')->with(
                $payment->status === Payment::STATUS_COMPLETED ? 'success' : 'error',
                $message
            );
        }

        return redirect()->route('login')->with('status', $message.' Sign in to the student portal to view the latest payment status.');
    }

    public function ipn(Request $request)
    {
        $reference = (string) ($request->input('OrderMerchantReference') ?? '');
        $trackingId = (string) ($request->input('OrderTrackingId') ?? '');

        $payment = $this->resolvePaymentByReference($reference);

        if (! $payment) {
            return response()->json([
                'orderNotificationType' => $request->input('OrderNotificationType'),
                'orderTrackingId' => $trackingId,
                'orderMerchantReference' => $reference,
                'status' => 500,
            ], 500);
        }

        $payment->update([
            'ipn_payload' => $request->all(),
        ]);

        $processed = $this->refreshPaymentStatus($payment, $trackingId);

        return response()->json([
            'orderNotificationType' => $request->input('OrderNotificationType', 'IPNCHANGE'),
            'orderTrackingId' => $trackingId,
            'orderMerchantReference' => $reference,
            'status' => $processed ? 200 : 500,
        ], $processed ? 200 : 500);
    }

    protected function refreshPaymentStatus(Payment $payment, string $trackingId): bool
    {
        $wasCompleted = $payment->status === Payment::STATUS_COMPLETED;

        try {
            $statusPayload = $this->pesapal->getTransactionStatus($trackingId ?: (string) $payment->gateway_tracking_id);
        } catch (Throwable $e) {
            report($e);

            return false;
        }

        $paymentStatus = strtoupper((string) ($statusPayload['payment_status_description'] ?? $statusPayload['payment_status'] ?? ''));
        $mappedStatus = match ($paymentStatus) {
            'COMPLETED' => Payment::STATUS_COMPLETED,
            'FAILED', 'INVALID' => Payment::STATUS_FAILED,
            'REVERSED' => Payment::STATUS_REVERSED,
            'CANCELLED' => Payment::STATUS_CANCELLED,
            default => Payment::STATUS_PENDING,
        };

        $payment->update([
            'status' => $mappedStatus,
            'gateway_tracking_id' => $trackingId ?: ($statusPayload['order_tracking_id'] ?? $payment->gateway_tracking_id),
            'reference' => $payment->reference ?: ($statusPayload['merchant_reference'] ?? $payment->merchant_reference),
            'raw_response' => array_merge($payment->raw_response ?? [], ['status_lookup' => $statusPayload]),
            'paid_at' => $mappedStatus === Payment::STATUS_COMPLETED ? ($payment->paid_at ?? now()) : $payment->paid_at,
        ]);

        if (! $wasCompleted && $mappedStatus === Payment::STATUS_COMPLETED) {
            $paymentsAddress = config('mail.notifications.payments_address');

            if ($paymentsAddress) {
                rescue(function () use ($payment, $paymentsAddress) {
                    Mail::to($paymentsAddress)->send(new AdminStudentPaymentReceivedMail($payment->fresh(['student', 'course'])));
                }, report: true);
            }
        }

        return true;
    }

    protected function merchantReference(int $studentId): string
    {
        return Str::upper('PAY-'.$studentId.'-'.now()->format('YmdHis').'-'.Str::random(6));
    }

    protected function resolvePaymentByReference(string $reference, bool $withRelations = false): ?Payment
    {
        if ($reference === '') {
            return null;
        }

        $query = Payment::query();

        if ($withRelations) {
            $query->with('student.user');
        }

        return $query
            ->where(function ($innerQuery) use ($reference) {
                $innerQuery->where('merchant_reference', $reference)
                    ->orWhere('reference', $reference);
            })
            ->first();
    }
}
