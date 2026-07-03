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
        return $this->belongsTo(JurnalCategory::class, 'category_id', 'category_id')
            ->whereColumn('jurnal_categories.user_id', 'jurnals.user_id');
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
