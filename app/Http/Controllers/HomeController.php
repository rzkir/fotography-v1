<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Portfolio;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $features = Feature::query()
            ->latest()
            ->get();

        $testimonials = Testimonial::query()
            ->latest()
            ->get();

        $portfolios = $this->featuredPortfoliosFromTopTeams();

        return view('home', compact('features', 'testimonials', 'portfolios'));
    }

    /**
     * @return Collection<int, Portfolio>
     */
    private function featuredPortfoliosFromTopTeams(): Collection
    {
        $portfolios = collect();
        $usedPortfolioIds = [];

        Team::query()
            ->orderByDesc('number')
            ->orderByDesc('id')
            ->with(['portfolios' => fn ($query) => $query
                ->where('is_published', true)
                ->with('portfolioCategory')
                ->latest()])
            ->limit(8)
            ->get()
            ->each(function (Team $team) use ($portfolios, &$usedPortfolioIds): void {
                $portfolio = $team->portfolios->first();

                if ($portfolio === null || in_array($portfolio->id, $usedPortfolioIds, true)) {
                    return;
                }

                $usedPortfolioIds[] = $portfolio->id;
                $portfolios->push($portfolio);
            });

        if ($portfolios->count() < 8) {
            Portfolio::query()
                ->where('is_published', true)
                ->with('portfolioCategory')
                ->when($usedPortfolioIds !== [], fn ($query) => $query->whereNotIn('id', $usedPortfolioIds))
                ->latest()
                ->limit(8 - $portfolios->count())
                ->get()
                ->each(function (Portfolio $portfolio) use ($portfolios, &$usedPortfolioIds): void {
                    $usedPortfolioIds[] = $portfolio->id;
                    $portfolios->push($portfolio);
                });
        }

        return $portfolios;
    }
}
