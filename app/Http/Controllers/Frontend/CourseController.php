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

        $courses = Course::where('is_active', true)
        ->when($category, function($query, $category) {
            $query->where('category', $category);
        })
        ->orderByDesc('is_featured')
        ->orderBy('created_at', 'desc')
        ->paginate(9)
        ->withQueryString();

        $categories = Course::where('is_active', true)
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->get();

        return view('frontend.courses.index', compact('courses', 'categories'));
    }

    public function show($slug)
    {
        $course = Course::where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();
        return view('frontend.courses.show', compact('course'));
    }
}
