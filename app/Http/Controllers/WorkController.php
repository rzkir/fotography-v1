<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        $portfolios = Portfolio::query()
            ->where('is_published', true)
            ->with('portfolioCategory')
            ->latest()
            ->get();

        $featuredPortfolios = $portfolios->take(2);
        $gridPortfolios = $portfolios->skip(2)->values();

        $categoryIds = $portfolios->pluck('category_id')->filter()->unique();
        $categories = PortfolioCategory::query()
            ->whereIn('category_id', $categoryIds)
            ->orderBy('title')
            ->get()
            ->map(function (PortfolioCategory $category) use ($portfolios) {
                $category->published_count = $portfolios
                    ->where('category_id', $category->category_id)
                    ->count();

                return $category;
            });

        $totalProjects = $portfolios->count();
        $uniqueLocations = $portfolios->pluck('location')->filter()->unique()->count();

        return view('works.index', compact(
            'featuredPortfolios',
            'gridPortfolios',
            'portfolios',
            'categories',
            'totalProjects',
            'uniqueLocations',
        ));
    }

    public function gallery(): View
    {
        return view('gellery');
    }

    public function show(Portfolio $portfolio): View
    {
        abort_unless($portfolio->is_published, 404);

        $portfolio->load('portfolioCategory', 'teams');

        $relatedPortfolios = Portfolio::query()
            ->where('is_published', true)
            ->whereKeyNot($portfolio->id)
            ->with('portfolioCategory')
            ->latest()
            ->limit(6)
            ->get();

        return view('works.details', compact('portfolio', 'relatedPortfolios'));
    }
}
