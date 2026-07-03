<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = auth()->user()
            ->testimonials()
            ->latest()
            ->get();

        $stats = [
            'total' => $testimonials->count(),
            'companies' => $testimonials->pluck('company')->filter()->unique()->count(),
            'roles' => $testimonials->pluck('jobs')->filter()->unique()->count(),
            'latest' => $testimonials->first()?->updated_at,
        ];

        return view('dashboard.testimonials', compact('testimonials', 'stats'));
    }

    public function store(StoreTestimonialRequest $request): RedirectResponse
    {
        auth()->user()->testimonials()->create($request->validated());

        return redirect()
            ->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $this->authorizeTestimonial($testimonial);

        $testimonial->update($request->validated());

        return redirect()
            ->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->authorizeTestimonial($testimonial);

        $testimonial->delete();

        return redirect()
            ->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    private function authorizeTestimonial(Testimonial $testimonial): void
    {
        abort_if($testimonial->user_id !== auth()->id(), 403);
    }
}
