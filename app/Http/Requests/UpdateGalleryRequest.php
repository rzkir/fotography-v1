<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidatesUploadedImage;
use App\Rules\ImageFile;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    use ValidatesUploadedImage;

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
            'image' => ['nullable', ...ImageFile::rules($this->imageUploadMaxKilobytes())],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->imageUploadMessages();
    }
}
