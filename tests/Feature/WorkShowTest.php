<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_published_portfolio_details(): void
    {
        $user = User::factory()->create();
        $portfolio = Portfolio::factory()->for($user)->create([
            'title' => 'Midnight Soul',
            'subtitle' => 'soul',
            'slug' => 'midnight-soul',
            'is_published' => true,
        ]);

        $this->get(route('works.show', $portfolio))
            ->assertOk()
            ->assertSee('Midnight')
            ->assertSee('soul')
            ->assertSee('Back to Selected Works');
    }

    public function test_guest_cannot_view_unpublished_portfolio_details(): void
    {
        $user = User::factory()->create();
        $portfolio = Portfolio::factory()->for($user)->create([
            'slug' => 'draft-project',
            'is_published' => false,
        ]);

        $this->get(route('works.show', $portfolio))
            ->assertNotFound();
    }

    public function test_guest_can_view_works_index_with_published_portfolios(): void
    {
        $user = User::factory()->create();
        Portfolio::factory()->for($user)->create([
            'title' => 'Aura of Silence',
            'slug' => 'aura-of-silence',
            'is_published' => true,
        ]);
        Portfolio::factory()->for($user)->create([
            'is_published' => false,
        ]);

        $this->get(route('works.index'))
            ->assertOk()
            ->assertSee('Aura of Silence')
            ->assertSee('Total Projects')
            ->assertDontSee('draft-project');
    }
}
