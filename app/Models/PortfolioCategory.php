<?php

namespace App\Models;

use Database\Factories\PortfolioCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'title', 'category_id'])]
class PortfolioCategory extends Model
{
    /** @use HasFactory<PortfolioCategoryFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'category_id', 'category_id')
            ->whereColumn('portfolios.user_id', 'portfolio_categories.user_id');
    }
}
