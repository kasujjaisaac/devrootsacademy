<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student', 'course')
            ->latest('paid_at')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Payment::count(),
            'completed' => Payment::where('status', Payment::STATUS_COMPLETED)->count(),
            'pending' => Payment::where('status', Payment::STATUS_PENDING)->count(),
            'completed_amount' => (float) Payment::where('status', Payment::STATUS_COMPLETED)->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function create()
    {
        $students = Student::orderBy('full_name')->get();
        $courses = Course::orderBy('title')->get();

        return view('admin.payments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:100',
            'status' => 'required|in:pending,completed,failed,cancelled,reversed',
            'currency' => 'nullable|string|size:3',
            'description' => 'nullable|string|max:1000',
            'reference' => 'nullable|string|max:120',
            'merchant_reference' => 'nullable|string|max:120',
            'gateway_tracking_id' => 'nullable|string|max:120',
            'paid_at' => 'nullable|date',
        ]);

        Payment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'gateway' => 'manual',
            'reference' => $validated['reference'] ?: 'MANUAL-'.Str::upper(Str::random(10)),
            'merchant_reference' => $validated['merchant_reference'] ?? null,
            'gateway_tracking_id' => $validated['gateway_tracking_id'] ?? null,
            'currency' => strtoupper($validated['currency'] ?? 'UGX'),
            'description' => $validated['description'] ?? null,
            'paid_at' => ($validated['status'] === Payment::STATUS_COMPLETED)
                ? ($validated['paid_at'] ?? now())
                : ($validated['paid_at'] ?? null),
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment recorded successfully.');
    }
}
