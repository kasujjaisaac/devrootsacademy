<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\FrontendStudentController;
use App\Http\Controllers\FrontendInstructorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\HomeController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about',    'frontend.about')->name('about');
Route::view('/partners', 'frontend.partners')->name('partners');
Route::view('/privacy',  'frontend.privacy')->name('privacy');
Route::view('/terms',    'frontend.terms')->name('terms');
Route::get('/contact',  [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/courses',        [FrontendCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [FrontendCourseController::class, 'show'])->name('courses.show');
Route::get('/apply-now',  [FrontendStudentController::class, 'showForm'])->name('apply.now');
Route::post('/apply-now', [FrontendStudentController::class, 'submitApplication'])->name('frontend.apply.submit');
Route::get('/become-instructor',  [FrontendInstructorController::class, 'showForm'])->name('instructor.form');
Route::post('/become-instructor', [FrontendInstructorController::class, 'submit'])->name('frontend.instructor.submit');

// Admin Auth
Route::get('/admin/login', fn() => view('auth.admin-login'))->name('admin.login');
Route::post('/admin/login',  [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/admin/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
Route::get('/login', fn() => redirect()->route('admin.login'));

// User Chat
Route::middleware(['auth'])->group(function () {
    Route::get('/chat',               [\App\Http\Controllers\Frontend\UserChatController::class, 'index'])->name('user.chat.index');
    Route::post('/chat/start',        [\App\Http\Controllers\Frontend\UserChatController::class, 'start'])->name('user.chat.start');
    Route::get('/chat/{id}',          [\App\Http\Controllers\Frontend\UserChatController::class, 'show'])->name('user.chat.show');
    Route::post('/chat/{id}/message', [\App\Http\Controllers\Frontend\UserChatController::class, 'sendMessage'])->name('user.chat.message');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('enrollments', \App\Http\Controllers\Admin\EnrollmentController::class)->names(['index'=>'admin.enrollments.index','create'=>'admin.enrollments.create','store'=>'admin.enrollments.store','show'=>'admin.enrollments.show','edit'=>'admin.enrollments.edit','update'=>'admin.enrollments.update','destroy'=>'admin.enrollments.destroy']);
    Route::resource('courses', CourseController::class)->names(['index'=>'admin.courses.index','create'=>'admin.courses.create','store'=>'admin.courses.store','show'=>'admin.courses.show','edit'=>'admin.courses.edit','update'=>'admin.courses.update','destroy'=>'admin.courses.destroy']);
    Route::resource('students', StudentController::class)->names(['index'=>'admin.students.index','create'=>'admin.students.create','store'=>'admin.students.store','show'=>'admin.students.show','edit'=>'admin.students.edit','update'=>'admin.students.update','destroy'=>'admin.students.destroy']);
    Route::resource('payments', PaymentController::class)->names(['index'=>'admin.payments.index','create'=>'admin.payments.create','store'=>'admin.payments.store','show'=>'admin.payments.show','edit'=>'admin.payments.edit','update'=>'admin.payments.update','destroy'=>'admin.payments.destroy']);
    Route::get('/instructors',                       [InstructorController::class, 'index'])->name('admin.instructors.index');
    Route::post('/instructors/{instructor}/approve', [InstructorController::class, 'approve'])->name('admin.instructors.approve');
    Route::post('/instructors/{instructor}/reject',  [InstructorController::class, 'reject'])->name('admin.instructors.reject');
    Route::get('/reports',             [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/chats',               [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chats.index');
    Route::get('/chats/{id}',          [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('admin.chats.show');
    Route::post('/chats/{id}/message', [\App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('admin.chats.message');
    Route::get('/settings',            [SettingController::class, 'index'])->name('admin.settings.index');
});

Route::get('/admin/search', fn(\Illuminate\Http\Request $r) => redirect()->back()->with('message','Search not implemented'))->name('admin.search');

require __DIR__.'/auth.php';
