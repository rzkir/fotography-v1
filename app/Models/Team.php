<?php

namespace App\Models;

use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'name',
    'job',
    'biography',
    'number',
    'picture',
    'social_media',
])]
class Team extends Model
{
    /** @use HasFactory<TeamFactory> */
    use HasFactory;

    public const SOCIAL_TYPES = [
        'instagram',
        'facebook',
        'tiktok',
        'linkedin',
    ];

    protected function casts(): array
    {
        return [
            'social_media' => 'array',
            'number' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios(): BelongsToMany
    {
        return $this->belongsToMany(Portfolio::class)
            ->withPivot('description')
            ->withTimestamps();
    }

    public function pictureUrl(): ?string
    {
        return $this->picture ? Storage::disk('public')->url($this->picture) : null;
    }

    /**
     * @param  list<int>  $teamIds
     */
    public static function recalculateNumbers(array $teamIds): void
    {
        foreach (array_unique($teamIds) as $teamId) {
            $team = self::query()->find($teamId);

            if ($team === null) {
                continue;
            }

            $team->update([
                'number' => $team->portfolios()->count(),
            ]);
        }
    }

    public static function socialIcon(string $type): string
    {
        return match ($type) {
            'facebook' => 'mdi:facebook',
            'tiktok' => 'ic:baseline-tiktok',
            'linkedin' => 'mdi:linkedin',
            default => 'mdi:instagram',
        };
    }
}
