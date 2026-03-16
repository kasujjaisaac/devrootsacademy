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
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|unique:courses,slug|max:255',
            'category'          => 'required|string|max:255',
            'description'       => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'image'             => 'required|image|max:2048',
            'fee'               => 'nullable|numeric|min:0',
            'outline'           => 'nullable|string',
            'level'             => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_weeks'    => 'nullable|integer|min:1',
            'schedule'          => 'nullable|string|max:200',
            'mode'              => 'nullable|in:online,in-person,hybrid',
        ]);

        $path = $request->file('image')->store('courses', 'public');

        Course::create([
            'title'             => $request->title,
            'slug'              => $request->slug,
            'category'          => $request->category,
            'description'       => $request->description,
            'short_description' => $request->short_description,
            'image'             => $path,
            'fee'               => $request->fee !== null ? (int) $request->fee : null,
            'outline'           => $request->outline
                ? array_values(array_filter(array_map('trim', explode("\n", $request->outline))))
                : [],
            'level'             => $request->level,
            'duration_weeks'    => $request->duration_weeks,
            'schedule'          => $request->schedule,
            'mode'              => $request->mode,
            'is_featured'       => $request->input('is_featured', '0') === '1',
            'is_active'         => $request->input('is_active', '1') === '1',
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|unique:courses,slug,' . $course->id . '|max:255',
            'category'          => 'required|string|max:255',
            'description'       => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'image'             => 'nullable|image|max:2048',
            'fee'               => 'nullable|numeric|min:0',
            'outline'           => 'nullable|string',
            'level'             => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_weeks'    => 'nullable|integer|min:1',
            'schedule'          => 'nullable|string|max:200',
            'mode'              => 'nullable|in:online,in-person,hybrid',
        ]);

        $data = [
            'title'             => $request->title,
            'slug'              => $request->slug,
            'category'          => $request->category,
            'description'       => $request->description,
            'short_description' => $request->short_description,
            'fee'               => $request->fee !== null ? (int) $request->fee : null,
            'outline'           => $request->outline
                ? array_values(array_filter(array_map('trim', explode("\n", $request->outline))))
                : [],
            'level'             => $request->level,
            'duration_weeks'    => $request->duration_weeks,
            'schedule'          => $request->schedule,
            'mode'              => $request->mode,
            'is_featured'       => $request->input('is_featured', '0') === '1',
            'is_active'         => $request->input('is_active', '0') === '1',
        ];

        if ($request->hasFile('image')) {
            if ($course->image && \Storage::disk('public')->exists($course->image)) {
                \Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->image && \Storage::disk('public')->exists($course->image)) {
            \Storage::disk('public')->delete($course->image);
        }
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
