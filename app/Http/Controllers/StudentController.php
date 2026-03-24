<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()
            ->where(function ($query) {
                $query->whereHas('enrollments')
                    ->orWhereIn('status', ['active', 'finished']);
            })
            ->latest()
            ->paginate(20);

        return view('admin.students.index', compact('students'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(Student $student)
    {
        $student->load([
            'enrollments.course',
            'payments',
        ]);

        $stats = [
            'total_enrollments' => $student->enrollments->count(),
            'active_courses'    => $student->enrollments->where('status', 'active')->count(),
            'completed_courses' => $student->enrollments->where('status', 'completed')->count(),
            'total_paid'        => $student->payments->where('status', 'paid')->sum('amount'),
            'total_payments'    => $student->payments->count(),
        ];

        return view('admin.students.show', compact('student', 'stats'));
    }
    public function edit(Student $student) {}
    public function update(Request $request, Student $student)
    {
        $request->validate(['status' => 'required|in:pending,active,finished,rejected']);
        $student->update(['status' => $request->status]);
        return back()->with('success', 'Student status updated successfully.');
    }
    public function destroy(Student $student) {}
}
