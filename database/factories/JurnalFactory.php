<?php

namespace Database\Factories;

use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Jurnal>
 */
class JurnalFactory extends Factory
{
    protected $model = Jurnal::class;

    public function definition(): array
    {
        $title = fake()->words(3, true);

        return [
            'user_id' => User::factory(),
            'title' => Str::title($title),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'category_id' => null,
            'description' => fake()->sentence(16),
            'content' => fake()->paragraphs(4, true),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }
}
