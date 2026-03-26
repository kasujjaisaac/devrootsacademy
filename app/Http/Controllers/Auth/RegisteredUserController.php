<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View|RedirectResponse
    {
        return redirect()
            ->route('login')
            ->with('status', 'Student portal access is created by the academy after enrollment. Use your email invitation or password reset link to sign in.');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->with('status', 'Self-registration is disabled. Student accounts are created by the academy after enrollment.');
    }
}
