<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check() || ! Auth::user()->hasRole($role)) {
            abort(403, 'You do not have the required role for this action.');
        }

        return $next($request);
    }
}
