<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_feature_index(): void
    {
        $this->get(route('dashboard.features.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_feature_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.features.index'))
            ->assertOk()
            ->assertSee('Studio Highlights');
    }

    public function test_user_can_create_feature(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.features.store'), [
            'number' => '4.92',
            'title' => 'Average Rating',
        ]);

        $response->assertRedirect(route('dashboard.features.index'));

        $this->assertDatabaseHas('features', [
            'user_id' => $user->id,
            'number' => '4.92',
            'title' => 'Average Rating',
        ]);
    }

    public function test_user_can_update_own_feature(): void
    {
        $user = User::factory()->create();
        $feature = Feature::factory()->for($user)->create([
            'number' => '99%',
            'title' => 'Success Rate',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.features.update', $feature), [
                'number' => '100%',
                'title' => 'Client Satisfaction',
            ])
            ->assertRedirect(route('dashboard.features.index'));

        $this->assertDatabaseHas('features', [
            'id' => $feature->id,
            'number' => '100%',
            'title' => 'Client Satisfaction',
        ]);
    }

    public function test_user_cannot_update_another_users_feature(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $feature = Feature::factory()->for($owner)->create();

        $this->actingAs($other)
            ->put(route('dashboard.features.update', $feature), [
                'number' => '0',
                'title' => 'Hacked',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_feature(): void
    {
        $user = User::factory()->create();
        $feature = Feature::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('dashboard.features.destroy', $feature))
            ->assertRedirect(route('dashboard.features.index'));

        $this->assertDatabaseMissing('features', [
            'id' => $feature->id,
        ]);
    }

    public function test_user_cannot_delete_another_users_feature(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $feature = Feature::factory()->for($owner)->create();

        $this->actingAs($other)
            ->delete(route('dashboard.features.destroy', $feature))
            ->assertForbidden();
    }
}
