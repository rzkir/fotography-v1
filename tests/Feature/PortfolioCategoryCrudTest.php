<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioCategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_portfolio_category_index(): void
    {
        $this->get(route('dashboard.portofolio.category.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_portfolio_category_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.portofolio.category.index'))
            ->assertOk()
            ->assertSee('Portfolio Categories');
    }

    public function test_user_can_create_portfolio_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.portofolio.category.store'), [
            'title' => 'Fine Art Portrait',
            'category_id' => 'fine-art-portrait',
        ]);

        $response->assertRedirect(route('dashboard.portofolio.category.index'));
        $this->assertDatabaseHas('portfolio_categories', [
            'user_id' => $user->id,
            'title' => 'Fine Art Portrait',
            'category_id' => 'fine-art-portrait',
        ]);
    }

    public function test_category_id_is_auto_generated_from_title_when_empty(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.portofolio.category.store'), [
            'title' => 'Fashion Editorial',
        ]);

        $this->assertDatabaseHas('portfolio_categories', [
            'user_id' => $user->id,
            'title' => 'Fashion Editorial',
            'category_id' => 'fashion-editorial',
        ]);
    }

    public function test_user_can_update_portfolio_category(): void
    {
        $user = User::factory()->create();
        $category = PortfolioCategory::factory()->for($user)->create([
            'title' => 'Commercial',
            'category_id' => 'commercial',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.portofolio.category.update', $category), [
                'title' => 'Commercial Work',
                'category_id' => 'commercial-work',
            ])
            ->assertRedirect(route('dashboard.portofolio.category.index'));

        $this->assertDatabaseHas('portfolio_categories', [
            'id' => $category->id,
            'title' => 'Commercial Work',
            'category_id' => 'commercial-work',
        ]);
    }

    public function test_user_cannot_delete_category_in_use(): void
    {
        $user = User::factory()->create();
        $category = PortfolioCategory::factory()->for($user)->create([
            'title' => 'Documentary',
            'category_id' => 'documentary',
        ]);

        Portfolio::factory()->for($user)->create([
            'category' => 'Documentary',
        ]);

        $this->actingAs($user)
            ->delete(route('dashboard.portofolio.category.destroy', $category))
            ->assertRedirect(route('dashboard.portofolio.category.index'));

        $this->assertDatabaseHas('portfolio_categories', ['id' => $category->id]);
    }

    public function test_user_can_delete_unused_portfolio_category(): void
    {
        $user = User::factory()->create();
        $category = PortfolioCategory::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('dashboard.portofolio.category.destroy', $category))
            ->assertRedirect(route('dashboard.portofolio.category.index'));

        $this->assertDatabaseMissing('portfolio_categories', ['id' => $category->id]);
    }
}
