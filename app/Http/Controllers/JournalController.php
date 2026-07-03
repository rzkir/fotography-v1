<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\JurnalCategory;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(): View
    {
        $jurnals = Jurnal::query()
            ->where('status', 'published')
            ->with(['jurnalCategory', 'user'])
            ->latest()
            ->get();

        $categoryIds = $jurnals->pluck('category_id')->filter()->unique();
        $categories = JurnalCategory::query()
            ->whereIn('category_id', $categoryIds)
            ->orderBy('title')
            ->get()
            ->map(function (JurnalCategory $category) use ($jurnals) {
                $category->published_count = $jurnals
                    ->where('category_id', $category->category_id)
                    ->count();

                return $category;
            });

        $totalArticles = $jurnals->count();

        return view('journal.index', compact('jurnals', 'categories', 'totalArticles'));
    }

    public function show(Jurnal $jurnal): View
    {
        abort_unless($jurnal->status === 'published', 404);

        $jurnal->load('jurnalCategory', 'user');

        $relatedJurnals = Jurnal::query()
            ->where('status', 'published')
            ->whereKeyNot($jurnal->id)
            ->when(
                filled($jurnal->category_id),
                fn ($query) => $query->where('category_id', $jurnal->category_id)
            )
            ->with('jurnalCategory')
            ->latest()
            ->limit(3)
            ->get();

        if ($relatedJurnals->count() < 3) {
            $relatedJurnals = Jurnal::query()
                ->where('status', 'published')
                ->whereKeyNot($jurnal->id)
                ->whereNotIn('id', $relatedJurnals->pluck('id'))
                ->with('jurnalCategory')
                ->latest()
                ->limit(3 - $relatedJurnals->count())
                ->get()
                ->merge($relatedJurnals);
        }

        return view('journal.details', compact('jurnal', 'relatedJurnals'));
    }
}
