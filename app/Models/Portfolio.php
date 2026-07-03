<?php

namespace App\Models;

use Database\Factories\PortfolioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
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
        $userId = $this->attributes['user_id'] ?? auth()->id();

        return $this->belongsTo(PortfolioCategory::class, 'category_id', 'category_id')
            ->where('portfolio_categories.user_id', $userId);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->withPivot('description')
            ->withTimestamps();
    }

    /**
     * @return Collection<int, array{name: string, job: string, description: string|null, photo_url: string|null, social_media: list<array{type: string, label: string|null, link: string}>}>
     */
    public function contributorsForDisplay(): Collection
    {
        if ($this->relationLoaded('teams') && $this->teams->isNotEmpty()) {
            return $this->teams->map(fn (Team $team): array => [
                'name' => $team->name,
                'job' => $team->job,
                'description' => $team->pivot->description,
                'photo_url' => $team->pictureUrl(),
                'social_media' => $team->social_media ?? [],
            ]);
        }

        return collect($this->contributors ?? [])->map(function (array $contributor): array {
            $legacySocial = $contributor['social_media'] ?? null;
            $socialMedia = [];

            if (filled($legacySocial)) {
                $href = self::socialMediaHref($legacySocial);

                if ($href !== null) {
                    $socialMedia[] = [
                        'type' => str_contains(strtolower($legacySocial), 'linkedin') ? 'linkedin' : 'instagram',
                        'label' => $legacySocial,
                        'link' => $href,
                    ];
                }
            }

            return [
                'name' => $contributor['name'] ?? '',
                'job' => $contributor['job'] ?? '',
                'description' => $contributor['description'] ?? null,
                'photo_url' => $this->contributorImageUrl($contributor),
                'social_media' => $socialMedia,
            ];
        });
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

    public function headlineTitle(): string
    {
        if (blank($this->subtitle)) {
            return $this->title;
        }

        $pattern = '/\s*'.preg_quote($this->subtitle, '/').'\s*$/iu';
        $main = trim(preg_replace($pattern, '', $this->title));

        return $main !== '' ? $main : $this->title;
    }

    public function contributorImageUrl(array $contributor): ?string
    {
        $path = $contributor['path'] ?? ($contributor['image'] ?? null);

        if (! filled($path)) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    public static function socialMediaHref(?string $social): ?string
    {
        if (! filled($social)) {
            return null;
        }

        if (str_starts_with($social, 'http://') || str_starts_with($social, 'https://')) {
            return $social;
        }

        $handle = ltrim($social, '@');

        if (str_contains(strtolower($social), 'linkedin')) {
            return 'https://linkedin.com/in/'.$handle;
        }

        return 'https://instagram.com/'.$handle;
    }
}
