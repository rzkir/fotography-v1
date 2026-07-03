<?php

namespace Database\Seeders;

use App\Models\JurnalCategory;

class JurnalCategorySeeder extends UserScopedSeeder
{
    /**
     * @var list<array{title: string, category_id: string}>
     */
    private const CATEGORIES = [
        ['title' => 'Craft & Technique', 'category_id' => 'craft-technique'],
        ['title' => 'Hardware / Gear', 'category_id' => 'hardware-gear'],
        ['title' => 'Theory / Color', 'category_id' => 'theory-color'],
        ['title' => 'Lifestyle / Travel', 'category_id' => 'lifestyle-travel'],
        ['title' => 'Behind the Scenes', 'category_id' => 'behind-the-scenes'],
        ['title' => 'Post-Production', 'category_id' => 'post-production'],
        ['title' => 'Studio Notes', 'category_id' => 'studio-notes'],
        ['title' => 'Client Stories', 'category_id' => 'client-stories'],
    ];

    public function run(): void
    {
        foreach ($this->users() as $user) {
            foreach (self::CATEGORIES as $category) {
                JurnalCategory::query()->updateOrCreate(
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
