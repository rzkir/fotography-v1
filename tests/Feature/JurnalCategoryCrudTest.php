<?php

namespace Tests\Feature;

use App\Models\Jurnal;
use App\Models\JurnalCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JurnalCategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_jurnal_category_index(): void
    {
        $this->get(route('dashboard.jurnal.category.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_jurnal_category_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.jurnal.category.index'))
            ->assertOk()
            ->assertSee('Journal Categories');
    }

    public function test_user_can_create_jurnal_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.jurnal.category.store'), [
            'title' => 'Craft & Technique',
            'category_id' => 'craft-technique',
        ]);

        $response->assertRedirect(route('dashboard.jurnal.category.index'));
        $this->assertDatabaseHas('jurnal_categories', [
            'user_id' => $user->id,
            'title' => 'Craft & Technique',
            'category_id' => 'craft-technique',
        ]);
    }

    public function test_category_id_is_auto_generated_from_title_when_empty(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.jurnal.category.store'), [
            'title' => 'Theory / Color',
        ]);

        $this->assertDatabaseHas('jurnal_categories', [
            'user_id' => $user->id,
            'title' => 'Theory / Color',
            'category_id' => 'theory-color',
        ]);
    }

    public function test_user_can_update_jurnal_category(): void
    {
        $user = User::factory()->create();
        $category = JurnalCategory::factory()->for($user)->create([
            'title' => 'Hardware / Gear',
            'category_id' => 'hardware-gear',
        ]);

        $this->actingAs($user)
            ->put(route('dashboard.jurnal.category.update', $category), [
                'title' => 'Gear Reviews',
                'category_id' => 'gear-reviews',
            ])
            ->assertRedirect(route('dashboard.jurnal.category.index'));

        $this->assertDatabaseHas('jurnal_categories', [
            'id' => $category->id,
            'title' => 'Gear Reviews',
            'category_id' => 'gear-reviews',
        ]);
    }

    public function test_user_cannot_delete_category_in_use(): void
    {
        $user = User::factory()->create();
        $category = JurnalCategory::factory()->for($user)->create([
            'title' => 'Lifestyle / Travel',
            'category_id' => 'lifestyle-travel',
        ]);

        Jurnal::factory()->for($user)->create([
            'category' => 'Lifestyle / Travel',
        ]);

        $this->actingAs($user)
            ->delete(route('dashboard.jurnal.category.destroy', $category))
            ->assertRedirect(route('dashboard.jurnal.category.index'));

        $this->assertDatabaseHas('jurnal_categories', ['id' => $category->id]);
    }

    public function test_user_can_delete_unused_jurnal_category(): void
    {
        $user = User::factory()->create();
        $category = JurnalCategory::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('dashboard.jurnal.category.destroy', $category))
            ->assertRedirect(route('dashboard.jurnal.category.index'));

        $this->assertDatabaseMissing('jurnal_categories', ['id' => $category->id]);
    }
}
