<?php

namespace Tests\Unit;

use App\Models\Gallery;
use App\Models\Jurnal;
use App\Models\Portfolio;
use App\Models\Team;
use App\Models\User;
use App\Services\UserStorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserStorageServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculates_storage_from_user_uploaded_files(): void
    {
        Storage::fake('public');
        config(['upload.storage_quota_megabytes' => 10]);

        $user = User::factory()->create();
        $oneMegabyte = str_repeat('a', 1024 * 1024);

        Storage::disk('public')->put('galleries/images/photo.jpg', $oneMegabyte);
        Storage::disk('public')->put('teams/pictures/member.jpg', $oneMegabyte);

        Gallery::factory()->for($user)->create(['image' => 'galleries/images/photo.jpg']);
        Team::factory()->for($user)->create(['picture' => 'teams/pictures/member.jpg']);

        $stats = app(UserStorageService::class)->forUser($user);

        $this->assertSame(2 * 1024 * 1024, $stats['used_bytes']);
        $this->assertSame(20, $stats['used_percent']);
        $this->assertSame('2.0 MB', $stats['used_label']);
        $this->assertSame(2, $stats['file_count']);
    }

    public function test_ignores_external_image_urls(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Jurnal::factory()->for($user)->create([
            'thumbnail' => 'https://images.unsplash.com/photo-example.jpg',
        ]);

        Portfolio::factory()->for($user)->create([
            'hero_image' => 'https://images.unsplash.com/photo-example.jpg',
            'gallery_images' => [
                ['url' => 'https://images.unsplash.com/photo-example.jpg', 'path' => null],
            ],
        ]);

        $stats = app(UserStorageService::class)->forUser($user);

        $this->assertSame(0, $stats['used_bytes']);
        $this->assertSame(0, $stats['used_percent']);
        $this->assertSame(0, $stats['file_count']);
    }

    public function test_includes_portfolio_gallery_image_paths(): void
    {
        Storage::fake('public');
        config(['upload.storage_quota_megabytes' => 5]);

        $user = User::factory()->create();
        $fileContents = str_repeat('b', 512 * 1024);

        Storage::disk('public')->put('portfolios/gallery/slide.jpg', $fileContents);

        Portfolio::factory()->for($user)->create([
            'gallery_images' => [
                ['path' => 'portfolios/gallery/slide.jpg', 'caption' => 'Slide', 'alt' => 'Slide'],
            ],
        ]);

        $stats = app(UserStorageService::class)->forUser($user);

        $this->assertSame(512 * 1024, $stats['used_bytes']);
        $this->assertSame(1, $stats['file_count']);
    }
}
