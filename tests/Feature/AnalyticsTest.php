<?php

namespace Tests\Feature;

use App\Models\PageView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_visit_is_tracked(): void
    {
        $this->get(route('home'))
            ->assertOk();

        $this->assertDatabaseCount('page_views', 1);

        $pageView = PageView::query()->first();

        $this->assertSame('/', $pageView->path);
        $this->assertSame('Home', $pageView->page_title);
        $this->assertSame('ID', $pageView->country_code);
        $this->assertSame('Indonesia', $pageView->country_name);
        $this->assertSame('Direct', $pageView->referrer_source);
    }

    public function test_dashboard_page_does_not_create_page_view(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.analytics.index'))
            ->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public function test_analytics_page_shows_real_tracked_data(): void
    {
        $user = User::factory()->create();

        PageView::factory()->create([
            'session_id' => 'session-a',
            'path' => '/',
            'page_title' => 'Home',
            'country_code' => 'ID',
            'country_name' => 'Indonesia',
            'device_type' => 'desktop',
            'referrer_source' => 'Direct',
            'viewed_at' => now(),
        ]);

        PageView::factory()->create([
            'session_id' => 'session-a',
            'path' => '/works',
            'page_title' => 'Selected Works',
            'country_code' => 'ID',
            'country_name' => 'Indonesia',
            'device_type' => 'desktop',
            'referrer_source' => 'Google Search',
            'viewed_at' => now(),
        ]);

        PageView::factory()->create([
            'session_id' => 'session-b',
            'path' => '/gallery',
            'page_title' => 'Gallery',
            'country_code' => 'US',
            'country_name' => 'United States',
            'device_type' => 'mobile',
            'referrer_source' => 'Instagram',
            'viewed_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('dashboard.analytics.index'))
            ->assertOk()
            ->assertSee('2') // unique visitors
            ->assertSee('3') // page views
            ->assertSee('Indonesia')
            ->assertSee('United States')
            ->assertSee('Home')
            ->assertSee('Gallery');
    }

    public function test_bot_requests_are_not_tracked(): void
    {
        $this->withHeaders([
            'User-Agent' => 'Googlebot/2.1 (+http://www.google.com/bot.html)',
        ])->get(route('home'))
            ->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }
}
