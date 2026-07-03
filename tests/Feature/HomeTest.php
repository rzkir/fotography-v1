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

    public function test_home_page_displays_portfolios_from_top_teams_by_number(): void
    {
        $user = User::factory()->create();

        $topTeam = Team::factory()->for($user)->create([
            'name' => 'Ava Sterling',
            'number' => 5,
        ]);
        $lowerTeam = Team::factory()->for($user)->create([
            'name' => 'Low Rank',
            'number' => 1,
        ]);

        $featuredPortfolio = Portfolio::factory()->for($user)->create([
            'title' => 'Midnight Soul',
            'is_published' => true,
        ]);
        $otherPortfolio = Portfolio::factory()->for($user)->create([
            'title' => 'Hidden Draft',
            'is_published' => false,
        ]);

        $featuredPortfolio->teams()->attach($topTeam->id);
        $otherPortfolio->teams()->attach($lowerTeam->id);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Midnight Soul')
            ->assertDontSee('Hidden Draft');
    }
}
