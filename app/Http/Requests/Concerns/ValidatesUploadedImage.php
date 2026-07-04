<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Validation\Validator;

trait ValidatesUploadedImage
{
    protected function imageUploadMaxKilobytes(): int
    {
        $configuredLimit = (int) config('upload.image_max_kilobytes', 5120);
        $uploadLimit = $this->parseIniSizeKilobytes((string) ini_get('upload_max_filesize'));
        $postLimit = $this->parseIniSizeKilobytes((string) ini_get('post_max_size'));

        return min($configuredLimit, $uploadLimit, $postLimit);
    }

    protected function imageUploadMaxMegabytesLabel(): string
    {
        $maxKilobytes = $this->imageUploadMaxKilobytes();

        return rtrim(rtrim(number_format($maxKilobytes / 1024, 1), '0'), '.').' MB';
    }

    /**
     * @return array<string, string>
     */
    protected function imageUploadMessages(): array
    {
        $maxLabel = $this->imageUploadMaxMegabytesLabel();

        return [
            'image.required' => 'Please select an image to upload.',
            'image.max' => "The image must not be larger than {$maxLabel}.",
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->has('image')) {
                return;
            }

            $error = $_FILES['image']['error'] ?? null;

            if (in_array($error, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
                $validator->errors()->add(
                    'image',
                    'The image is too large. Maximum upload size is '.$this->imageUploadMaxMegabytesLabel().'.'
                );

                return;
            }

            if ($error === UPLOAD_ERR_PARTIAL) {
                $validator->errors()->add(
                    'image',
                    'The image upload was interrupted. Please try again.'
                );
            }
        });
    }

    protected function parseIniSizeKilobytes(string $value): int
    {
        $value = trim($value);

        if ($value === '') {
            return (int) config('upload.image_max_kilobytes', 5120);
        }

        $unit = strtolower($value[strlen($value) - 1]);

        if (in_array($unit, ['g', 'm', 'k'], true)) {
            $number = (float) substr($value, 0, -1);

            return (int) match ($unit) {
                'g' => $number * 1024 * 1024,
                'm' => $number * 1024,
                'k' => $number,
            };
        }

        return (int) ((float) $value / 1024);
    }
}
