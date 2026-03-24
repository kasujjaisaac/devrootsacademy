<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Throwable;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('partners', 'public');
            }

            Partner::create($data);
        } catch (Throwable $e) {
            if (! empty($data['logo']) && ! Str::startsWith($data['logo'], 'images/') && Storage::disk('public')->exists($data['logo'])) {
                Storage::disk('public')->delete($data['logo']);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'The partner could not be saved. Check the database connection and try again.');
        }

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validatedData($request, $partner);

        try {
            if ($request->hasFile('logo')) {
                if ($partner->logo && ! Str::startsWith($partner->logo, 'images/') && Storage::disk('public')->exists($partner->logo)) {
                    Storage::disk('public')->delete($partner->logo);
                }

                $data['logo'] = $request->file('logo')->store('partners', 'public');
            }

            $partner->update($data);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'The partner could not be updated. Check the database connection and try again.');
        }

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo && ! Str::startsWith($partner->logo, 'images/') && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }

    protected function validatedData(Request $request, ?Partner $partner = null): array
    {
        $slug = $request->input('slug') ?: Str::slug((string) $request->input('name'));

        $validated = $request->merge([
            'slug' => $slug,
        ])->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('partners', 'slug')->ignore($partner),
            ],
            'logo' => [$partner ? 'nullable' : 'required', 'image', 'max:2048'],
            'website_url' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
