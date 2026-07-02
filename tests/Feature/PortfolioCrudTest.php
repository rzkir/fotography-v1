<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_portfolio_index(): void
    {
        $this->get(route('dashboard.portofolio.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_portfolio_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.portofolio.index'))
            ->assertOk()
            ->assertSee('Portfolio Projects');
    }

    public function test_user_can_create_portfolio_project(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.portofolio.store'), [
            'title' => 'Midnight Soul',
            'subtitle' => 'soul',
            'client' => 'Personal Editorial',
            'year' => 2024,
            'category' => 'Fine Art Portrait',
            'location' => 'Jakarta, ID',
            'hero_caption' => 'Shot 01 · f/2.0 · ISO 200',
            'quote' => 'In the darkness, the truth reveals itself.',
            'content_sections' => [
                ['title' => 'Concept Overview', 'description' => 'Concept text here.'],
                ['title' => 'Creative Direction', 'description' => 'Creative direction here.'],
            ],
            'metrics_shots_taken' => '1.2k+',
            'metrics_final_selects' => '18',
            'metrics_total_hours' => '72h',
            'metrics_team_members' => '6',
            'camera_setup' => 'Leica M11',
            'status' => 'published',
            'is_published' => '1',
            'timeline' => [
                ['title' => 'Week 01: Ideation', 'text' => 'Moodboarding.'],
            ],
            'hero_image' => UploadedFile::fake()->image('hero.jpg'),
            'gallery_images' => [
                UploadedFile::fake()->image('gallery-1.jpg'),
                UploadedFile::fake()->image('gallery-2.jpg'),
            ],
        ]);

        $portfolio = Portfolio::query()->first();

        $this->assertNotNull($portfolio);
        $response->assertRedirect(route('dashboard.portofolio.edit', $portfolio));

        $this->assertDatabaseHas('portfolios', [
            'user_id' => $user->id,
            'title' => 'Midnight Soul',
            'slug' => 'midnight-soul',
            'status' => 'published',
        ]);

        Storage::disk('public')->assertExists($portfolio->hero_image);
        $this->assertCount(2, $portfolio->gallery_images ?? []);
    }

    public function test_user_can_update_own_portfolio(): void
    {
        $user = User::factory()->create();
        $portfolio = Portfolio::factory()->for($user)->create([
            'title' => 'Old Title',
            'slug' => 'old-title',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.portofolio.update', $portfolio), [
                'title' => 'Updated Title',
                'year' => 2025,
                'status' => 'draft',
                'is_published' => '0',
            ])
            ->assertRedirect(route('dashboard.portofolio.edit', $portfolio));

        $this->assertDatabaseHas('portfolios', [
            'id' => $portfolio->id,
            'title' => 'Updated Title',
            'slug' => 'updated-title',
            'status' => 'draft',
        ]);
    }

    public function test_user_cannot_update_another_users_portfolio(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $portfolio = Portfolio::factory()->for($owner)->create();

        $this->actingAs($other)
            ->put(route('dashboard.portofolio.update', $portfolio), [
                'title' => 'Hacked',
                'year' => 2025,
                'status' => 'draft',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_portfolio(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $portfolio = Portfolio::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('dashboard.portofolio.destroy', $portfolio))
            ->assertRedirect(route('dashboard.portofolio.index'));

        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }
}
