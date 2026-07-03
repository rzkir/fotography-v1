<?php

namespace App\Models;

use Database\Factories\PortfolioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'title',
    'slug',
    'subtitle',
    'client',
    'year',
    'category_id',
    'location',
    'hero_image',
    'hero_caption',
    'quote',
    'content_sections',
    'gallery_images',
    'metrics',
    'technical_specs',
    'timeline',
    'contributors',
    'testimonial',
    'status',
    'is_published',
])]
class Portfolio extends Model
{
    /** @use HasFactory<PortfolioFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'content_sections' => 'array',
            'gallery_images' => 'array',
            'metrics' => 'array',
            'technical_specs' => 'array',
            'timeline' => 'array',
            'contributors' => 'array',
            'testimonial' => 'array',
            'is_published' => 'boolean',
            'year' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolioCategory(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class, 'category_id', 'category_id')
            ->whereColumn('portfolio_categories.user_id', 'portfolios.user_id');
    }

    /**
     * @return array{title: string|null, categoryId: string|null}
     */
    public function categoryPayload(): array
    {
        return [
            'title' => $this->portfolioCategory?->title,
            'categoryId' => $this->category_id,
        ];
    }

    public function heroImageUrl(): ?string
    {
        return $this->hero_image ? Storage::disk('public')->url($this->hero_image) : null;
    }

    public function galleryImageUrls(): array
    {
        return collect($this->gallery_images ?? [])
            ->map(function (array $image): array {
                $path = $image['path'] ?? null;

                return [
                    'url' => $path ? Storage::disk('public')->url($path) : ($image['url'] ?? null),
                    'caption' => $image['caption'] ?? '',
                    'alt' => $image['alt'] ?? '',
                    'path' => $path,
                ];
            })
            ->filter(fn (array $image): bool => filled($image['url']))
            ->values()
            ->all();
    }
}
