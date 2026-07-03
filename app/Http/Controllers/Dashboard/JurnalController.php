<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJurnalRequest;
use App\Http\Requests\UpdateJurnalRequest;
use App\Models\Jurnal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JurnalController extends Controller
{
    public function index(): View
    {
        $jurnals = auth()->user()
            ->jurnals()
            ->with('jurnalCategory')
            ->latest()
            ->get();

        return view('dashboard.jurnal.index', compact('jurnals'));
    }

    public function create(): View
    {
        $categories = auth()->user()->jurnalCategories()->orderBy('title')->get();

        return view('dashboard.jurnal.create', compact('categories'));
    }

    public function store(StoreJurnalRequest $request): RedirectResponse
    {
        $jurnal = auth()->user()->jurnals()->create(
            $this->buildJurnalAttributes($request)
        );

        return redirect()
            ->route('dashboard.jurnal.edit', $jurnal)
            ->with('success', 'Journal article created successfully.');
    }

    public function edit(Jurnal $jurnal): View
    {
        $this->authorizeJurnal($jurnal);

        $categories = auth()->user()->jurnalCategories()->orderBy('title')->get();

        return view('dashboard.jurnal.edit', compact('jurnal', 'categories'));
    }

    public function update(UpdateJurnalRequest $request, Jurnal $jurnal): RedirectResponse
    {
        $this->authorizeJurnal($jurnal);

        $jurnal->update(
            $this->buildJurnalAttributes($request, $jurnal)
        );

        return redirect()
            ->route('dashboard.jurnal.edit', $jurnal)
            ->with('success', 'Journal article updated successfully.');
    }

    public function destroy(Jurnal $jurnal): RedirectResponse
    {
        $this->authorizeJurnal($jurnal);

        $this->deleteJurnalFiles($jurnal);
        $jurnal->delete();

        return redirect()
            ->route('dashboard.jurnal.index')
            ->with('success', 'Journal article deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function buildJurnalAttributes(Request $request, ?Jurnal $jurnal = null): array
    {
        $attributes = [
            'title' => $request->string('title')->toString(),
            'slug' => $this->resolveSlug($request, $jurnal),
            'category_id' => $request->input('category_id'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($jurnal?->thumbnail) {
                Storage::disk('public')->delete($jurnal->thumbnail);
            }

            $attributes['thumbnail'] = $request->file('thumbnail')->store('jurnals/thumbnails', 'public');
        }

        return $attributes;
    }

    private function authorizeJurnal(Jurnal $jurnal): void
    {
        abort_if($jurnal->user_id !== auth()->id(), 403);
    }

    private function resolveSlug(Request $request, ?Jurnal $jurnal = null): string
    {
        $title = $request->string('title')->toString();
        $slugBase = Str::slug($request->filled('slug') ? $request->string('slug')->toString() : $title);

        if ($slugBase === '') {
            $slugBase = Str::slug($title) ?: 'article';
        }

        $slug = $slugBase;
        $counter = 1;

        while (Jurnal::query()
            ->where('slug', $slug)
            ->when($jurnal, fn ($query) => $query->where('id', '!=', $jurnal->id))
            ->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function deleteJurnalFiles(Jurnal $jurnal): void
    {
        if ($jurnal->thumbnail) {
            Storage::disk('public')->delete($jurnal->thumbnail);
        }
    }
}
