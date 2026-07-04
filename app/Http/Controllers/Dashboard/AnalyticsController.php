<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __construct(private AnalyticsService $analyticsService) {}

    public function index(): View
    {
        $analytics = $this->analyticsService->overview();

        return view('dashboard.analytics', $analytics);
    }
}
