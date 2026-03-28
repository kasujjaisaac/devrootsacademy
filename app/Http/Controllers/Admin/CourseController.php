<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
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
            'enrollment_close_date' => 'nullable|date',
            'mode'              => 'nullable|in:online,in-person,hybrid',
        ]);

        try {
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
                'enrollment_close_date' => $request->enrollment_close_date,
                'mode'              => $request->mode,
                'is_featured'       => $request->boolean('is_featured'),
                'is_active'         => $request->boolean('is_active'),
            ]);
        } catch (Throwable $e) {
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'The course could not be saved. Check the database connection and try again.');
        }

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
            'enrollment_close_date' => 'nullable|date',
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
            'enrollment_close_date' => $request->enrollment_close_date,
            'mode'              => $request->mode,
            'is_featured'       => $request->boolean('is_featured'),
            'is_active'         => $request->boolean('is_active'),
        ];

        try {
            if ($request->hasFile('image')) {
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }

                $data['image'] = $request->file('image')->store('courses', 'public');
            }

            $course->update($data);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'The course could not be updated. Check the database connection and try again.');
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->image && Storage::disk('public')->exists($course->image)) {
            Storage::disk('public')->delete($course->image);
        }
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
