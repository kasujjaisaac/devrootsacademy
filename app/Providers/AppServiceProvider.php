<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Student;
use App\Models\Course;
use App\Models\Instructor;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer(['frontend.index', 'frontend.apply-now', 'frontend.become-instructor'], function ($view) {
            $view->with('siteStats', [
                'students' => Student::count() ?: 500,
                'courses'  => Course::where('is_active', true)->count() ?: 12,
                'partners' => 8,
                'satisfaction' => 95,
            ]);
        });

        View::composer('frontend.about', function ($view) {
            $view->with('instructors', Instructor::where('status', 'approved')->get());
        });
    }
}
