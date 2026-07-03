<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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

        $teams = $this->featuredTeams();

        return view('home', compact('features', 'testimonials', 'teams'));
    }

    /**
     * @return Collection<int, Team>
     */
    private function featuredTeams(): Collection
    {
        $teams = collect();
        $usedPortfolioIds = [];
        $usedTeamNames = [];

        Team::query()
            ->with(['portfolios' => fn ($query) => $query
                ->where('is_published', true)
                ->latest()])
            ->orderByDesc('number')
            ->orderByDesc('id')
            ->get()
            ->each(function (Team $team) use ($teams, &$usedPortfolioIds, &$usedTeamNames): void {
                if ($teams->count() >= 8) {
                    return;
                }

                $normalizedName = Str::lower(trim($team->name));

                if (in_array($normalizedName, $usedTeamNames, true)) {
                    return;
                }

                $featuredPortfolio = $team->portfolios->first();

                if ($featuredPortfolio !== null && in_array($featuredPortfolio->id, $usedPortfolioIds, true)) {
                    return;
                }

                $usedTeamNames[] = $normalizedName;

                if ($featuredPortfolio !== null) {
                    $usedPortfolioIds[] = $featuredPortfolio->id;
                }

                $teams->push($team);
            });

        return $teams;
    }
}
