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
        return $this->thumbnail ? Storage::disk('public')->url($this->thumbnail) : null;
    }
}
