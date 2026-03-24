<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Schema::hasTable('partners')
            ? Partner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : new Collection();

        return view('frontend.partners', compact('partners'));
    }
}
