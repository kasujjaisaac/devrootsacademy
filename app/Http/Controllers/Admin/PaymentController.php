<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Course;

class PaymentController extends Controller
{
    // Show all payments
    public function index()
    {
        $payments = Payment::with('student', 'course')->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    // Show the form to add a payment
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('admin.payments.create', compact('students', 'courses'));
    }

    // Store a new payment
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string'
        ]);

        Payment::create($request->only('student_id', 'course_id', 'amount', 'payment_method'));

        return redirect()->route('admin.payments.index')->with('success', 'Payment added successfully!');
    }
}
