<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('portfolios', 'slug')],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'category' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
            'hero_caption' => ['nullable', 'string', 'max:255'],
            'quote' => ['nullable', 'string'],
            'content_sections' => ['nullable', 'array'],
            'content_sections.*.title' => ['nullable', 'string', 'max:255'],
            'content_sections.*.description' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:5120'],
            'existing_gallery' => ['nullable', 'json'],
            'metrics_shots_taken' => ['nullable', 'string', 'max:50'],
            'metrics_final_selects' => ['nullable', 'string', 'max:50'],
            'metrics_total_hours' => ['nullable', 'string', 'max:50'],
            'metrics_team_members' => ['nullable', 'string', 'max:50'],
            'camera_setup' => ['nullable', 'string', 'max:255'],
            'camera_settings' => ['nullable', 'string', 'max:255'],
            'lighting_array' => ['nullable', 'string', 'max:255'],
            'lighting_notes' => ['nullable', 'string'],
            'post_processing' => ['nullable', 'string'],
            'retouching_notes' => ['nullable', 'string'],
            'timeline_json' => ['nullable', 'json'],
            'contributors_json' => ['nullable', 'json'],
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
    }
}
