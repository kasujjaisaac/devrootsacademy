<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;

class ReportController extends Controller
{
    public function index()
    {
        // Example data for dashboard reports
        $topCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        $revenueData = collect(range(1,12))->map(function($month){
            return Payment::whereMonth('created_at', $month)->sum('amount');
        });

        return view('admin.reports.index', compact('topCourses', 'revenueData'));
    }
}
