<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StudentApplicationAcceptedMail;
use App\Mail\StudentApplicationRejectedMail;
use App\Mail\StudentApplicationUnderReviewMail;
use App\Mail\StudentEnrollmentConfirmedMail;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\StudentApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class StudentApplicationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $applications = StudentApplication::query()
            ->with(['course', 'reviewer', 'student', 'enrollment'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statusCounts = collect([
            StudentApplication::STATUS_SUBMITTED,
            StudentApplication::STATUS_REVIEWED,
            StudentApplication::STATUS_ACCEPTED,
            StudentApplication::STATUS_REJECTED,
            StudentApplication::STATUS_ENROLLED,
        ])->mapWithKeys(fn($applicationStatus) => [
            $applicationStatus => StudentApplication::where('status', $applicationStatus)->count(),
        ]);

        return view('admin.student-applications.index', compact('applications', 'status', 'statusCounts'));
    }

    public function show(StudentApplication $studentApplication)
    {
        $studentApplication->load(['course', 'reviewer', 'student', 'enrollment.course']);

        return view('admin.student-applications.show', [
            'application' => $studentApplication,
        ]);
    }

    public function review(Request $request, StudentApplication $studentApplication)
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:5000',
        ]);

        $studentApplication->update([
            'status' => StudentApplication::STATUS_REVIEWED,
            'review_notes' => $validated['review_notes'] ?? $studentApplication->review_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        $this->sendEmailIfPossible($studentApplication->fresh(['course']), new StudentApplicationUnderReviewMail($studentApplication->fresh(['course'])));

        return back()->with('success', 'Application marked as under review.');
    }

    public function accept(Request $request, StudentApplication $studentApplication)
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:5000',
        ]);

        $studentApplication->update([
            'status' => StudentApplication::STATUS_ACCEPTED,
            'review_notes' => $validated['review_notes'] ?? $studentApplication->review_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => $studentApplication->reviewed_at ?: now(),
            'decision_at' => now(),
        ]);

        $this->sendEmailIfPossible($studentApplication->fresh(['course']), new StudentApplicationAcceptedMail($studentApplication->fresh(['course'])));

        return back()->with('success', 'Application accepted.');
    }

    public function reject(Request $request, StudentApplication $studentApplication)
    {
        $validated = $request->validate([
            'review_notes' => 'required|string|max:5000',
        ], [
            'review_notes.required' => 'Please provide a reason or review note when rejecting an application.',
        ]);

        $studentApplication->update([
            'status' => StudentApplication::STATUS_REJECTED,
            'review_notes' => $validated['review_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => $studentApplication->reviewed_at ?: now(),
            'decision_at' => now(),
        ]);

        $this->sendEmailIfPossible($studentApplication->fresh(['course']), new StudentApplicationRejectedMail($studentApplication->fresh(['course'])));

        return back()->with('success', 'Application rejected.');
    }

    public function enroll(Request $request, StudentApplication $studentApplication)
    {
        if ($studentApplication->status !== StudentApplication::STATUS_ACCEPTED) {
            return back()->with('error', 'Only accepted applications can be enrolled.');
        }

        if (! $studentApplication->email) {
            return back()->with('error', 'An email address is required to create student portal access.');
        }

        if (! $studentApplication->course_id) {
            return back()->with('error', 'This application does not have a valid course assigned.');
        }

        DB::transaction(function () use ($studentApplication) {
            $user = User::firstOrCreate(
                ['email' => $studentApplication->email],
                [
                    'name' => $studentApplication->full_name,
                    'password' => Str::random(32),
                    'role' => 'student',
                    'is_admin' => false,
                ]
            );

            $student = $studentApplication->student ?: Student::create([
                'user_id' => $user->id,
                'full_name' => $studentApplication->full_name,
                'username' => $studentApplication->username,
                'email' => $studentApplication->email,
                'phone' => $studentApplication->phone,
                'dob' => $studentApplication->dob,
                'location' => $studentApplication->location,
                'course_interest' => $studentApplication->course?->title,
                'goals' => $studentApplication->goals,
                'agreed_terms' => $studentApplication->agreed_terms,
                'status' => 'active',
            ]);

            if (! $student->user_id) {
                $student->update(['user_id' => $user->id]);
            }

            $enrollment = $studentApplication->enrollment ?: Enrollment::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'course_id' => $studentApplication->course_id,
                ],
                [
                    'status' => 'active',
                ]
            );

            $studentApplication->update([
                'status' => StudentApplication::STATUS_ENROLLED,
                'student_id' => $student->id,
                'enrollment_id' => $enrollment->id,
                'reviewed_by' => Auth::id(),
                'reviewed_at' => $studentApplication->reviewed_at ?: now(),
                'decision_at' => $studentApplication->decision_at ?: now(),
            ]);
        });

        $this->sendEmailIfPossible($studentApplication->fresh(['course', 'enrollment.course']), new StudentEnrollmentConfirmedMail($studentApplication->fresh(['course', 'enrollment.course'])));
        rescue(fn () => Password::sendResetLink(['email' => $studentApplication->email]), report: true);

        return back()->with('success', 'Application converted to an enrolled student successfully.');
    }

    protected function sendEmailIfPossible(StudentApplication $application, $mailable): void
    {
        if (! $application->email) {
            return;
        }

        rescue(function () use ($application, $mailable) {
            Mail::to($application->email)->send($mailable);
        }, report: true);
    }
}
