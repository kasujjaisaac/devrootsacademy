<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $instructors = User::where('role','instructor')
            ->withCount(['courses','enrollments'])
            ->get()
            ->map(function($i){
                $i->earnings = DB::table('payments')
                    ->join('enrollments','payments.enrollment_id','=','enrollments.id')
                    ->join('courses','enrollments.course_id','=','courses.id')
                    ->where('courses.instructor_id',$i->id)
                    ->sum('payments.amount');
                return $i;
            });

        return view('admin.instructors.earnings',compact('instructors'));
    }
}
