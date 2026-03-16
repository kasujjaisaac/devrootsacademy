<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('frontend.index', compact('courses'));
    }
}
