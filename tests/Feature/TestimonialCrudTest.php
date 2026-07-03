<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_testimonial_index(): void
    {
        $this->get(route('dashboard.testimonials.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_testimonial_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.testimonials.index'))
            ->assertOk()
            ->assertSee('Client Success');
    }

    public function test_user_can_create_testimonial(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.testimonials.store'), [
            'message' => 'Erik captures light in a way that feels cinematic and timeless.',
            'name' => 'Claire Beaumont',
            'jobs' => 'Creative Director',
            'company' => 'Vogue France',
        ]);

        $response->assertRedirect(route('dashboard.testimonials.index'));

        $this->assertDatabaseHas('testimonials', [
            'user_id' => $user->id,
            'name' => 'Claire Beaumont',
            'jobs' => 'Creative Director',
            'company' => 'Vogue France',
        ]);
    }

    public function test_user_can_update_own_testimonial(): void
    {
        $user = User::factory()->create();
        $testimonial = Testimonial::factory()->for($user)->create([
            'name' => 'Claire Beaumont',
            'jobs' => 'Creative Director',
            'company' => 'Vogue France',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.testimonials.update', $testimonial), [
                'message' => 'Updated message from a premium fashion client.',
                'name' => 'Claire Beaumont',
                'jobs' => 'Editorial Director',
                'company' => 'Vogue France',
            ])
            ->assertRedirect(route('dashboard.testimonials.index'));

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'jobs' => 'Editorial Director',
            'message' => 'Updated message from a premium fashion client.',
        ]);
    }

    public function test_user_cannot_update_another_users_testimonial(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $testimonial = Testimonial::factory()->for($owner)->create();

        $this->actingAs($other)
            ->put(route('dashboard.testimonials.update', $testimonial), [
                'message' => 'Hacked message',
                'name' => 'Intruder',
                'jobs' => 'Bad Actor',
                'company' => 'Unknown',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_testimonial(): void
    {
        $user = User::factory()->create();
        $testimonial = Testimonial::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('dashboard.testimonials.destroy', $testimonial))
            ->assertRedirect(route('dashboard.testimonials.index'));

        $this->assertDatabaseMissing('testimonials', [
            'id' => $testimonial->id,
        ]);
    }

    public function test_user_cannot_delete_another_users_testimonial(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $testimonial = Testimonial::factory()->for($owner)->create();

        $this->actingAs($other)
            ->delete(route('dashboard.testimonials.destroy', $testimonial))
            ->assertForbidden();
    }
}
