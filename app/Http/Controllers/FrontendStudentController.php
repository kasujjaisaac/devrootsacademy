<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewStudentApplicationMail;
use App\Mail\StudentApplicationSubmittedMail;
use App\Models\Course;
use App\Models\StudentApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class FrontendStudentController extends Controller
{
    public function showForm()
    {
        $courses = Course::where('is_active', true)->orderBy('title')->get(['id', 'title']);
        return view('frontend.apply-now', compact('courses'));
    }

    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'full_name'       => 'required|string|max:255',
            'username'        => [
                'nullable',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('student_applications', 'username'),
                Rule::unique('students', 'username'),
            ],
            'email'           => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('student_applications', 'email'),
                Rule::unique('students', 'email'),
            ],
            'phone'           => [
                'required',
                'string',
                'max:20',
                Rule::unique('student_applications', 'phone'),
                Rule::unique('students', 'phone'),
            ],
            'dob'             => 'nullable|date|before:today',
            'location'        => 'nullable|string|max:255',
            'course_id'       => 'required|exists:courses,id',
            'goals'           => 'nullable|string|max:2000',
            'terms'           => 'accepted',
        ], [
            'username.unique'           => 'This username is already taken. Please choose another.',
            'email.unique'              => 'This email address has already been used for an application.',
            'phone.unique'              => 'This phone number has already been used for an application.',
            'dob.before'                => 'Date of birth must be in the past.',
            'terms.accepted'            => 'You must agree to the terms and conditions to apply.',
            'course_id.required'        => 'Please select a course you are interested in.',
        ]);

        $application = StudentApplication::create([
            'full_name'       => $validated['full_name'],
            'username'        => $validated['username'] ?? null,
            'email'           => $validated['email'] ?? null,
            'phone'           => $validated['phone'],
            'dob'             => $validated['dob'] ?? null,
            'location'        => $validated['location'] ?? null,
            'course_id'       => $validated['course_id'],
            'goals'           => $validated['goals'] ?? null,
            'agreed_terms'    => true,
            'status'          => StudentApplication::STATUS_SUBMITTED,
            'source'          => 'website',
        ]);

        if ($application->email) {
            rescue(function () use ($application) {
                Mail::to($application->email)->send(new StudentApplicationSubmittedMail($application->load('course')));
            }, report: true);
        }

        $admissionsAddress = config('mail.notifications.admissions_address');

        if ($admissionsAddress) {
            rescue(function () use ($application, $admissionsAddress) {
                Mail::to($admissionsAddress)->send(new AdminNewStudentApplicationMail($application->load('course')));
            }, report: true);
        }

        return redirect()->back()->with(
            'success',
            'Your application has been submitted successfully! We will review it and contact you within 24 hours.'
        );
    }
}
