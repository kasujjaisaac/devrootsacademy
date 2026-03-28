<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StudentCourseCompletedMail;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')->latest()->get();
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::orderBy('full_name')->get();
        $courses  = Course::orderBy('title')->get();
        return view('admin.enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'status'     => 'required|in:'.implode(',', Enrollment::allowedStatuses()),
        ]);

        $enrollment = Enrollment::create($request->only('student_id', 'course_id', 'status'));
        $enrollment->load(['student.user', 'course']);
        $enrollment->student?->syncLifecycleStatus();
        $this->logAction($request, $enrollment, 'enrollment.created', 'Created enrollment.');

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Enrollment created successfully.');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load('student', 'course');
        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $enrollment->load('student', 'course');
        return view('admin.enrollments.edit', compact('enrollment'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate(['status' => 'required|in:'.implode(',', Enrollment::allowedStatuses())]);
        $wasCompleted = $enrollment->status === Enrollment::STATUS_COMPLETED;
        $enrollment->update($request->only('status'));
        $enrollment->load(['student', 'course']);
        $enrollment->student?->syncLifecycleStatus();

        if (! $wasCompleted && $enrollment->status === Enrollment::STATUS_COMPLETED && $enrollment->student?->email) {
            rescue(function () use ($enrollment) {
                Mail::to($enrollment->student->email)->send(new StudentCourseCompletedMail($enrollment));
            }, report: true);
        }

        $this->logAction($request, $enrollment, 'enrollment.updated', 'Updated enrollment status.');

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Enrollment updated successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->load(['student.user', 'course']);
        $student = $enrollment->student;
        $this->logAction(request(), $enrollment, 'enrollment.deleted', 'Deleted enrollment.');
        $enrollment->delete();
        $student?->syncLifecycleStatus();
        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Enrollment deleted.');
    }

    protected function logAction(Request $request, Enrollment $enrollment, string $action, string $description): void
    {
        AuditLogger::log(
            $action,
            $description,
            actor: $request->user(),
            targetUser: $enrollment->student?->user,
            metadata: [
                'enrollment_id' => $enrollment->id,
                'status' => $enrollment->status,
                'course' => $enrollment->course?->title,
                'student' => $enrollment->student?->full_name,
            ],
            request: $request,
        );
    }
}
