<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreJurnalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $imageFile = $this->imageFileRules();

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('jurnals', 'slug')],
            'category_id' => [
                'nullable',
                'string',
                'max:255',
                Rule::exists('jurnal_categories', 'category_id')->where('user_id', $this->user()->id),
            ],
            'description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'thumbnail' => ['nullable', ...$imageFile],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->input('slug')),
            ]);
        }
    }

    /**
     * @return list<string|Closure>
     */
    private function imageFileRules(): array
    {
        return [
            'file',
            'max:12288',
            function (string $attribute, mixed $value, Closure $fail): void {
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
            },
        ];
    }
}
