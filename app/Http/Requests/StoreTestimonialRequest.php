<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
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
            'message' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'jobs' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
        ];
    }
}
