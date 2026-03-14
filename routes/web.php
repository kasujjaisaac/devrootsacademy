<?php

use Illuminate\Support\Facades\Route;

// =====================
// ADMIN CONTROLLERS
// =====================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\StudentController;

// =====================
// FRONTEND CONTROLLERS
// =====================
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\FrontendStudentController;
use App\Http\Controllers\FrontendInstructorController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::view('/', 'frontend.index')->name('home');

// About page
Route::view('/about', 'frontend.about')->name('about');

// Partners page
Route::view('/partners', 'frontend.partners')->name('partners');

// Contact page
Route::view('/contact', 'frontend.contact')->name('contact');

// Courses (DB driven)
Route::get('/courses', [FrontendCourseController::class, 'index'])
    ->name('courses.index');

Route::get('/courses/{slug}', [FrontendCourseController::class, 'show'])
    ->name('courses.show');

// Apply Now - Student Applications
Route::view('/apply-now', 'frontend.apply-now')->name('apply.now');
Route::post('/apply-now', [FrontendStudentController::class, 'submitApplication'])
    ->name('frontend.apply.submit');

// Become Instructor
Route::view('/become-instructor', 'frontend.become-instructor')
    ->name('instructor.form');
Route::post('/become-instructor', [FrontendInstructorController::class, 'submit'])
    ->name('frontend.instructor.submit');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

// Admin login page
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

// Handle admin login
Route::post('/admin/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

// Admin logout
Route::post('/admin/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('admin.logout');

// Default login redirect for auth middleware
Route::get('/login', function () {
    return redirect()->route('admin.login');
});

/*
|--------------------------------------------------------------------------
| User Chat Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [\App\Http\Controllers\Frontend\UserChatController::class, 'index'])
        ->name('user.chat.index');

    Route::post('/chat/start', [\App\Http\Controllers\Frontend\UserChatController::class, 'start'])
        ->name('user.chat.start');

    Route::get('/chat/{id}', [\App\Http\Controllers\Frontend\UserChatController::class, 'show'])
        ->name('user.chat.show');

    Route::post('/chat/{id}/message', [\App\Http\Controllers\Frontend\UserChatController::class, 'sendMessage'])
        ->name('user.chat.message');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Enrollments management
    Route::resource('enrollments', \App\Http\Controllers\Admin\EnrollmentController::class)->names([
        'index' => 'admin.enrollments.index',
        'create' => 'admin.enrollments.create',
        'store' => 'admin.enrollments.store',
        'show' => 'admin.enrollments.show',
        'edit' => 'admin.enrollments.edit',
        'update' => 'admin.enrollments.update',
        'destroy' => 'admin.enrollments.destroy',
    ]);

    // Courses management
    Route::resource('courses', CourseController::class)->names([
        'index' => 'admin.courses.index',
        'create' => 'admin.courses.create',
        'store' => 'admin.courses.store',
        'show' => 'admin.courses.show',
        'edit' => 'admin.courses.edit',
        'update' => 'admin.courses.update',
        'destroy' => 'admin.courses.destroy',
    ]);

    // Students management
    Route::resource('students', StudentController::class)->names([
        'index' => 'admin.students.index',
        'create' => 'admin.students.create',
        'store' => 'admin.students.store',
        'show' => 'admin.students.show',
        'edit' => 'admin.students.edit',
        'update' => 'admin.students.update',
        'destroy' => 'admin.students.destroy',
    ]);

    // Payments management
    Route::resource('payments', PaymentController::class)->names([
        'index' => 'admin.payments.index',
        'create' => 'admin.payments.create',
        'store' => 'admin.payments.store',
        'show' => 'admin.payments.show',
        'edit' => 'admin.payments.edit',
        'update' => 'admin.payments.update',
        'destroy' => 'admin.payments.destroy',
    ]);

    // Instructor approvals
    Route::get('/instructors', [InstructorController::class, 'index'])
        ->name('admin.instructors.index');

    Route::post('/instructors/{instructor}/approve', [InstructorController::class, 'approve'])
        ->name('admin.instructors.approve');

    Route::post('/instructors/{instructor}/reject', [InstructorController::class, 'reject'])
        ->name('admin.instructors.reject');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->name('admin.reports.index');

    // Admin Chats
    Route::get('/chats', [\App\Http\Controllers\Admin\ChatController::class, 'index'])
        ->name('admin.chats.index');

    Route::get('/chats/{id}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])
        ->name('admin.chats.show');

    Route::post('/chats/{id}/message', [\App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])
        ->name('admin.chats.message');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('admin.settings.index');
});

/*
|--------------------------------------------------------------------------
| Admin Search
|--------------------------------------------------------------------------
*/

Route::get('/admin/search', function (\Illuminate\Http\Request $request) {
    $query = $request->input('query');
    return redirect()->back()->with('message', "Search for: $query not implemented yet");
})->name('admin.search');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
