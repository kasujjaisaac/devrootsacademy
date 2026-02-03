<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;

class FrontendInstructorController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'expertise' => 'required',
            'experience_years' => 'required|integer',
            'bio' => 'required',
        ]);

        Instructor::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'expertise' => $request->expertise,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
            'portfolio' => $request->portfolio,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
}
