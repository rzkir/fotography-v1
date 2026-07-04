<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_public_gallery_page(): void
    {
        $this->get(route('gallery.index'))
            ->assertOk()
            ->assertSee('WORKS')
            ->assertSee('GALLERY');
    }

    public function test_public_gallery_page_displays_gallery_items(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $gallery = Gallery::factory()->for($user)->create([
            'title' => 'Morning Light Study',
            'image' => 'galleries/images/morning-light.jpg',
        ]);

        Storage::disk('public')->put($gallery->image, 'image-content');

        $this->get(route('gallery.index'))
            ->assertOk()
            ->assertSee('Morning Light Study')
            ->assertSee('data-gallery-item', false)
            ->assertSee('gallery-preview-dialog', false);
    }

    public function test_public_gallery_page_shows_empty_state_when_no_items(): void
    {
        $this->get(route('gallery.index'))
            ->assertOk()
            ->assertSee('Belum ada karya');
    }
}
