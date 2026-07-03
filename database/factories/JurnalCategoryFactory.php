<?php

namespace Database\Factories;

use App\Models\JurnalCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JurnalCategory>
 */
class JurnalCategoryFactory extends Factory
{
    protected $model = JurnalCategory::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Craft & Technique',
            'Hardware / Gear',
            'Theory / Color',
            'Lifestyle / Travel',
        ]);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'category_id' => Str::slug($title),
        ];
    }
}
