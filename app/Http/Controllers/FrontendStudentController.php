<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class FrontendStudentController extends Controller
{
    public function submitApplication(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'course_interest' => 'required|string|max:255',
            'goals' => 'nullable|string|max:1000',
            'terms' => 'accepted',
        ]);

        Student::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'location' => $request->location,
            'course_interest' => $request->course_interest,
            'goals' => $request->goals,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}
