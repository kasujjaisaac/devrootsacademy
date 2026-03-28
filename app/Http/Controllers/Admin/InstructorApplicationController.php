<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InstructorActivationConfirmedMail;
use App\Mail\InstructorApplicationAcceptedMail;
use App\Mail\InstructorApplicationRejectedMail;
use App\Mail\InstructorApplicationUnderReviewMail;
use App\Models\Instructor;
use App\Models\InstructorApplication;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InstructorApplicationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $applications = InstructorApplication::query()
            ->with(['reviewer', 'instructor'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statusCounts = collect([
            InstructorApplication::STATUS_SUBMITTED,
            InstructorApplication::STATUS_REVIEWED,
            InstructorApplication::STATUS_ACCEPTED,
            InstructorApplication::STATUS_REJECTED,
            InstructorApplication::STATUS_ACTIVATED,
        ])->mapWithKeys(fn($applicationStatus) => [
            $applicationStatus => InstructorApplication::where('status', $applicationStatus)->count(),
        ]);

        return view('admin.instructor-applications.index', compact('applications', 'status', 'statusCounts'));
    }

    public function show(InstructorApplication $instructorApplication)
    {
        $instructorApplication->load(['reviewer', 'instructor']);

        return view('admin.instructor-applications.show', [
            'application' => $instructorApplication,
        ]);
    }

    public function review(Request $request, InstructorApplication $instructorApplication)
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:5000',
        ]);

        $instructorApplication->update([
            'status' => InstructorApplication::STATUS_REVIEWED,
            'review_notes' => $validated['review_notes'] ?? $instructorApplication->review_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        $this->sendEmailIfPossible($instructorApplication->fresh(), new InstructorApplicationUnderReviewMail($instructorApplication->fresh()));
        $this->logAction($request, $instructorApplication, 'instructor_application.reviewed', 'Marked instructor application as under review.');

        return back()->with('success', 'Instructor application marked as under review.');
    }

    public function accept(Request $request, InstructorApplication $instructorApplication)
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:5000',
        ]);

        $instructorApplication->update([
            'status' => InstructorApplication::STATUS_ACCEPTED,
            'review_notes' => $validated['review_notes'] ?? $instructorApplication->review_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => $instructorApplication->reviewed_at ?: now(),
            'decision_at' => now(),
        ]);

        $this->sendEmailIfPossible($instructorApplication->fresh(), new InstructorApplicationAcceptedMail($instructorApplication->fresh()));
        $this->logAction($request, $instructorApplication, 'instructor_application.accepted', 'Accepted instructor application.');

        return back()->with('success', 'Instructor application accepted.');
    }

    public function reject(Request $request, InstructorApplication $instructorApplication)
    {
        $validated = $request->validate([
            'review_notes' => 'required|string|max:5000',
        ], [
            'review_notes.required' => 'Please provide a reason or review note when rejecting an instructor application.',
        ]);

        $instructorApplication->update([
            'status' => InstructorApplication::STATUS_REJECTED,
            'review_notes' => $validated['review_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => $instructorApplication->reviewed_at ?: now(),
            'decision_at' => now(),
        ]);

        $this->sendEmailIfPossible($instructorApplication->fresh(), new InstructorApplicationRejectedMail($instructorApplication->fresh()));
        $this->logAction($request, $instructorApplication, 'instructor_application.rejected', 'Rejected instructor application.');

        return back()->with('success', 'Instructor application rejected.');
    }

    public function activate(Request $request, InstructorApplication $instructorApplication)
    {
        if ($instructorApplication->status !== InstructorApplication::STATUS_ACCEPTED) {
            return back()->with('error', 'Only accepted instructor applications can be activated.');
        }

        $instructor = $instructorApplication->instructor ?: Instructor::create([
            'full_name' => $instructorApplication->full_name,
            'email' => $instructorApplication->email,
            'phone' => $instructorApplication->phone,
            'expertise' => $instructorApplication->expertise,
            'experience_years' => $instructorApplication->experience_years,
            'bio' => $instructorApplication->bio,
            'portfolio' => $instructorApplication->portfolio,
            'status' => 'approved',
        ]);

        $instructorApplication->update([
            'status' => InstructorApplication::STATUS_ACTIVATED,
            'instructor_id' => $instructor->id,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => $instructorApplication->reviewed_at ?: now(),
            'decision_at' => $instructorApplication->decision_at ?: now(),
        ]);

        $this->sendEmailIfPossible($instructorApplication->fresh(), new InstructorActivationConfirmedMail($instructorApplication->fresh()));
        $this->logAction($request, $instructorApplication->fresh(['instructor']), 'instructor_application.activated', 'Activated instructor application and added instructor to roster.');

        return back()->with('success', 'Instructor activated and added to the instructor roster.');
    }

    protected function sendEmailIfPossible(InstructorApplication $application, $mailable): void
    {
        if (! $application->email) {
            return;
        }

        rescue(function () use ($application, $mailable) {
            Mail::to($application->email)->send($mailable);
        }, report: true);
    }

    protected function logAction(Request $request, InstructorApplication $application, string $action, string $description): void
    {
        AuditLogger::log(
            $action,
            $description,
            actor: $request->user(),
            metadata: [
                'application_id' => $application->id,
                'status' => $application->status,
                'applicant' => $application->full_name,
                'email' => $application->email,
            ],
            request: $request,
        );
    }
}
