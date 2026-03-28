<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\InstructorApplicationController;
use App\Http\Controllers\Admin\LectureRecordingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffUserController;
use App\Http\Controllers\Admin\StudentApplicationController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\Frontend\PartnerController as FrontendPartnerController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\FrontendStudentController;
use App\Http\Controllers\FrontendInstructorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\HomeController;
use App\Support\AccessControl;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about',    'frontend.about')->name('about');
Route::get('/partners', [FrontendPartnerController::class, 'index'])->name('partners');
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
Route::get('/admin/login', [\App\Http\Controllers\Auth\AdminAuthenticatedSessionController::class, 'create'])->name('admin.login');
Route::post('/admin/login',  [\App\Http\Controllers\Auth\AdminAuthenticatedSessionController::class, 'store']);
Route::post('/admin/logout', [\App\Http\Controllers\Auth\AdminAuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

// User Chat
Route::middleware(['auth'])->group(function () {
    Route::get('/chat',               [\App\Http\Controllers\Frontend\UserChatController::class, 'index'])->name('user.chat.index');
    Route::post('/chat/start',        [\App\Http\Controllers\Frontend\UserChatController::class, 'start'])->name('user.chat.start');
    Route::get('/chat/{id}',          [\App\Http\Controllers\Frontend\UserChatController::class, 'show'])->name('user.chat.show');
    Route::post('/chat/{id}/message', [\App\Http\Controllers\Frontend\UserChatController::class, 'sendMessage'])->name('user.chat.message');
});

Route::prefix('student')->middleware(['auth', 'student'])->group(function () {
    Route::get('/', [StudentPortalController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/profile', [StudentPortalController::class, 'profile'])->name('student.profile');
    Route::get('/payments', [StudentPortalController::class, 'payments'])->name('student.payments');
    Route::get('/calendar', [StudentPortalController::class, 'calendar'])->name('student.calendar');
    Route::get('/recordings', [StudentPortalController::class, 'recordings'])->name('student.recordings');
    Route::post('/payments/initiate', [StudentPaymentController::class, 'initiate'])->name('student.payments.initiate');
});

Route::get('/student/payments/callback', [StudentPaymentController::class, 'callback'])->name('student.payments.callback');
Route::match(['get', 'post'], '/payments/pesapal/ipn', [StudentPaymentController::class, 'ipn'])->name('payments.pesapal.ipn');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/notifications/read-all', [AdminNotificationController::class, 'markAllRead'])->name('admin.notifications.read-all');
    Route::post('/notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])->name('admin.notifications.read');

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('permission:'.AccessControl::VIEW_DASHBOARD)
        ->name('admin.dashboard');

    Route::resource('enrollments', \App\Http\Controllers\Admin\EnrollmentController::class)
        ->middleware('permission:'.AccessControl::MANAGE_ENROLLMENTS)
        ->names(['index'=>'admin.enrollments.index','create'=>'admin.enrollments.create','store'=>'admin.enrollments.store','show'=>'admin.enrollments.show','edit'=>'admin.enrollments.edit','update'=>'admin.enrollments.update','destroy'=>'admin.enrollments.destroy']);

    Route::resource('courses', CourseController::class)
        ->middleware('permission:'.AccessControl::MANAGE_COURSES)
        ->names(['index'=>'admin.courses.index','create'=>'admin.courses.create','store'=>'admin.courses.store','show'=>'admin.courses.show','edit'=>'admin.courses.edit','update'=>'admin.courses.update','destroy'=>'admin.courses.destroy']);

    Route::resource('lecture-recordings', LectureRecordingController::class)
        ->middleware('permission:'.AccessControl::MANAGE_LECTURE_RECORDINGS)
        ->except(['show'])
        ->names([
            'index'=>'admin.lecture-recordings.index',
            'create'=>'admin.lecture-recordings.create',
            'store'=>'admin.lecture-recordings.store',
            'edit'=>'admin.lecture-recordings.edit',
            'update'=>'admin.lecture-recordings.update',
            'destroy'=>'admin.lecture-recordings.destroy',
        ]);

    Route::resource('timetables', TimetableController::class)
        ->middleware('permission:'.AccessControl::MANAGE_TIMETABLES)
        ->except(['show'])
        ->names(['index'=>'admin.timetables.index','create'=>'admin.timetables.create','store'=>'admin.timetables.store','edit'=>'admin.timetables.edit','update'=>'admin.timetables.update','destroy'=>'admin.timetables.destroy']);

    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class)
        ->middleware('permission:'.AccessControl::MANAGE_PARTNERS)
        ->except(['show'])
        ->names(['index'=>'admin.partners.index','create'=>'admin.partners.create','store'=>'admin.partners.store','edit'=>'admin.partners.edit','update'=>'admin.partners.update','destroy'=>'admin.partners.destroy']);

    Route::middleware('permission:'.AccessControl::MANAGE_STUDENT_APPLICATIONS)->group(function () {
        Route::get('applications', [StudentApplicationController::class, 'index'])->name('admin.student-applications.index');
        Route::get('applications/{studentApplication}', [StudentApplicationController::class, 'show'])->name('admin.student-applications.show');
        Route::post('applications/{studentApplication}/review', [StudentApplicationController::class, 'review'])->name('admin.student-applications.review');
        Route::post('applications/{studentApplication}/accept', [StudentApplicationController::class, 'accept'])->name('admin.student-applications.accept');
        Route::post('applications/{studentApplication}/reject', [StudentApplicationController::class, 'reject'])->name('admin.student-applications.reject');
        Route::post('applications/{studentApplication}/enroll', [StudentApplicationController::class, 'enroll'])->name('admin.student-applications.enroll');
    });

    Route::resource('students', StudentController::class)
        ->middleware('permission:'.AccessControl::MANAGE_STUDENTS)
        ->names(['index'=>'admin.students.index','create'=>'admin.students.create','store'=>'admin.students.store','show'=>'admin.students.show','edit'=>'admin.students.edit','update'=>'admin.students.update','destroy'=>'admin.students.destroy']);

    Route::resource('payments', PaymentController::class)
        ->middleware('permission:'.AccessControl::MANAGE_PAYMENTS)
        ->names(['index'=>'admin.payments.index','create'=>'admin.payments.create','store'=>'admin.payments.store','show'=>'admin.payments.show','edit'=>'admin.payments.edit','update'=>'admin.payments.update','destroy'=>'admin.payments.destroy']);

    Route::get('/instructors', [InstructorController::class, 'index'])
        ->middleware('permission:'.AccessControl::MANAGE_INSTRUCTORS)
        ->name('admin.instructors.index');

    Route::middleware('permission:'.AccessControl::MANAGE_INSTRUCTOR_APPLICATIONS)->group(function () {
        Route::get('/instructor-applications', [InstructorApplicationController::class, 'index'])->name('admin.instructor-applications.index');
        Route::get('/instructor-applications/{instructorApplication}', [InstructorApplicationController::class, 'show'])->name('admin.instructor-applications.show');
        Route::post('/instructor-applications/{instructorApplication}/review', [InstructorApplicationController::class, 'review'])->name('admin.instructor-applications.review');
        Route::post('/instructor-applications/{instructorApplication}/accept', [InstructorApplicationController::class, 'accept'])->name('admin.instructor-applications.accept');
        Route::post('/instructor-applications/{instructorApplication}/reject', [InstructorApplicationController::class, 'reject'])->name('admin.instructor-applications.reject');
        Route::post('/instructor-applications/{instructorApplication}/activate', [InstructorApplicationController::class, 'activate'])->name('admin.instructor-applications.activate');
    });

    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->middleware('permission:'.AccessControl::VIEW_REPORTS)
        ->name('admin.reports.index');

    Route::middleware('permission:'.AccessControl::MANAGE_MESSAGES)->group(function () {
        Route::get('/chats', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chats.index');
        Route::get('/chats/{id}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('admin.chats.show');
        Route::post('/chats/{id}/message', [\App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('admin.chats.message');
        Route::post('/chats/{id}/status', [\App\Http\Controllers\Admin\ChatController::class, 'updateStatus'])->name('admin.chats.status');
        Route::post('/chats/{id}/assign', [\App\Http\Controllers\Admin\ChatController::class, 'assignToMe'])->name('admin.chats.assign');
    });

    Route::get('/settings', [SettingController::class, 'index'])
        ->middleware('permission:'.AccessControl::MANAGE_SETTINGS)
        ->name('admin.settings.index');

    Route::middleware(['permission:'.AccessControl::MANAGE_STAFF_USERS, 'role:super_admin'])->group(function () {
        Route::get('/staff-users', [StaffUserController::class, 'index'])->name('admin.staff-users.index');
        Route::get('/staff-users/create', [StaffUserController::class, 'create'])->name('admin.staff-users.create');
        Route::post('/staff-users', [StaffUserController::class, 'store'])->name('admin.staff-users.store');
        Route::get('/staff-users/{staffUser}/edit', [StaffUserController::class, 'edit'])->name('admin.staff-users.edit');
        Route::put('/staff-users/{staffUser}', [StaffUserController::class, 'update'])->name('admin.staff-users.update');
        Route::post('/staff-users/{staffUser}/deactivate', [StaffUserController::class, 'deactivate'])->name('admin.staff-users.deactivate');
        Route::post('/staff-users/{staffUser}/activate', [StaffUserController::class, 'activate'])->name('admin.staff-users.activate');
        Route::post('/staff-users/{staffUser}/send-password-reset', [StaffUserController::class, 'sendPasswordReset'])->name('admin.staff-users.send-password-reset');
    });
});

Route::get('/admin/search', fn(\Illuminate\Http\Request $r) => redirect()->back()->with('message','Search not implemented'))->name('admin.search');

require __DIR__.'/auth.php';
