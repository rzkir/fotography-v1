<?php

namespace App\Models;

use Database\Factories\JurnalFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'title',
    'slug',
    'category_id',
    'description',
    'content',
    'thumbnail',
    'status',
])]
class Jurnal extends Model
{
    /** @use HasFactory<JurnalFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jurnalCategory(): BelongsTo
    {
        $userId = $this->attributes['user_id'] ?? auth()->id();

        return $this->belongsTo(JurnalCategory::class, 'category_id', 'category_id')
            ->where('jurnal_categories.user_id', $userId);
    }

    /**
     * @return array{title: string|null, categoryId: string|null}
     */
    public function categoryPayload(): array
    {
        return [
            'title' => $this->jurnalCategory?->title,
            'categoryId' => $this->category_id,
        ];
    }

    public function thumbnailUrl(): ?string
    {
        if (! filled($this->thumbnail)) {
            return null;
        }

        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }

        return Storage::disk('public')->url($this->thumbnail);
    }

    /**
     * @return array{main: string, accent: string|null}
     */
    public function titleParts(): array
    {
        if (! str_contains(trim($this->title), ' ')) {
            return ['main' => $this->title, 'accent' => null];
        }

        $parts = preg_split('/\s+(?=[^\s]+$)/', trim($this->title), 2);

        return [
            'main' => $parts[0],
            'accent' => $parts[1] ?? null,
        ];
    }

    public function readingTimeMinutes(): int
    {
        $words = str_word_count(strip_tags($this->content ?? ''));

        return max(1, (int) ceil($words / 200));
    }

    /**
     * @return list<array{id: string, number: string, title: string}>
     */
    public function tableOfContents(): array
    {
        if (! filled($this->content)) {
            return [];
        }

        $items = [];

        if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $this->content, $matches)) {
            foreach ($matches[1] as $index => $heading) {
                $items[] = [
                    'id' => 'section-'.($index + 1),
                    'number' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'title' => html_entity_decode(strip_tags($heading)),
                ];
            }
        }

        return $items;
    }

    public function contentWithSectionIds(): string
    {
        if (! filled($this->content)) {
            return '';
        }

        $index = 0;

        return preg_replace_callback(
            '/<h2([^>]*)>/i',
            function (array $matches) use (&$index): string {
                $index++;
                $attributes = $matches[1];

                if (str_contains($attributes, 'id=')) {
                    return $matches[0];
                }

                return '<h2 id="section-'.$index.'"'.$attributes.'>';
            },
            $this->content
        );
    }
}
