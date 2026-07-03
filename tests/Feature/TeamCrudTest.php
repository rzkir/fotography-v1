<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeamCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_team_index(): void
    {
        $this->get(route('dashboard.teams.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_team_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.teams.index'))
            ->assertOk()
            ->assertSee('Studio Team');
    }

    public function test_user_can_create_team_member(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.teams.store'), [
            'name' => 'Evan W.',
            'job' => 'Lead Photographer',
            'picture' => UploadedFile::fake()->image('evan.jpg'),
            'social_media' => [
                [
                    'type' => 'instagram',
                    'label' => '@evanw',
                    'link' => 'https://instagram.com/evanw',
                ],
                [
                    'type' => 'linkedin',
                    'label' => 'Evan W.',
                    'link' => 'https://linkedin.com/in/evanw',
                ],
            ],
        ]);

        $team = Team::query()->first();

        $response->assertRedirect(route('dashboard.teams.edit', $team));

        $this->assertDatabaseHas('teams', [
            'user_id' => $user->id,
            'name' => 'Evan W.',
            'job' => 'Lead Photographer',
        ]);

        $this->assertNotNull($team->picture);
        $this->assertCount(2, $team->social_media);
        $this->assertSame('instagram', $team->social_media[0]['type']);
    }

    public function test_user_can_update_own_team_member(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->for($user)->create([
            'name' => 'Old Name',
            'job' => 'Old Job',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.teams.update', $team), [
                'name' => 'Marco Rossi',
                'job' => 'Senior Stylist',
                'social_media' => [
                    [
                        'type' => 'tiktok',
                        'label' => '@marco',
                        'link' => 'https://tiktok.com/@marco',
                    ],
                ],
            ])
            ->assertRedirect(route('dashboard.teams.edit', $team));

        $team->refresh();

        $this->assertSame('Marco Rossi', $team->name);
        $this->assertSame('Senior Stylist', $team->job);
        $this->assertSame('tiktok', $team->social_media[0]['type']);
    }

    public function test_user_cannot_update_another_users_team_member(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $team = Team::factory()->for($owner)->create();

        $this->actingAs($intruder)
            ->put(route('dashboard.teams.update', $team), [
                'name' => 'Hacked',
                'job' => 'Hacker',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_team_member(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $team = Team::factory()->for($user)->create([
            'picture' => 'teams/pictures/test.jpg',
        ]);

        Storage::disk('public')->put('teams/pictures/test.jpg', 'content');

        $this->actingAs($user)
            ->delete(route('dashboard.teams.destroy', $team))
            ->assertRedirect(route('dashboard.teams.index'));

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
        Storage::disk('public')->assertMissing('teams/pictures/test.jpg');
    }

    public function test_team_number_increments_when_assigned_to_portfolio(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $team = Team::factory()->for($user)->create(['number' => 0]);

        $this->actingAs($user)->post(route('dashboard.portofolio.store'), [
            'title' => 'Midnight Soul',
            'year' => 2024,
            'status' => 'draft',
            'team_members' => [
                ['team_id' => $team->id, 'description' => 'Lead shoot'],
            ],
        ]);

        $this->assertSame(1, $team->fresh()->number);
    }
}