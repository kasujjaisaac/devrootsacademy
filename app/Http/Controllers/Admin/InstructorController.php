<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::query()
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('admin.instructors.index', compact('instructors'));
    }
}
