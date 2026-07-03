<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function index(): View
    {
        $features = auth()->user()
            ->features()
            ->latest()
            ->get();

        return view('dashboard.features', compact('features'));
    }

    public function store(StoreFeatureRequest $request): RedirectResponse
    {
        auth()->user()->features()->create($request->validated());

        return redirect()
            ->route('dashboard.features.index')
            ->with('success', 'Feature created successfully.');
    }

    public function update(UpdateFeatureRequest $request, Feature $feature): RedirectResponse
    {
        $this->authorizeFeature($feature);

        $feature->update($request->validated());

        return redirect()
            ->route('dashboard.features.index')
            ->with('success', 'Feature updated successfully.');
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $this->authorizeFeature($feature);

        $feature->delete();

        return redirect()
            ->route('dashboard.features.index')
            ->with('success', 'Feature deleted successfully.');
    }

    private function authorizeFeature(Feature $feature): void
    {
        abort_if($feature->user_id !== auth()->id(), 403);
    }
}
