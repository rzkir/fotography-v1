<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePortfolioRequest extends FormRequest
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
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('portfolios', 'slug')],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'category_id' => [
                'nullable',
                'string',
                'max:255',
                Rule::exists('portfolio_categories', 'category_id')->where('user_id', $this->user()->id),
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', ...$imageFile],
            'hero_caption' => ['nullable', 'string', 'max:255'],
            'quote' => ['nullable', 'string'],
            'content_sections' => ['nullable', 'array'],
            'content_sections.*.title' => ['nullable', 'string', 'max:255'],
            'content_sections.*.description' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => $imageFile,
            'existing_gallery' => ['nullable', 'json'],
            'metrics_shots_taken' => ['nullable', 'string', 'max:50'],
            'metrics_final_selects' => ['nullable', 'string', 'max:50'],
            'metrics_total_hours' => ['nullable', 'string', 'max:50'],
            'metrics_team_members' => ['nullable', 'string', 'max:50'],
            'camera_setup' => ['nullable', 'string', 'max:255'],
            'camera_settings' => ['nullable', 'string', 'max:255'],
            'lighting_array' => ['nullable', 'string', 'max:255'],
            'lighting_notes' => ['nullable', 'string'],
            'post_processing' => ['nullable', 'array'],
            'post_processing.*.title' => ['nullable', 'string', 'max:255'],
            'post_processing.*.text' => ['nullable', 'string'],
            'retouching_notes' => ['nullable', 'string'],
            'timeline' => ['nullable', 'array'],
            'timeline.*.title' => ['nullable', 'string', 'max:255'],
            'timeline.*.text' => ['nullable', 'string'],
            'team_members' => ['nullable', 'array'],
            'team_members.*.team_id' => [
                'required',
                'integer',
                Rule::exists('teams', 'id')->where(fn ($query) => $query->where('user_id', $this->user()->id)),
            ],
            'testimonial_quote' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->input('slug')),
            ]);
        }

        $teamMembers = collect($this->input('team_members', []))
            ->filter(fn (array $member): bool => filled($member['team_id'] ?? null))
            ->values()
            ->all();

        $this->merge([
            'team_members' => $teamMembers === [] ? null : $teamMembers,
        ]);
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
