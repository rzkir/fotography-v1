<?php

namespace App\Http\Middleware;

use App\Services\UserStorageService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareDashboardStorage
{
    public function __construct(private UserStorageService $userStorageService) {}

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null) {
            View::share(
                'storageStats',
                $this->userStorageService->forUser($user)
            );
        }

        return $next($request);
    }
}
