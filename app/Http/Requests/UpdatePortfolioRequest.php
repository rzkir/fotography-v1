<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdatePortfolioRequest extends StorePortfolioRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['slug'] = [
            'nullable',
            'string',
            'max:255',
            'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            Rule::unique('portfolios', 'slug')->ignore($this->route('portofolio')),
        ];

        return $rules;
    }
}
