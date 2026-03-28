<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LectureRecording;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class LectureRecordingController extends Controller
{
    public function index()
    {
        $recordings = LectureRecording::query()
            ->with(['course', 'uploader'])
            ->latest('class_date')
            ->latest('id')
            ->get();

        return view('admin/lecture-recordings.index', [
            'recordings' => $recordings,
        ]);
    }

    public function create()
    {
        return view('admin/lecture-recordings.create', [
            'recording' => new LectureRecording(),
            'courses' => Course::query()->where('is_active', true)->orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $recording = LectureRecording::create([
            ...$validated,
            'is_published' => $request->boolean('is_published', true),
            'uploaded_by' => $request->user()->id,
        ]);

        $recording->load('course');
        $this->logAction($request, $recording, 'lecture_recording.created', 'Added lecture recording.');

        return redirect()
            ->route('admin.lecture-recordings.index')
            ->with('success', 'Lecture recording added successfully.');
    }

    public function edit(LectureRecording $lectureRecording)
    {
        return view('admin/lecture-recordings.edit', [
            'recording' => $lectureRecording,
            'courses' => Course::query()->where('is_active', true)->orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, LectureRecording $lectureRecording)
    {
        $validated = $this->validateRequest($request);
        $validated['is_published'] = $request->boolean('is_published');

        $lectureRecording->update($validated);
        $lectureRecording->load('course');
        $this->logAction($request, $lectureRecording, 'lecture_recording.updated', 'Updated lecture recording.');

        return redirect()
            ->route('admin.lecture-recordings.index')
            ->with('success', 'Lecture recording updated successfully.');
    }

    public function destroy(LectureRecording $lectureRecording)
    {
        $lectureRecording->load('course');
        $this->logAction(request(), $lectureRecording, 'lecture_recording.deleted', 'Removed lecture recording.');
        $lectureRecording->delete();

        return redirect()
            ->route('admin.lecture-recordings.index')
            ->with('success', 'Lecture recording removed successfully.');
    }

    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'topic' => ['nullable', 'string', 'max:255'],
            'class_date' => ['required', 'date'],
            'google_drive_url' => ['required', 'url', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    protected function logAction(Request $request, LectureRecording $recording, string $action, string $description): void
    {
        AuditLogger::log(
            $action,
            $description,
            actor: $request->user(),
            metadata: [
                'recording_id' => $recording->id,
                'course' => $recording->course?->title,
                'title' => $recording->title,
                'published' => $recording->is_published,
            ],
            request: $request,
        );
    }
}
