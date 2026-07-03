<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\Portfolio;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_features(): void
    {
        $user = User::factory()->create();
        Feature::factory()->for($user)->create([
            'number' => '450+',
            'title' => 'Happy Clients',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('450+')
            ->assertSee('Happy Clients');
    }

    public function test_home_page_hides_stats_section_when_no_features(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Happy Clients');
    }

    public function test_home_page_displays_testimonials(): void
    {
        $user = User::factory()->create();
        Testimonial::factory()->for($user)->create([
            'message' => 'The level of detail was unlike anything we experienced.',
            'name' => 'Marcello Verdi',
            'jobs' => 'Creative Director',
            'company' => 'Vogue IT',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Marcello Verdi')
            ->assertSee('Creative Director, Vogue IT')
            ->assertSee('The level of detail was unlike anything we experienced.');
    }

    public function test_home_page_hides_team_section_when_no_teams(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('The Collective')
            ->assertDontSee('Studio Team');
    }

    public function test_home_page_displays_teams_ordered_by_number(): void
    {
        $user = User::factory()->create();

        Team::factory()->for($user)->create([
            'name' => 'Low Rank',
            'job' => 'Assistant',
            'number' => 1,
        ]);
        Team::factory()->for($user)->create([
            'name' => 'Ava Sterling',
            'job' => 'Lead Photographer',
            'number' => 5,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder(['Ava Sterling', 'Low Rank'])
            ->assertSee('Lead Photographer')
            ->assertDontSee('Portfolio Showcase');
    }

    public function test_home_page_team_links_to_featured_portfolio_when_available(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->for($user)->create([
            'name' => 'Ava Sterling',
            'number' => 3,
        ]);

        $portfolio = Portfolio::factory()->for($user)->create([
            'title' => 'Midnight Soul',
            'slug' => 'midnight-soul',
            'is_published' => true,
        ]);

        $portfolio->teams()->attach($team->id);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Ava Sterling')
            ->assertSee(route('works.show', $portfolio), false);
    }

    public function test_home_page_does_not_display_duplicate_teams_for_same_portfolio(): void
    {
        $user = User::factory()->create();

        $topTeam = Team::factory()->for($user)->create([
            'name' => 'Ava Sterling',
            'job' => 'Lead Photographer',
            'number' => 5,
        ]);
        $duplicateTeam = Team::factory()->for($user)->create([
            'name' => 'Evan Wright',
            'job' => 'Stylist',
            'number' => 4,
        ]);

        $portfolio = Portfolio::factory()->for($user)->create([
            'title' => 'Midnight Soul',
            'is_published' => true,
        ]);

        $portfolio->teams()->attach([$topTeam->id, $duplicateTeam->id]);

        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertSee('Ava Sterling')
            ->assertDontSee('Evan Wright')
            ->assertSee(route('works.show', $portfolio), false);

        $this->assertSame(1, substr_count($response->getContent(), route('works.show', $portfolio)));
    }
}
