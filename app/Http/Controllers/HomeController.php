<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Testimonial;
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

        return view('home', compact('features', 'testimonials'));
    }
}
