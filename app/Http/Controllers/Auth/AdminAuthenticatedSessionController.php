<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Support\AuditLogger;
use App\Support\AccessControl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.admin-login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if (! $user->isAdmin()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'These credentials do not have admin access.',
            ]);
        }

        $request->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->save();
        AuditLogger::log(
            'staff.login',
            'Staff user signed in to the admin panel.',
            actor: $user,
            targetUser: $user,
            metadata: ['role' => $user->primaryRoleName()],
            request: $request,
        );

        return redirect()->intended($this->redirectPathFor($user));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            AuditLogger::log(
                'staff.logout',
                'Staff user signed out of the admin panel.',
                actor: $user,
                targetUser: $user,
                metadata: ['role' => $user->primaryRoleName()],
                request: $request,
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectPathFor($user): string
    {
        $routeMap = [
            AccessControl::VIEW_DASHBOARD => 'admin.dashboard',
            AccessControl::MANAGE_MESSAGES => 'admin.chats.index',
            AccessControl::MANAGE_PAYMENTS => 'admin.payments.index',
            AccessControl::MANAGE_STUDENT_APPLICATIONS => 'admin.student-applications.index',
            AccessControl::MANAGE_INSTRUCTOR_APPLICATIONS => 'admin.instructor-applications.index',
            AccessControl::MANAGE_STUDENTS => 'admin.students.index',
            AccessControl::MANAGE_ENROLLMENTS => 'admin.enrollments.index',
            AccessControl::MANAGE_COURSES => 'admin.courses.index',
            AccessControl::MANAGE_LECTURE_RECORDINGS => 'admin.lecture-recordings.index',
            AccessControl::MANAGE_TIMETABLES => 'admin.timetables.index',
            AccessControl::MANAGE_PARTNERS => 'admin.partners.index',
            AccessControl::MANAGE_INSTRUCTORS => 'admin.instructors.index',
            AccessControl::VIEW_REPORTS => 'admin.reports.index',
            AccessControl::MANAGE_STAFF_USERS => 'admin.staff-users.index',
            AccessControl::MANAGE_SETTINGS => 'admin.settings.index',
        ];

        foreach ($routeMap as $permission => $routeName) {
            if ($user->hasPermission($permission)) {
                return route($routeName);
            }
        }

        return route('home');
    }
}
