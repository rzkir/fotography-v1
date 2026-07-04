<?php

namespace Database\Factories;

use App\Models\PageView;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PageView>
 */
class PageViewFactory extends Factory
{
    protected $model = PageView::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paths = ['/', '/works', '/gallery', '/journal', '/contact'];
        $path = fake()->randomElement($paths);

        return [
            'session_id' => Str::uuid()->toString(),
            'path' => $path,
            'page_title' => 'Page',
            'ip_address' => fake()->ipv4(),
            'country_code' => fake()->randomElement(['ID', 'US', 'SG', 'JP']),
            'country_name' => fake()->country(),
            'device_type' => fake()->randomElement(['mobile', 'desktop', 'tablet']),
            'user_agent' => fake()->userAgent(),
            'referrer' => fake()->optional()->url(),
            'referrer_source' => fake()->randomElement(['Direct', 'Google Search', 'Instagram', 'Others']),
            'viewed_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
