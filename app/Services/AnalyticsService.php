<?php

namespace App\Services;

use App\Models\PageView;
use Illuminate\Support\Collection;

class AnalyticsService
{
    /**
     * @return array{
     *     stats: array{
     *         visitors: int,
     *         page_views: int,
     *         bounce_rate: float,
     *         avg_session: string,
     *         visitors_change: float,
     *         page_views_change: float
     *     },
     *     traffic_bars: list<int>,
     *     traffic_labels: list<string>,
     *     highlight_index: int,
     *     highlight_label: string,
     *     countries: list<array{name: string, code: string, visitors: int, percent: float}>,
     *     top_pages: list<array{path: string, title: string, views: int, percent: float}>,
     *     devices: list<array{name: string, icon: string, percent: float, visitors: int}>,
     *     referrers: list<array{name: string, percent: float, visitors: int}>
     * }
     */
    public function overview(int $days = 30): array
    {
        $periodStart = now()->subDays($days)->startOfDay();
        $previousPeriodStart = now()->subDays($days * 2)->startOfDay();
        $previousPeriodEnd = $periodStart->copy()->subSecond();

        $pageViews = PageView::query()
            ->where('viewed_at', '>=', $periodStart)
            ->get();

        $previousPageViews = PageView::query()
            ->whereBetween('viewed_at', [$previousPeriodStart, $previousPeriodEnd])
            ->get();

        $uniqueVisitors = $pageViews->pluck('session_id')->unique()->count();
        $previousUniqueVisitors = $previousPageViews->pluck('session_id')->unique()->count();
        $totalPageViews = $pageViews->count();
        $previousTotalPageViews = $previousPageViews->count();

        $monthly = $this->monthlyVisitors();
        $maxMonthlyVisitors = max($monthly['counts']) ?: 1;

        return [
            'stats' => [
                'visitors' => $uniqueVisitors,
                'page_views' => $totalPageViews,
                'bounce_rate' => $this->bounceRate($pageViews),
                'avg_session' => $this->averageSessionDuration($pageViews),
                'visitors_change' => $this->percentChange($uniqueVisitors, $previousUniqueVisitors),
                'page_views_change' => $this->percentChange($totalPageViews, $previousTotalPageViews),
            ],
            'traffic_bars' => array_map(
                fn (int $count): int => (int) round(($count / $maxMonthlyVisitors) * 100),
                $monthly['counts']
            ),
            'traffic_labels' => $monthly['labels'],
            'highlight_index' => count($monthly['counts']) - 1,
            'highlight_label' => $this->highlightLabel($monthly['counts']),
            'countries' => $this->countries($pageViews, $uniqueVisitors),
            'top_pages' => $this->topPages($pageViews, $totalPageViews),
            'devices' => $this->devices($pageViews, $uniqueVisitors),
            'referrers' => $this->referrers($pageViews, $uniqueVisitors),
        ];
    }

    /**
     * @return array{labels: list<string>, counts: list<int>}
     */
    private function monthlyVisitors(): array
    {
        $labels = [];
        $counts = [];

        for ($month = 0; $month < 12; $month++) {
            $start = now()->subMonths(11 - $month)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $labels[] = $start->format('M');
            $counts[] = (int) PageView::query()
                ->whereBetween('viewed_at', [$start, $end])
                ->distinct()
                ->count('session_id');
        }

        return compact('labels', 'counts');
    }

    private function highlightLabel(array $monthlyCounts): string
    {
        if (count($monthlyCounts) < 2) {
            return '0%';
        }

        $current = $monthlyCounts[count($monthlyCounts) - 1];
        $previous = $monthlyCounts[count($monthlyCounts) - 2];
        $change = $this->percentChange($current, $previous);

        return ($change >= 0 ? '+' : '').number_format($change, 0).'%';
    }

    /**
     * @param  Collection<int, PageView>  $pageViews
     */
    private function bounceRate(Collection $pageViews): float
    {
        $sessionCounts = $pageViews
            ->groupBy('session_id')
            ->map(fn (Collection $views): int => $views->count());

        if ($sessionCounts->isEmpty()) {
            return 0.0;
        }

        $bouncedSessions = $sessionCounts->filter(fn (int $count): bool => $count === 1)->count();

        return round(($bouncedSessions / $sessionCounts->count()) * 100, 1);
    }

    /**
     * @param  Collection<int, PageView>  $pageViews
     */
    private function averageSessionDuration(Collection $pageViews): string
    {
        $durations = $pageViews
            ->groupBy('session_id')
            ->map(function (Collection $views): int {
                if ($views->count() < 2) {
                    return 0;
                }

                $first = $views->min('viewed_at');
                $last = $views->max('viewed_at');

                return $first && $last ? $first->diffInSeconds($last) : 0;
            })
            ->filter(fn (int $seconds): bool => $seconds > 0);

        if ($durations->isEmpty()) {
            return '0m 00s';
        }

        $averageSeconds = (int) round($durations->avg());
        $minutes = intdiv($averageSeconds, 60);
        $seconds = $averageSeconds % 60;

        return sprintf('%dm %02ds', $minutes, $seconds);
    }

    /**
     * @param  Collection<int, PageView>  $pageViews
     * @return list<array{name: string, code: string, visitors: int, percent: float}>
     */
    private function countries(Collection $pageViews, int $uniqueVisitors): array
    {
        if ($uniqueVisitors === 0) {
            return [];
        }

        $countries = $pageViews
            ->groupBy(fn (PageView $view): string => $view->country_name ?? 'Unknown')
            ->map(function (Collection $views, string $countryName): array {
                $sample = $views->first();

                return [
                    'name' => $countryName,
                    'code' => $sample?->country_code ?? '—',
                    'visitors' => $views->pluck('session_id')->unique()->count(),
                ];
            })
            ->sortByDesc('visitors')
            ->values();

        $topCountries = $countries->take(7);
        $remaining = $countries->slice(7);

        if ($remaining->isNotEmpty()) {
            $topCountries->push([
                'name' => 'Others',
                'code' => '—',
                'visitors' => $remaining->sum('visitors'),
            ]);
        }

        return $topCountries
            ->map(function (array $country) use ($uniqueVisitors): array {
                $country['percent'] = round(($country['visitors'] / $uniqueVisitors) * 100, 1);

                return $country;
            })
            ->all();
    }

    /**
     * @param  Collection<int, PageView>  $pageViews
     * @return list<array{path: string, title: string, views: int, percent: float}>
     */
    private function topPages(Collection $pageViews, int $totalPageViews): array
    {
        if ($totalPageViews === 0) {
            return [];
        }

        return $pageViews
            ->groupBy('path')
            ->map(function (Collection $views, string $path): array {
                $sample = $views->first();

                return [
                    'path' => $path,
                    'title' => $sample?->page_title ?? $path,
                    'views' => $views->count(),
                ];
            })
            ->sortByDesc('views')
            ->take(6)
            ->values()
            ->map(function (array $page) use ($totalPageViews): array {
                $page['percent'] = round(($page['views'] / $totalPageViews) * 100, 1);

                return $page;
            })
            ->all();
    }

    /**
     * @param  Collection<int, PageView>  $pageViews
     * @return list<array{name: string, icon: string, percent: float, visitors: int}>
     */
    private function devices(Collection $pageViews, int $uniqueVisitors): array
    {
        if ($uniqueVisitors === 0) {
            return [];
        }

        $deviceIcons = [
            'mobile' => 'lucide:smartphone',
            'desktop' => 'lucide:monitor',
            'tablet' => 'lucide:tablet',
            'unknown' => 'lucide:help-circle',
        ];

        $deviceLabels = [
            'mobile' => 'Mobile',
            'desktop' => 'Desktop',
            'tablet' => 'Tablet',
            'unknown' => 'Unknown',
        ];

        return $pageViews
            ->groupBy('device_type')
            ->map(function (Collection $views, string $deviceType) use ($deviceIcons, $deviceLabels, $uniqueVisitors): array {
                $visitors = $views->pluck('session_id')->unique()->count();

                return [
                    'name' => $deviceLabels[$deviceType] ?? ucfirst($deviceType),
                    'icon' => $deviceIcons[$deviceType] ?? 'lucide:help-circle',
                    'visitors' => $visitors,
                    'percent' => round(($visitors / $uniqueVisitors) * 100, 1),
                ];
            })
            ->sortByDesc('visitors')
            ->values()
            ->all();
    }

    /**
     * @param  Collection<int, PageView>  $pageViews
     * @return list<array{name: string, percent: float, visitors: int}>
     */
    private function referrers(Collection $pageViews, int $uniqueVisitors): array
    {
        if ($uniqueVisitors === 0) {
            return [];
        }

        return $pageViews
            ->groupBy(fn (PageView $view): string => $view->referrer_source ?? 'Direct')
            ->map(function (Collection $views, string $source) use ($uniqueVisitors): array {
                $visitors = $views->pluck('session_id')->unique()->count();

                return [
                    'name' => $source,
                    'visitors' => $visitors,
                    'percent' => round(($visitors / $uniqueVisitors) * 100, 1),
                ];
            })
            ->sortByDesc('visitors')
            ->values()
            ->all();
    }

    private function percentChange(int|float $current, int|float $previous): float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
