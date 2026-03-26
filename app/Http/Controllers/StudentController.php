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
                    ->orWhereIn('status', [Student::STATUS_ACTIVE, Student::STATUS_FINISHED, Student::STATUS_INACTIVE]);
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
            'active_courses'    => $student->enrollments->where('status', \App\Models\Enrollment::STATUS_ACTIVE)->count(),
            'completed_courses' => $student->enrollments->where('status', \App\Models\Enrollment::STATUS_COMPLETED)->count(),
            'total_paid'        => $student->payments->where('status', \App\Models\Payment::STATUS_COMPLETED)->sum('amount'),
            'total_payments'    => $student->payments->count(),
        ];

        return view('admin.students.show', compact('student', 'stats'));
    }
    public function edit(Student $student) {}
    public function update(Request $request, Student $student)
    {
        $request->validate(['status' => 'required|in:active,inactive,finished']);
        $student->update(['status' => $request->status]);
        return back()->with('success', 'Student status updated successfully.');
    }
    public function destroy(Student $student) {}
}
