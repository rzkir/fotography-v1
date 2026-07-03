<?php

namespace Database\Seeders;

use App\Models\PortfolioCategory;

class PortfolioCategorySeeder extends UserScopedSeeder
{
    /**
     * @var list<array{title: string, category_id: string}>
     */
    private const CATEGORIES = [
        ['title' => 'Fine Art Portrait', 'category_id' => 'fine-art-portrait'],
        ['title' => 'Fashion Editorial', 'category_id' => 'fashion-editorial'],
        ['title' => 'Commercial Advertising', 'category_id' => 'commercial-advertising'],
        ['title' => 'Wedding & Events', 'category_id' => 'wedding-events'],
        ['title' => 'Documentary', 'category_id' => 'documentary'],
        ['title' => 'Product Photography', 'category_id' => 'product-photography'],
        ['title' => 'Architecture & Interior', 'category_id' => 'architecture-interior'],
        ['title' => 'Music & Performance', 'category_id' => 'music-performance'],
    ];

    public function run(): void
    {
        foreach ($this->users() as $user) {
            foreach (self::CATEGORIES as $category) {
                PortfolioCategory::query()->updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'category_id' => $category['category_id'],
                    ],
                    [
                        'title' => $category['title'],
                    ]
                );
            }
        }
    }
}
