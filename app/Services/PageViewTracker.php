<?php

namespace App\Services;

use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PageViewTracker
{
    public function track(Request $request): void
    {
        if (! $this->shouldTrack($request)) {
            return;
        }

        $ipAddress = $request->ip() ?? '0.0.0.0';
        $country = $this->resolveCountry($ipAddress);
        $referrer = $request->headers->get('referer');
        $userAgent = $request->userAgent();

        PageView::query()->create([
            'session_id' => $request->session()->getId(),
            'path' => '/'.ltrim($request->path(), '/'),
            'page_title' => $this->pageTitle($request->path()),
            'ip_address' => $ipAddress,
            'country_code' => $country['code'],
            'country_name' => $country['name'],
            'device_type' => $this->detectDevice($userAgent),
            'user_agent' => $userAgent,
            'referrer' => $referrer,
            'referrer_source' => $this->resolveReferrerSource($referrer),
            'viewed_at' => now(),
        ]);
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->expectsJson()) {
            return false;
        }

        if ($request->user() !== null) {
            return false;
        }

        if ($this->isBot($request->userAgent())) {
            return false;
        }

        return true;
    }

    private function isBot(?string $userAgent): bool
    {
        if (! filled($userAgent)) {
            return false;
        }

        return (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview/i', $userAgent);
    }

    /**
     * @return array{code: ?string, name: ?string}
     */
    private function resolveCountry(string $ipAddress): array
    {
        if ($this->isLocalIp($ipAddress)) {
            return ['code' => 'LO', 'name' => 'Local Network'];
        }

        if (app()->environment('testing')) {
            return ['code' => 'ID', 'name' => 'Indonesia'];
        }

        return Cache::remember(
            'analytics:geo:'.md5($ipAddress),
            now()->addDays(7),
            function () use ($ipAddress): array {
                try {
                    $response = Http::timeout(2)->get("http://ip-api.com/json/{$ipAddress}", [
                        'fields' => 'status,country,countryCode',
                    ]);

                    if ($response->successful() && $response->json('status') === 'success') {
                        return [
                            'code' => $response->json('countryCode'),
                            'name' => $response->json('country'),
                        ];
                    }
                } catch (\Throwable) {
                    //
                }

                return ['code' => null, 'name' => 'Unknown'];
            }
        );
    }

    private function isLocalIp(string $ipAddress): bool
    {
        return in_array($ipAddress, ['127.0.0.1', '::1', '0.0.0.0'], true)
            || str_starts_with($ipAddress, '192.168.')
            || str_starts_with($ipAddress, '10.');
    }

    private function detectDevice(?string $userAgent): string
    {
        if (! filled($userAgent)) {
            return 'unknown';
        }

        if (preg_match('/tablet|ipad|playbook|silk/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/mobile|iphone|ipod|android|blackberry|opera mini|windows phone/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    private function resolveReferrerSource(?string $referrer): string
    {
        if (! filled($referrer)) {
            return 'Direct';
        }

        $host = Str::lower((string) parse_url($referrer, PHP_URL_HOST));

        if ($host === '') {
            return 'Direct';
        }

        return match (true) {
            str_contains($host, 'google.') => 'Google Search',
            str_contains($host, 'instagram.') => 'Instagram',
            str_contains($host, 'facebook.') => 'Facebook',
            str_contains($host, 'behance.') => 'Behance',
            str_contains($host, 'pinterest.') => 'Pinterest',
            str_contains($host, 'twitter.') || str_contains($host, 'x.com') => 'X / Twitter',
            default => 'Others',
        };
    }

    private function pageTitle(string $path): string
    {
        $normalizedPath = '/'.ltrim($path, '/');

        return match ($normalizedPath) {
            '/' => 'Home',
            '/works' => 'Selected Works',
            '/gallery' => 'Gallery',
            '/journal' => 'Journal',
            '/contact' => 'Contact',
            '/privacy-security' => 'Privacy & Security',
            '/terms-of-service' => 'Terms of Service',
            '/copyright' => 'Copyright',
            default => match (true) {
                str_starts_with($normalizedPath, '/works/') => 'Portfolio',
                str_starts_with($normalizedPath, '/journal/') => 'Journal Article',
                default => ucwords(str_replace(['-', '/'], [' ', ' '], trim($normalizedPath, '/'))),
            },
        };
    }
}
