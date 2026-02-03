<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses,slug',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048',
            'fee' => 'nullable|integer',
            'outline' => 'nullable',
        ]);

        $path = $request->file('image')->store('courses', 'public');

        Course::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $path,
            'fee' => $request->fee,
            'outline' => $request->outline,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course added successfully');
    }
    // Show edit form
public function edit(Course $course)
{
    return view('admin.courses.edit', compact('course'));
}

// Update course
public function update(Request $request, Course $course)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:courses,slug,' . $course->id,
        'category' => 'required',
        'description' => 'required',
        'image' => 'nullable|image|max:2048',
        'fee' => 'nullable|integer',
        'outline' => 'nullable',
    ]);

    $data = $request->only(['title', 'slug', 'category', 'description', 'fee', 'outline']);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($course->image && \Storage::disk('public')->exists($course->image)) {
            \Storage::disk('public')->delete($course->image);
        }

        $data['image'] = $request->file('image')->store('courses', 'public');
    }

    $course->update($data);

    return redirect()->route('admin.courses.index')
        ->with('success', 'Course updated successfully!');
}
    // Delete course
    public function destroy(Course $course)
    {
        // Delete image if exists
        if ($course->image && \Storage::disk('public')->exists($course->image)) {
            \Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}
