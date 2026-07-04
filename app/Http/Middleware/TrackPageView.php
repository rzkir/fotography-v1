<?php

namespace App\Http\Middleware;

use App\Services\PageViewTracker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function __construct(private PageViewTracker $pageViewTracker) {}

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->isSuccessful()) {
            $this->pageViewTracker->track($request);
        }

        return $response;
    }
}
