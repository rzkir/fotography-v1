<?php

namespace Database\Factories;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'message' => fake()->paragraphs(2, true),
            'name' => fake()->name(),
            'jobs' => fake()->jobTitle(),
            'company' => fake()->company(),
        ];
    }
}
