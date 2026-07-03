<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $socialMedia = collect($this->input('social_media', []))
            ->filter(fn (array $item): bool => filled($item['type'] ?? null) && filled($item['link'] ?? null))
            ->values()
            ->all();

        $this->merge([
            'social_media' => $socialMedia === [] ? null : $socialMedia,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'job' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'image', 'max:5120'],
            'social_media' => ['nullable', 'array'],
            'social_media.*.type' => ['required_with:social_media', 'string', Rule::in(Team::SOCIAL_TYPES)],
            'social_media.*.label' => ['nullable', 'string', 'max:255'],
            'social_media.*.link' => ['required_with:social_media', 'url', 'max:2048'],
        ];
    }
}
