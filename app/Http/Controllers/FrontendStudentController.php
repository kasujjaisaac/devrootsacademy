<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class FrontendStudentController extends Controller
{
    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'full_name'       => 'required|string|max:255',
            'username'        => 'nullable|string|max:100|alpha_dash|unique:students,username',
            'email'           => 'nullable|email|max:255|unique:students,email',
            'phone'           => 'required|string|max:20|unique:students,phone',
            'dob'             => 'nullable|date|before:today',
            'location'        => 'nullable|string|max:255',
            'course_interest' => 'required|string|max:255',
            'goals'           => 'nullable|string|max:2000',
            'terms'           => 'accepted',
        ], [
            'username.unique'  => 'This username is already taken. Please choose another.',
            'email.unique'     => 'This email address has already been used for an application.',
            'phone.unique'     => 'This phone number has already been used for an application.',
            'dob.before'       => 'Date of birth must be in the past.',
            'terms.accepted'   => 'You must agree to the terms and conditions to apply.',
            'course_interest.required' => 'Please select a course you are interested in.',
        ]);

        Student::create([
            'full_name'       => $validated['full_name'],
            'username'        => $validated['username'] ?? null,
            'email'           => $validated['email'] ?? null,
            'phone'           => $validated['phone'],
            'dob'             => $validated['dob'] ?? null,
            'location'        => $validated['location'] ?? null,
            'course_interest' => $validated['course_interest'],
            'goals'           => $validated['goals'] ?? null,
            'agreed_terms'    => true,
            'status'          => 'pending',
        ]);

        return redirect()->back()->with(
            'success',
            'Your application has been submitted successfully! We will review it and contact you within 24 hours.'
        );
    }
}
