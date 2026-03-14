<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Enrollment;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ===== KPI STATS =====
        $students = Student::count();
        $activeStudents = Student::where('status', 'active')->count(); // if status column exists
        $finishedStudents = Student::where('status', 'finished')->count(); // optional
        $courses = Course::count();
        $instructors = Instructor::count();
        
        // Payments KPI: total payments count (no 'status' column needed)
        $payments = Payment::count();

        // ===== COURSES LIST =====
        $coursesList = Course::all();
        $selectedCourse = $request->query('course', null);

        // ===== MONTHLY ENROLLMENTS =====
        $months = collect(range(1,12))->map(function($m){
            return date('M', mktime(0,0,0,$m,1));
        });

        $monthlyEnrollments = collect(range(1,12))->map(function($month) use ($selectedCourse){
            $query = Enrollment::whereMonth('created_at', $month);
            if ($selectedCourse) {
                $query->where('course_id', $selectedCourse);
            }
            return $query->count();
        });

        // ===== TOP COURSES BY ENROLLMENT =====
        $topCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count','desc')
            ->take(5)
            ->get();

        // ===== REVENUE DATA =====
        $revenueMonths = $months;
        $revenueData = collect(range(1,12))->map(function($month){
            return Payment::whereMonth('created_at',$month)->sum('amount');
        });

        // ===== RECENT ENROLLMENTS =====
        $recentEnrollments = Enrollment::with('student','course')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($enrollment){
                return [
                    'student_name' => $enrollment->student->full_name ?? $enrollment->student->name ?? 'N/A',
                    'student_avatar' => $enrollment->student->avatar ?? asset('images/avatar.png'),
                    'course_title' => $enrollment->course->title,
                    'status' => $enrollment->status ?? 'N/A',
                    'created_at' => $enrollment->created_at
                ];
            });

        // ===== PASS VARIABLES TO VIEW (old variable names) =====
        return view('admin.dashboard', [
            'students' => $students,
            'courses' => $courses,
            'instructors' => $instructors,
            'payments' => $payments,
            'monthlyEnrollments' => $monthlyEnrollments,
            'months' => $months,
            'revenueMonths' => $revenueMonths,
            'revenueData' => $revenueData,
            'recentEnrollments' => $recentEnrollments,
            'topCourses' => $topCourses,
            'coursesList' => $coursesList,
            'selectedCourse' => $selectedCourse,
            'activeStudents' => $activeStudents,
            'finishedStudents' => $finishedStudents,
        ]);
    }
}
