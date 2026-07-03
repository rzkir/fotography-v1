<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'job' => fake()->jobTitle(),
            'biography' => fake()->paragraph(),
            'number' => 0,
            'picture' => null,
            'social_media' => [
                [
                    'type' => 'instagram',
                    'label' => '@'.fake()->userName(),
                    'link' => 'https://instagram.com/'.fake()->userName(),
                ],
            ],
        ];
    }
}
