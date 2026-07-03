<?php

namespace Tests\Feature;

use App\Models\Jurnal;
use App\Models\JurnalCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JurnalCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_jurnal_index(): void
    {
        $this->get(route('dashboard.jurnal.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_jurnal_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.jurnal.index'))
            ->assertOk()
            ->assertSee('Studio Journal');
    }

    public function test_user_can_create_jurnal_article(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        JurnalCategory::factory()->for($user)->create([
            'title' => 'Craft & Technique',
            'category_id' => 'craft-technique',
        ]);

        $response = $this->actingAs($user)->post(route('dashboard.jurnal.store'), [
            'title' => 'The Alchemy of Chiaroscuro',
            'category_id' => 'craft-technique',
            'description' => 'Exploring the dramatic rebirth of chiaroscuro in modern digital portraiture.',
            'content' => 'Photography is, at its most fundamental level, the management of photons.',
            'status' => 'published',
            'thumbnail' => UploadedFile::fake()->image('hero.jpg'),
        ]);

        $jurnal = Jurnal::query()->first();

        $this->assertNotNull($jurnal);
        $response->assertRedirect(route('dashboard.jurnal.edit', $jurnal));

        $this->assertDatabaseHas('jurnals', [
            'user_id' => $user->id,
            'title' => 'The Alchemy of Chiaroscuro',
            'slug' => 'the-alchemy-of-chiaroscuro',
            'category_id' => 'craft-technique',
            'status' => 'published',
        ]);

        Storage::disk('public')->assertExists($jurnal->thumbnail);
    }

    public function test_user_can_update_own_jurnal(): void
    {
        $user = User::factory()->create();
        JurnalCategory::factory()->for($user)->create([
            'title' => 'Theory / Color',
            'category_id' => 'theory-color',
        ]);
        $jurnal = Jurnal::factory()->for($user)->create([
            'title' => 'Old Title',
            'slug' => 'old-title',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.jurnal.update', $jurnal), [
                'title' => 'Updated Title',
                'category_id' => 'theory-color',
                'description' => 'Updated description.',
                'content' => 'Updated content body.',
                'status' => 'draft',
            ])
            ->assertRedirect(route('dashboard.jurnal.edit', $jurnal));

        $this->assertDatabaseHas('jurnals', [
            'id' => $jurnal->id,
            'title' => 'Updated Title',
            'slug' => 'updated-title',
            'status' => 'draft',
        ]);
    }

    public function test_user_cannot_update_another_users_jurnal(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $jurnal = Jurnal::factory()->for($owner)->create();

        $this->actingAs($other)
            ->put(route('dashboard.jurnal.update', $jurnal), [
                'title' => 'Hacked',
                'status' => 'draft',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_jurnal(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $jurnal = Jurnal::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('dashboard.jurnal.destroy', $jurnal))
            ->assertRedirect(route('dashboard.jurnal.index'));

        $this->assertDatabaseMissing('jurnals', ['id' => $jurnal->id]);
    }
}
