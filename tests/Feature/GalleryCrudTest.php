<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_gallery_index(): void
    {
        $this->get(route('dashboard.gallery.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_gallery_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.gallery.index'))
            ->assertOk()
            ->assertSee('Cloud Assets');
    }

    public function test_user_can_create_gallery_item(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.gallery.store'), [
            'title' => 'Golden Hour Portrait',
            'image' => UploadedFile::fake()->image('golden-hour.jpg'),
        ]);

        $response->assertRedirect(route('dashboard.gallery.index'));

        $gallery = Gallery::query()->first();

        $this->assertDatabaseHas('galleries', [
            'user_id' => $user->id,
            'title' => 'Golden Hour Portrait',
        ]);

        $this->assertNotNull($gallery->image);
        Storage::disk('public')->assertExists($gallery->image);
    }

    public function test_user_can_update_own_gallery_item(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $gallery = Gallery::factory()->for($user)->create([
            'title' => 'Old Title',
            'image' => 'galleries/images/old.jpg',
        ]);

        Storage::disk('public')->put('galleries/images/old.jpg', 'content');

        $this->actingAs($user)
            ->put(route('dashboard.gallery.update', $gallery), [
                'title' => 'Updated Title',
            ])
            ->assertRedirect(route('dashboard.gallery.index'));

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'title' => 'Updated Title',
            'image' => 'galleries/images/old.jpg',
        ]);
    }

    public function test_user_can_update_gallery_item_with_new_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $gallery = Gallery::factory()->for($user)->create([
            'image' => 'galleries/images/old.jpg',
        ]);

        Storage::disk('public')->put('galleries/images/old.jpg', 'content');

        $this->actingAs($user)
            ->put(route('dashboard.gallery.update', $gallery), [
                'title' => $gallery->title,
                'image' => UploadedFile::fake()->image('new-image.jpg'),
            ])
            ->assertRedirect(route('dashboard.gallery.index'));

        $gallery->refresh();

        $this->assertNotSame('galleries/images/old.jpg', $gallery->image);
        Storage::disk('public')->assertMissing('galleries/images/old.jpg');
        Storage::disk('public')->assertExists($gallery->image);
    }

    public function test_user_cannot_update_another_users_gallery_item(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $gallery = Gallery::factory()->for($owner)->create();

        $this->actingAs($other)
            ->put(route('dashboard.gallery.update', $gallery), [
                'title' => 'Hacked Title',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_gallery_item(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $gallery = Gallery::factory()->for($user)->create([
            'image' => 'galleries/images/test.jpg',
        ]);

        Storage::disk('public')->put('galleries/images/test.jpg', 'content');

        $this->actingAs($user)
            ->delete(route('dashboard.gallery.destroy', $gallery))
            ->assertRedirect(route('dashboard.gallery.index'));

        $this->assertDatabaseMissing('galleries', [
            'id' => $gallery->id,
        ]);

        Storage::disk('public')->assertMissing('galleries/images/test.jpg');
    }

    public function test_user_cannot_delete_another_users_gallery_item(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $gallery = Gallery::factory()->for($owner)->create();

        $this->actingAs($other)
            ->delete(route('dashboard.gallery.destroy', $gallery))
            ->assertForbidden();
    }
}
