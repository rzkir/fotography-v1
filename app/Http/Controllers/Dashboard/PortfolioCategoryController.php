<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioCategoryRequest;
use App\Http\Requests\UpdatePortfolioCategoryRequest;
use App\Models\PortfolioCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortfolioCategoryController extends Controller
{
    public function index(): View
    {
        $categories = auth()->user()
            ->portfolioCategories()
            ->orderBy('title')
            ->get();

        return view('dashboard.portofolio.category', compact('categories'));
    }

    public function store(StorePortfolioCategoryRequest $request): RedirectResponse
    {
        auth()->user()->portfolioCategories()->create($request->validated());

        return redirect()
            ->route('dashboard.portofolio.category.index')
            ->with('success', 'Portfolio category created successfully.');
    }

    public function update(UpdatePortfolioCategoryRequest $request, PortfolioCategory $portfolioCategory): RedirectResponse
    {
        $this->authorizeCategory($portfolioCategory);

        $portfolioCategory->update($request->validated());

        return redirect()
            ->route('dashboard.portofolio.category.index')
            ->with('success', 'Portfolio category updated successfully.');
    }

    public function destroy(PortfolioCategory $portfolioCategory): RedirectResponse
    {
        $this->authorizeCategory($portfolioCategory);

        $inUse = auth()->user()
            ->portfolios()
            ->where('category', $portfolioCategory->title)
            ->exists();

        if ($inUse) {
            return redirect()
                ->route('dashboard.portofolio.category.index')
                ->withErrors(['category' => 'This category is still used by one or more projects.']);
        }

        $portfolioCategory->delete();

        return redirect()
            ->route('dashboard.portofolio.category.index')
            ->with('success', 'Portfolio category deleted successfully.');
    }

    private function authorizeCategory(PortfolioCategory $portfolioCategory): void
    {
        abort_if($portfolioCategory->user_id !== auth()->id(), 403);
    }
}
