<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserStorageService
{
    /**
     * @return array{
     *     used_bytes: int,
     *     quota_bytes: int,
     *     used_percent: float|int,
     *     used_label: string,
     *     quota_label: string,
     *     file_count: int
     * }
     */
    public function forUser(User $user): array
    {
        $paths = $this->collectStoredPaths($user);
        $usedBytes = $this->calculateUsedBytes($paths);
        $quotaBytes = $this->quotaBytes();
        $usedPercent = $this->usedPercent($usedBytes, $quotaBytes);

        return [
            'used_bytes' => $usedBytes,
            'quota_bytes' => $quotaBytes,
            'used_percent' => $usedPercent,
            'used_label' => $this->formatBytes($usedBytes),
            'quota_label' => $this->formatBytes($quotaBytes),
            'file_count' => count($paths),
        ];
    }

    /**
     * @return list<string>
     */
    private function collectStoredPaths(User $user): array
    {
        $paths = [];

        foreach ($user->galleries()->pluck('image') as $path) {
            $paths[] = $path;
        }

        foreach ($user->portfolios()->get(['hero_image', 'gallery_images', 'contributors']) as $portfolio) {
            if ($this->isLocalStoragePath($portfolio->hero_image)) {
                $paths[] = $portfolio->hero_image;
            }

            foreach ($portfolio->gallery_images ?? [] as $image) {
                if ($this->isLocalStoragePath($image['path'] ?? null)) {
                    $paths[] = $image['path'];
                }
            }

            foreach ($portfolio->contributors ?? [] as $contributor) {
                $contributorPath = $contributor['path'] ?? ($contributor['image'] ?? null);

                if ($this->isLocalStoragePath($contributorPath)) {
                    $paths[] = $contributorPath;
                }
            }
        }

        foreach ($user->jurnals()->pluck('thumbnail') as $path) {
            if ($this->isLocalStoragePath($path)) {
                $paths[] = $path;
            }
        }

        foreach ($user->teams()->pluck('picture') as $path) {
            if ($this->isLocalStoragePath($path)) {
                $paths[] = $path;
            }
        }

        return array_values(array_unique(array_filter($paths)));
    }

    /**
     * @param  list<string>  $paths
     */
    private function calculateUsedBytes(array $paths): int
    {
        $disk = Storage::disk('public');
        $total = 0;

        foreach ($paths as $path) {
            if ($disk->exists($path)) {
                $total += $disk->size($path);
            }
        }

        return $total;
    }

    private function usedPercent(int $usedBytes, int $quotaBytes): float|int
    {
        if ($quotaBytes <= 0) {
            return 0;
        }

        $percent = min(100, ($usedBytes / $quotaBytes) * 100);

        if ($percent > 0 && $percent < 1) {
            return round($percent, 1);
        }

        return (int) round($percent);
    }

    private function quotaBytes(): int
    {
        $quotaMegabytes = (int) config('upload.storage_quota_megabytes', 5120);

        return max(1, $quotaMegabytes) * 1024 * 1024;
    }

    private function isLocalStoragePath(?string $path): bool
    {
        if (! filled($path)) {
            return false;
        }

        return ! str_starts_with($path, 'http://') && ! str_starts_with($path, 'https://');
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1_073_741_824) {
            return number_format($bytes / 1_073_741_824, 1).' GB';
        }

        if ($bytes >= 1_048_576) {
            return number_format($bytes / 1_048_576, 1).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }
}
