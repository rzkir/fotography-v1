<?php

namespace App\Http\Requests;

use App\Models\JurnalCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateJurnalCategoryRequest extends FormRequest
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
        /** @var JurnalCategory $category */
        $category = $this->route('jurnalCategory');

        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('jurnal_categories', 'category_id')
                    ->where('user_id', auth()->id())
                    ->ignore($category->id),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $categoryId = $this->filled('category_id')
            ? Str::slug($this->input('category_id'))
            : Str::slug($this->input('title'));

        $this->merge([
            'category_id' => $categoryId !== '' ? $categoryId : 'category',
        ]);
    }
}
