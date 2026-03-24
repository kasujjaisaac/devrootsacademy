<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Partner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $partners = Schema::hasTable('partners')
            ? Partner::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->take(8)
                ->get()
            : new Collection();

        return view('frontend.index', compact('courses', 'partners'));
    }
}
