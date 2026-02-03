<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::all(); // fetch all instructors
        return view('admin.instructors.index', compact('instructors'));
    }

    public function approve($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->status = 'approved'; // or use the correct column in your table
        $instructor->save();
        return redirect()->back()->with('success', 'Instructor approved successfully.');
    }

    public function reject($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->status = 'rejected'; // match your column
        $instructor->save();
        return redirect()->back()->with('success', 'Instructor rejected.');
    }
}
