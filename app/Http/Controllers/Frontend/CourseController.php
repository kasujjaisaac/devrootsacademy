<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show all courses with optional category filter
    public function index(Request $request)
    {
        $category = $request->category;

        $courses = Course::when($category, function($query, $category) {
            $query->where('category', $category);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(9) // 9 courses per page
        ->withQueryString(); // keep filter in pagination links

        // Sidebar categories
        $categories = Course::select('category')->distinct()->get();

        return view('frontend.courses.index', compact('courses', 'categories'));
    }

    // Show single course
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        return view('frontend.courses.show', compact('course'));
    }
}
