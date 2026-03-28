<?php

namespace App\Http\Controllers;

use App\Mail\InstructorApplicationSubmittedMail;
use App\Models\Course;
use App\Models\InstructorApplication;
use App\Notifications\AdminActivityNotification;
use App\Support\AccessControl;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class FrontendInstructorController extends Controller
{
    public function showForm()
    {
        $categories = Course::where('is_active', true)
            ->select('category')->distinct()->orderBy('category')
            ->pluck('category');

        return view('frontend.become-instructor', compact('categories'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => [
                'required',
                'email',
                'max:255',
                Rule::unique('instructor_applications', 'email'),
                Rule::unique('instructors', 'email'),
            ],
            'phone'            => 'required|string|max:20',
            'expertise'        => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:60',
            'bio'              => 'required|string|min:50|max:3000',
            'portfolio'        => 'nullable|url|max:500',
            'terms'            => 'accepted',
        ], [
            'email.unique'           => 'An application with this email already exists.',
            'experience_years.min'   => 'Years of experience cannot be negative.',
            'experience_years.max'   => 'Please enter a valid number of years.',
            'bio.min'                => 'Please provide at least 50 characters in your bio.',
            'portfolio.url'          => 'Portfolio must be a valid URL (e.g. https://yoursite.com).',
            'terms.accepted'         => 'You must agree to the terms and conditions to apply.',
        ]);

        $application = InstructorApplication::create([
            'full_name'        => $validated['full_name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'],
            'expertise'        => $validated['expertise'],
            'experience_years' => $validated['experience_years'],
            'bio'              => $validated['bio'],
            'portfolio'        => $validated['portfolio'] ?? null,
            'agreed_terms'     => true,
            'status'           => InstructorApplication::STATUS_SUBMITTED,
            'source'           => 'website',
        ]);

        rescue(function () use ($application) {
            Mail::to($application->email)->send(new InstructorApplicationSubmittedMail($application));
        }, report: true);

        AdminNotifier::sendToPermission(
            AccessControl::MANAGE_INSTRUCTOR_APPLICATIONS,
            new AdminActivityNotification(
                'New instructor application',
                $application->full_name.' submitted an instructor application.',
                route('admin.instructor-applications.show', $application),
                ['type' => 'instructor_application', 'application_id' => $application->id],
            )
        );

        return back()->with(
            'success',
            'Your instructor application has been submitted! Our team will review it and get back to you shortly.'
        );
    }
}
