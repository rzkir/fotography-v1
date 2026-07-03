<?php

namespace App\Http\Requests;

use App\Models\PortfolioCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdatePortfolioCategoryRequest extends FormRequest
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
        /** @var PortfolioCategory $category */
        $category = $this->route('portfolioCategory');

        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('portfolio_categories', 'category_id')
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
