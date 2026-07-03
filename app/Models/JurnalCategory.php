<?php

namespace App\Models;

use Database\Factories\JurnalCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'title', 'category_id'])]
class JurnalCategory extends Model
{
    /** @use HasFactory<JurnalCategoryFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jurnals(): HasMany
    {
        $userId = $this->attributes['user_id'] ?? auth()->id();

        return $this->hasMany(Jurnal::class, 'category_id', 'category_id')
            ->where('jurnals.user_id', $userId);
    }
}
