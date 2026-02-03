<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;

class InstructorApprovalController extends Controller
{
    public function approve(Request $request, $userId)
    {
        // Find the user
        $user = User::findOrFail($userId);

        // Create the instructor record
        $instructor = Instructor::create([
            'full_name'       => $user->name,            
            'email'           => $user->email,
            'phone'           => $request->phone,        
            'expertise'       => $request->expertise,    
            'experience_years'=> $request->experience_years,
            'bio'             => $request->bio,
            'portfolio'       => $request->portfolio,
            'status'          => 'approved',
        ]);

        return redirect()->back()->with('success', 'Instructor approved and added!');
    }
}
