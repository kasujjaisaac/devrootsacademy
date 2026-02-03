<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
   

public function index(Request $request)
{
    $status = $request->query('status'); // pending, active, finished

    $students = Student::query();

    if ($status) {
        $students->where('status', $status);
    }

    $students = $students->paginate(20);

    return view('admin.students.index', compact('students', 'status'));
}
