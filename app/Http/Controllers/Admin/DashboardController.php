<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Enrollment;
use App\Models\InstructorApplication;
use App\Models\Message;
use App\Models\Payment;
use App\Models\StudentApplication;
use App\Support\AccessControl;

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
                    'student_name' => $enrollment->student?->full_name ?? $enrollment->student?->name ?? 'N/A',
                    'student_avatar' => $enrollment->student?->avatar ?? asset('images/avatar.png'),
                    'course_title' => $enrollment->course?->title ?? 'N/A',
                    'status' => $enrollment->status ?? 'N/A',
                    'created_at' => $enrollment->created_at
                ];
            });

        $actionCards = collect([
            [
                'permission' => AccessControl::MANAGE_STUDENT_APPLICATIONS,
                'count' => StudentApplication::where('status', StudentApplication::STATUS_SUBMITTED)->count(),
                'label' => 'New student applications',
                'description' => 'Applicants waiting for admissions review.',
                'route' => route('admin.student-applications.index', ['status' => StudentApplication::STATUS_SUBMITTED]),
                'icon' => 'fa-file-signature',
            ],
            [
                'permission' => AccessControl::MANAGE_INSTRUCTOR_APPLICATIONS,
                'count' => InstructorApplication::where('status', InstructorApplication::STATUS_SUBMITTED)->count(),
                'label' => 'New instructor applications',
                'description' => 'Instructor applications waiting for review.',
                'route' => route('admin.instructor-applications.index', ['status' => InstructorApplication::STATUS_SUBMITTED]),
                'icon' => 'fa-user-check',
            ],
            [
                'permission' => AccessControl::MANAGE_MESSAGES,
                'count' => Message::where('is_admin', false)->whereNull('read_at')->count(),
                'label' => 'Unread student messages',
                'description' => 'Support messages that still need an admin response.',
                'route' => route('admin.chats.index'),
                'icon' => 'fa-comments',
            ],
            [
                'permission' => AccessControl::MANAGE_PAYMENTS,
                'count' => Payment::where('status', Payment::STATUS_PENDING)->count(),
                'label' => 'Pending payment records',
                'description' => 'Payments still awaiting final confirmation.',
                'route' => route('admin.payments.index'),
                'icon' => 'fa-credit-card',
            ],
        ])->filter(fn (array $card) => $request->user()?->hasPermission($card['permission']))->values();

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
            'actionCards' => $actionCards,
        ]);
    }
}
