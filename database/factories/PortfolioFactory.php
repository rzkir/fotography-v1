<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Portfolio>
 */
class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    public function definition(): array
    {
        $title = fake()->words(2, true);

        return [
            'user_id' => User::factory(),
            'title' => Str::title($title),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'subtitle' => fake()->optional()->word(),
            'client' => fake()->company(),
            'year' => (int) fake()->year(),
            'category' => fake()->randomElement(['Fine Art Portrait', 'Fashion Editorial', 'Commercial', 'Documentary']),
            'location' => fake()->city().', ID',
            'hero_caption' => 'Shot 01 · f/2.0 · ISO 200',
            'quote' => fake()->sentence(12),
            'content_sections' => [
                ['title' => 'Concept Overview', 'description' => fake()->paragraph()],
                ['title' => 'Creative Direction', 'description' => fake()->paragraph()],
            ],
            'gallery_images' => [
                ['url' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&q=80&w=800', 'caption' => 'Shot 02', 'alt' => 'Gallery Image'],
            ],
            'metrics' => [
                'shots_taken' => '1.2k+',
                'final_selects' => '18',
                'total_hours' => '72h',
                'team_members' => '6',
            ],
            'technical_specs' => [
                'camera_setup' => 'Leica M11 / Summilux 50mm f/1.4',
                'camera_settings' => 'ISO 100-400 · 1/125s - 1/250s',
                'lighting_array' => 'Profoto B10X + 3\' Deep Octa',
                'lighting_notes' => 'Single source with negative fill for extreme contrast.',
                'post_processing' => [
                    ['title' => 'Curation & RAW', 'text' => 'Initial selection and RAW development.'],
                    ['title' => 'Color Grading', 'text' => 'Custom LUTs · Frequency Separation'],
                ],
                'retouching_notes' => fake()->sentence(),
            ],
            'timeline' => [
                ['title' => 'Week 01: Ideation', 'text' => 'Moodboarding and location scouting.'],
                ['title' => 'Week 02: Pre-Production', 'text' => 'Casting and wardrobe selection.'],
            ],
            'contributors' => [
                [
                    'name' => 'Evan W.',
                    'job' => 'Lead Photographer',
                    'description' => fake()->sentence(),
                    'social_media' => '@evanw',
                    'image' => 'https://i.pravatar.cc/300?u=a',
                ],
            ],
            'testimonial' => [
                'quote' => fake()->paragraph(),
                'author' => 'Test User',
            ],
            'status' => fake()->randomElement(['draft', 'published']),
            'is_published' => fake()->boolean(70),
        ];
    }
}
