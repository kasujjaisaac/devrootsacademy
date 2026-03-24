<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\Course;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $timetables = CalendarEvent::query()
            ->with('course')
            ->where('type', 'timetable')
            ->orderBy('starts_at')
            ->paginate(20);

        return view('admin.timetables.index', compact('timetables'));
    }

    public function create()
    {
        return view('admin.timetables.create', [
            'timetable' => new CalendarEvent([
                'type' => 'timetable',
                'is_active' => true,
            ]),
            'courses' => $this->courses(),
        ]);
    }

    public function store(Request $request)
    {
        CalendarEvent::create($this->validatedData($request));

        return redirect()
            ->route('admin.timetables.index')
            ->with('success', 'Timetable entry created successfully.');
    }

    public function edit(CalendarEvent $timetable)
    {
        abort_if($timetable->type !== 'timetable', 404);

        return view('admin.timetables.edit', [
            'timetable' => $timetable,
            'courses' => $this->courses(),
        ]);
    }

    public function update(Request $request, CalendarEvent $timetable)
    {
        abort_if($timetable->type !== 'timetable', 404);

        $timetable->update($this->validatedData($request));

        return redirect()
            ->route('admin.timetables.index')
            ->with('success', 'Timetable entry updated successfully.');
    }

    public function destroy(CalendarEvent $timetable)
    {
        abort_if($timetable->type !== 'timetable', 404);

        $timetable->delete();

        return redirect()
            ->route('admin.timetables.index')
            ->with('success', 'Timetable entry deleted successfully.');
    }

    protected function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['type'] = 'timetable';
        $validated['student_id'] = null;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    protected function courses()
    {
        return Course::query()
            ->orderBy('title')
            ->get(['id', 'title']);
    }
}
