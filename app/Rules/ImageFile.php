<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

class ImageFile implements ValidationRule
{
    /**
     * @return list<string|self>
     */
    public static function rules(int $maxKilobytes = 12288): array
    {
        return [
            'file',
            'max:'.$maxKilobytes,
            new self,
        ];
    }

    /**
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('The :attribute must be an image file.');

            return;
        }

        if (! $value->isValid()) {
            $fail('The :attribute failed to upload.');

            return;
        }

        $allowedExtensions = [
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg',
            'heic', 'heif', 'avif', 'tiff', 'tif', 'ico', 'jfif',
            'pjpeg', 'pjp', 'jxl', 'apng',
        ];

        $extension = strtolower($value->getClientOriginalExtension());
        $mimeType = strtolower($value->getMimeType() ?: '');

        if (str_starts_with($mimeType, 'image/')) {
            return;
        }

        if (in_array($extension, $allowedExtensions, true)) {
            return;
        }

        $path = $value->getRealPath();

        if ($path !== false) {
            $detectedMime = mime_content_type($path) ?: '';

            if (str_starts_with(strtolower($detectedMime), 'image/')) {
                return;
            }

            if (@getimagesize($path) !== false) {
                return;
            }
        }

        $fail('The :attribute must be an image file.');
    }
}
