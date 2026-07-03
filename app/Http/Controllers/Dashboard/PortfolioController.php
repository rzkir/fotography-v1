<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolios = auth()->user()
            ->portfolios()
            ->with('portfolioCategory')
            ->latest()
            ->get();

        return view('dashboard.portofolio.index', compact('portfolios'));
    }

    public function create(): View
    {
        $categories = auth()->user()->portfolioCategories()->orderBy('title')->get();
        $teams = auth()->user()->teams()->orderBy('name')->get();

        return view('dashboard.portofolio.create', compact('categories', 'teams'));
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $portfolio = auth()->user()->portfolios()->create(
            $this->buildPortfolioAttributes($request)
        );

        $this->syncTeamMembers($portfolio, $request);

        return redirect()
            ->route('dashboard.portofolio.edit', $portfolio)
            ->with('success', 'Portfolio project created successfully.');
    }

    public function edit(Portfolio $portofolio): View
    {
        $this->authorizePortfolio($portofolio);

        $categories = auth()->user()->portfolioCategories()->orderBy('title')->get();
        $teams = auth()->user()->teams()->orderBy('name')->get();
        $portofolio->load('teams');

        return view('dashboard.portofolio.edit', [
            'portfolio' => $portofolio,
            'categories' => $categories,
            'teams' => $teams,
        ]);
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portofolio): RedirectResponse
    {
        $this->authorizePortfolio($portofolio);

        $portofolio->update(
            $this->buildPortfolioAttributes($request, $portofolio)
        );

        $this->syncTeamMembers($portofolio, $request);

        return redirect()
            ->route('dashboard.portofolio.edit', $portofolio)
            ->with('success', 'Portfolio project updated successfully.');
    }

    public function destroy(Portfolio $portofolio): RedirectResponse
    {
        $this->authorizePortfolio($portofolio);

        $teamIds = $portofolio->teams()->pluck('teams.id')->all();

        $this->deletePortfolioFiles($portofolio);
        $portofolio->delete();

        Team::recalculateNumbers($teamIds);

        return redirect()
            ->route('dashboard.portofolio.index')
            ->with('success', 'Portfolio project deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function buildPortfolioAttributes(Request $request, ?Portfolio $portfolio = null): array
    {
        $title = $request->string('title')->toString();

        $attributes = [
            'title' => $title,
            'slug' => $this->resolveSlug($request, $portfolio),
            'subtitle' => $request->input('subtitle'),
            'client' => $request->input('client'),
            'year' => (int) $request->input('year'),
            'category_id' => $request->input('category_id'),
            'location' => $request->input('location'),
            'hero_caption' => $request->input('hero_caption'),
            'quote' => $request->input('quote'),
            'content_sections' => $this->buildContentSections($request),
            'gallery_images' => $this->buildGalleryImages($request, $portfolio),
            'metrics' => $this->buildMetrics($request),
            'technical_specs' => $this->buildTechnicalSpecs($request),
            'timeline' => $this->buildTimeline($request),
            'contributors' => null,
            'testimonial' => $this->buildTestimonial($request),
            'status' => $request->input('status'),
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('hero_image')) {
            if ($portfolio?->hero_image) {
                Storage::disk('public')->delete($portfolio->hero_image);
            }

            $attributes['hero_image'] = $request->file('hero_image')->store('portfolios/heroes', 'public');
        }

        return $attributes;
    }

    /**
     * @return list<array{title: string, description: string|null}>
     */
    private function buildContentSections(Request $request): array
    {
        return collect($request->input('content_sections', []))
            ->filter(fn (array $section): bool => filled($section['title'] ?? null) || filled($section['description'] ?? null))
            ->map(fn (array $section): array => [
                'title' => $section['title'] ?? '',
                'description' => $section['description'] ?? null,
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function buildGalleryImages(Request $request, ?Portfolio $portfolio = null): array
    {
        $gallery = [];

        if ($request->filled('existing_gallery')) {
            $existing = json_decode($request->string('existing_gallery')->toString(), true);
            if (is_array($existing)) {
                $gallery = $existing;
            }
        } elseif ($portfolio !== null) {
            $gallery = $portfolio->gallery_images ?? [];
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if (! $file->isValid()) {
                    continue;
                }

                $path = $file->store('portfolios/gallery', 'public');
                $gallery[] = [
                    'path' => $path,
                    'caption' => '',
                    'alt' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                ];
            }
        }

        if ($portfolio !== null) {
            $this->deleteRemovedGalleryFiles($portfolio, $gallery);
        }

        return array_values($gallery);
    }

    /**
     * @return array<string, string|null>
     */
    private function buildMetrics(Request $request): array
    {
        return [
            'shots_taken' => $request->input('metrics_shots_taken'),
            'final_selects' => $request->input('metrics_final_selects'),
            'total_hours' => $request->input('metrics_total_hours'),
            'team_members' => $request->input('metrics_team_members'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildTechnicalSpecs(Request $request): array
    {
        return [
            'camera_setup' => $request->input('camera_setup'),
            'camera_settings' => $request->input('camera_settings'),
            'lighting_array' => $request->input('lighting_array'),
            'lighting_notes' => $request->input('lighting_notes'),
            'post_processing' => $this->buildPostProcessing($request),
            'retouching_notes' => $request->input('retouching_notes'),
        ];
    }

    /**
     * @return list<array{title: string, text: string|null}>
     */
    private function buildPostProcessing(Request $request): array
    {
        return collect($request->input('post_processing', []))
            ->filter(fn (array $step): bool => filled($step['title'] ?? null) || filled($step['text'] ?? null))
            ->map(fn (array $step): array => [
                'title' => $step['title'] ?? '',
                'text' => $step['text'] ?? null,
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{title: string, text: string|null}>
     */
    private function buildTimeline(Request $request): array
    {
        return collect($request->input('timeline', []))
            ->filter(fn (array $item): bool => filled($item['title'] ?? null) || filled($item['text'] ?? null))
            ->map(fn (array $item): array => [
                'title' => $item['title'] ?? '',
                'text' => $item['text'] ?? null,
            ])
            ->values()
            ->all();
    }

    private function syncTeamMembers(Portfolio $portfolio, Request $request): void
    {
        $oldTeamIds = $portfolio->teams()->pluck('teams.id');

        $teamIds = collect($request->input('team_members', []))
            ->pluck('team_id')
            ->filter()
            ->filter(fn ($teamId): bool => Team::query()
                ->where('user_id', auth()->id())
                ->whereKey($teamId)
                ->exists())
            ->unique()
            ->values()
            ->all();

        $portfolio->teams()->sync($teamIds);

        $affectedTeamIds = $oldTeamIds
            ->merge($teamIds)
            ->unique()
            ->values()
            ->all();

        Team::recalculateNumbers($affectedTeamIds);
    }

    /**
     * @return array<string, string|null>|null
     */
    private function buildTestimonial(Request $request): ?array
    {
        if (! $request->filled('testimonial_quote')) {
            return null;
        }

        return [
            'quote' => $request->input('testimonial_quote'),
            'author' => auth()->user()->name,
        ];
    }

    private function authorizePortfolio(Portfolio $portfolio): void
    {
        abort_if($portfolio->user_id !== auth()->id(), 403);
    }

    private function resolveSlug(Request $request, ?Portfolio $portfolio = null): string
    {
        $title = $request->string('title')->toString();
        $slugBase = Str::slug($request->filled('slug') ? $request->string('slug')->toString() : $title);

        if ($slugBase === '') {
            $slugBase = Str::slug($title) ?: 'project';
        }

        $slug = $slugBase;
        $counter = 1;

        while (Portfolio::query()
            ->where('slug', $slug)
            ->when($portfolio, fn ($query) => $query->where('id', '!=', $portfolio->id))
            ->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function deletePortfolioFiles(Portfolio $portfolio): void
    {
        if ($portfolio->hero_image) {
            Storage::disk('public')->delete($portfolio->hero_image);
        }

        foreach ($portfolio->gallery_images ?? [] as $image) {
            if (! empty($image['path'])) {
                Storage::disk('public')->delete($image['path']);
            }
        }
    }

    /**
     * @param  list<array<string, mixed>>  $newGallery
     */
    private function deleteRemovedGalleryFiles(Portfolio $portfolio, array $newGallery): void
    {
        $newPaths = collect($newGallery)->pluck('path')->filter()->all();
        $oldPaths = collect($portfolio->gallery_images ?? [])->pluck('path')->filter()->all();

        foreach (array_diff($oldPaths, $newPaths) as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}
