<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Instructor;

class ReportController extends Controller
{
    public function index()
    {
        $totalStudents    = Student::count();
        $totalInstructors = Instructor::count();
        $totalCourses     = Course::count();
        $totalPayments    = Payment::sum('amount');

        $months = collect(range(1,12))->map(fn($m) => date('M', mktime(0,0,0,$m,1)));

        $enrollmentsPerMonth = collect(range(1,12))->map(
            fn($m) => Enrollment::whereMonth('created_at', $m)->count()
        );

        $paymentsPerMonth = collect(range(1,12))->map(
            fn($m) => Payment::whereMonth('created_at', $m)->sum('amount')
        );

        $topCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(8)
            ->get();

        $recentEnrollments = Enrollment::with('student', 'course')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalStudents', 'totalInstructors', 'totalCourses', 'totalPayments',
            'months', 'enrollmentsPerMonth', 'paymentsPerMonth',
            'topCourses', 'recentEnrollments'
        ));
    }
}
