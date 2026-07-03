<?php

namespace Database\Factories;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feature>
 */
class FeatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'number' => fake()->randomElement(['4.92', '99%', '150+', '12', '4.5M+']),
            'title' => fake()->randomElement([
                'Average Rating',
                'Success Rate',
                'Verified Clients',
                'Global Magazines',
                'Impressions',
            ]),
        ];
    }
}
