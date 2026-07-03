<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJurnalCategoryRequest;
use App\Http\Requests\UpdateJurnalCategoryRequest;
use App\Models\JurnalCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JurnalCategoryController extends Controller
{
    public function index(): View
    {
        $categories = auth()->user()
            ->jurnalCategories()
            ->orderBy('title')
            ->get();

        return view('dashboard.jurnal.category', compact('categories'));
    }

    public function store(StoreJurnalCategoryRequest $request): RedirectResponse
    {
        auth()->user()->jurnalCategories()->create($request->validated());

        return redirect()
            ->route('dashboard.jurnal.category.index')
            ->with('success', 'Journal category created successfully.');
    }

    public function update(UpdateJurnalCategoryRequest $request, JurnalCategory $jurnalCategory): RedirectResponse
    {
        $this->authorizeCategory($jurnalCategory);

        $jurnalCategory->update($request->validated());

        return redirect()
            ->route('dashboard.jurnal.category.index')
            ->with('success', 'Journal category updated successfully.');
    }

    public function destroy(JurnalCategory $jurnalCategory): RedirectResponse
    {
        $this->authorizeCategory($jurnalCategory);

        $inUse = auth()->user()
            ->jurnals()
            ->where('category_id', $jurnalCategory->category_id)
            ->exists();

        if ($inUse) {
            return redirect()
                ->route('dashboard.jurnal.category.index')
                ->withErrors(['category' => 'This category is still used by one or more articles.']);
        }

        $jurnalCategory->delete();

        return redirect()
            ->route('dashboard.jurnal.category.index')
            ->with('success', 'Journal category deleted successfully.');
    }

    private function authorizeCategory(JurnalCategory $jurnalCategory): void
    {
        abort_if($jurnalCategory->user_id !== auth()->id(), 403);
    }
}
