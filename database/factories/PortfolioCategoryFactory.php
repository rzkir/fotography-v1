<?php

namespace Database\Factories;

use App\Models\PortfolioCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PortfolioCategory>
 */
class PortfolioCategoryFactory extends Factory
{
    protected $model = PortfolioCategory::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Fine Art Portrait',
            'Fashion Editorial',
            'Commercial',
            'Documentary',
        ]);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'category_id' => Str::slug($title),
        ];
    }
}
