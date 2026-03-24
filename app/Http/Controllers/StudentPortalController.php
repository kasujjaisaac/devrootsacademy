<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    public function dashboard(Request $request)
    {
        $student = $this->student($request);
        $events = $this->upcomingEvents($student);
        $payments = $student->payments()->with('course')->latest()->take(5)->get();

        $feeTotal = $student->enrollments->sum(fn($enrollment) => (int) ($enrollment->course?->fee ?? 0));
        $paidTotal = (int) $student->payments->sum('amount');

        return view('student.dashboard', [
            'student' => $student,
            'payments' => $payments,
            'events' => $events,
            'stats' => [
                'enrollments' => $student->enrollments->count(),
                'active_courses' => $student->enrollments->where('status', 'active')->count(),
                'completed_courses' => $student->enrollments->where('status', 'completed')->count(),
                'paid_total' => $paidTotal,
                'balance' => max($feeTotal - $paidTotal, 0),
            ],
        ]);
    }

    public function profile(Request $request)
    {
        return view('student.profile', [
            'student' => $this->student($request),
        ]);
    }

    public function payments(Request $request)
    {
        $student = $this->student($request);
        $payments = $student->payments()->with('course')->latest()->get();
        $feeTotal = $student->enrollments->sum(fn($enrollment) => (int) ($enrollment->course?->fee ?? 0));
        $paidTotal = (int) $student->payments->sum('amount');

        return view('student.payments', [
            'student' => $student,
            'payments' => $payments,
            'summary' => [
                'fee_total' => $feeTotal,
                'paid_total' => $paidTotal,
                'balance' => max($feeTotal - $paidTotal, 0),
            ],
        ]);
    }

    public function calendar(Request $request)
    {
        $student = $this->student($request);

        return view('student.calendar', [
            'student' => $student,
            'events' => $this->upcomingEvents($student, 120),
        ]);
    }

    protected function student(Request $request)
    {
        return $request->user()
            ->student()
            ->with(['enrollments.course', 'payments.course'])
            ->firstOrFail();
    }

    protected function upcomingEvents($student, int $days = 45)
    {
        $courseIds = $student->enrollments->pluck('course_id')->filter()->values();

        return CalendarEvent::query()
            ->with('course')
            ->where('is_active', true)
            ->where(function ($query) use ($student, $courseIds) {
                $query->whereNull('student_id')
                    ->whereNull('course_id');

                $query->orWhere('student_id', $student->id);

                if ($courseIds->isNotEmpty()) {
                    $query->orWhereIn('course_id', $courseIds);
                }
            })
            ->whereBetween('starts_at', [now()->startOfDay(), now()->addDays($days)->endOfDay()])
            ->orderBy('starts_at')
            ->get();
    }
}
