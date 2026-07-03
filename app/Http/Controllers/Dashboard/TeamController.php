<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = auth()->user()
            ->teams()
            ->latest()
            ->get();

        return view('dashboard.teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('dashboard.teams.create');
    }

    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $team = auth()->user()->teams()->create(
            $this->buildTeamAttributes($request)
        );

        return redirect()
            ->route('dashboard.teams.edit', $team)
            ->with('success', 'Team member created successfully.');
    }

    public function edit(Team $team): View
    {
        $this->authorizeTeam($team);

        return view('dashboard.teams.edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $this->authorizeTeam($team);

        $team->update(
            $this->buildTeamAttributes($request, $team)
        );

        return redirect()
            ->route('dashboard.teams.edit', $team)
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(Team $team): RedirectResponse
    {
        $this->authorizeTeam($team);

        if ($team->picture) {
            Storage::disk('public')->delete($team->picture);
        }

        $team->delete();

        return redirect()
            ->route('dashboard.teams.index')
            ->with('success', 'Team member deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function buildTeamAttributes(StoreTeamRequest|UpdateTeamRequest $request, ?Team $team = null): array
    {
        $attributes = [
            'name' => $request->string('name')->toString(),
            'job' => $request->string('job')->toString(),
            'biography' => $request->filled('biography') ? $request->string('biography')->toString() : null,
            'social_media' => $this->buildSocialMedia($request),
        ];

        if ($request->hasFile('picture')) {
            if ($team?->picture) {
                Storage::disk('public')->delete($team->picture);
            }

            $attributes['picture'] = $request->file('picture')->store('teams/pictures', 'public');
        }

        return $attributes;
    }

    /**
     * @return list<array{type: string, label: string|null, link: string}>
     */
    private function buildSocialMedia(StoreTeamRequest|UpdateTeamRequest $request): array
    {
        return collect($request->input('social_media', []))
            ->filter(fn (array $item): bool => filled($item['type'] ?? null) && filled($item['link'] ?? null))
            ->map(fn (array $item): array => [
                'type' => $item['type'],
                'label' => filled($item['label'] ?? null) ? $item['label'] : null,
                'link' => $item['link'],
            ])
            ->values()
            ->all();
    }

    private function authorizeTeam(Team $team): void
    {
        abort_if($team->user_id !== auth()->id(), 403);
    }
}
