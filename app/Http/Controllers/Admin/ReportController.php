<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\InstructorApplication;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\StudentApplication;

class ReportController extends Controller
{
    public function index()
    {
        $year = now()->year;

        $totalStudents = Student::count();
        $totalInstructors = Instructor::count();
        $totalCourses = Course::count();
        $totalPayments = Payment::sum('amount');
        $completedRevenue = Payment::where('status', Payment::STATUS_COMPLETED)->sum('amount');
        $activeEnrollments = Enrollment::where('status', Enrollment::STATUS_ACTIVE)->count();
        $pendingApplications = StudentApplication::where('status', StudentApplication::STATUS_SUBMITTED)->count();

        $months = collect(range(1,12))->map(fn($m) => date('M', mktime(0,0,0,$m,1)));

        $enrollmentsPerMonth = collect(range(1,12))->map(
            fn($m) => Enrollment::whereYear('created_at', $year)->whereMonth('created_at', $m)->count()
        );

        $paymentsPerMonth = collect(range(1,12))->map(
            fn($m) => Payment::whereYear('created_at', $year)
                ->whereMonth('created_at', $m)
                ->where('status', Payment::STATUS_COMPLETED)
                ->sum('amount')
        );

        $enrollmentStatusLabels = collect(Enrollment::allowedStatuses())
            ->map(fn ($status) => ucfirst($status))
            ->values();
        $enrollmentStatusData = collect(Enrollment::allowedStatuses())
            ->map(fn ($status) => Enrollment::where('status', $status)->count())
            ->values();

        $paymentStatusLabels = collect([
            Payment::STATUS_PENDING,
            Payment::STATUS_COMPLETED,
            Payment::STATUS_FAILED,
            Payment::STATUS_CANCELLED,
            Payment::STATUS_REVERSED,
        ])->map(fn ($status) => ucfirst($status))->values();
        $paymentStatusData = collect([
            Payment::STATUS_PENDING,
            Payment::STATUS_COMPLETED,
            Payment::STATUS_FAILED,
            Payment::STATUS_CANCELLED,
            Payment::STATUS_REVERSED,
        ])->map(fn ($status) => Payment::where('status', $status)->count())->values();

        $studentApplicationLabels = collect([
            StudentApplication::STATUS_SUBMITTED,
            StudentApplication::STATUS_REVIEWED,
            StudentApplication::STATUS_ACCEPTED,
            StudentApplication::STATUS_REJECTED,
            StudentApplication::STATUS_ENROLLED,
        ])->map(fn ($status) => ucfirst($status))->values();
        $studentApplicationData = collect([
            StudentApplication::STATUS_SUBMITTED,
            StudentApplication::STATUS_REVIEWED,
            StudentApplication::STATUS_ACCEPTED,
            StudentApplication::STATUS_REJECTED,
            StudentApplication::STATUS_ENROLLED,
        ])->map(fn ($status) => StudentApplication::where('status', $status)->count())->values();

        $instructorApplicationLabels = collect([
            InstructorApplication::STATUS_SUBMITTED,
            InstructorApplication::STATUS_REVIEWED,
            InstructorApplication::STATUS_ACCEPTED,
            InstructorApplication::STATUS_REJECTED,
            InstructorApplication::STATUS_ACTIVATED,
        ])->map(fn ($status) => ucfirst($status))->values();
        $instructorApplicationData = collect([
            InstructorApplication::STATUS_SUBMITTED,
            InstructorApplication::STATUS_REVIEWED,
            InstructorApplication::STATUS_ACCEPTED,
            InstructorApplication::STATUS_REJECTED,
            InstructorApplication::STATUS_ACTIVATED,
        ])->map(fn ($status) => InstructorApplication::where('status', $status)->count())->values();

        $topCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(6)
            ->get();
        $topCourseLabels = $topCourses->pluck('title');
        $topCourseData = $topCourses->pluck('enrollments_count');

        $recentEnrollments = Enrollment::with('student', 'course')
            ->latest()
            ->take(10)
            ->get();

        $monthlyRevenueAverage = round($paymentsPerMonth->avg() ?: 0);

        return view('admin.reports.index', compact(
            'year',
            'totalStudents', 'totalInstructors', 'totalCourses', 'totalPayments',
            'completedRevenue', 'activeEnrollments', 'pendingApplications', 'monthlyRevenueAverage',
            'months', 'enrollmentsPerMonth', 'paymentsPerMonth',
            'enrollmentStatusLabels', 'enrollmentStatusData',
            'paymentStatusLabels', 'paymentStatusData',
            'studentApplicationLabels', 'studentApplicationData',
            'instructorApplicationLabels', 'instructorApplicationData',
            'topCourses', 'topCourseLabels', 'topCourseData',
            'recentEnrollments'
        ));
    }
}
