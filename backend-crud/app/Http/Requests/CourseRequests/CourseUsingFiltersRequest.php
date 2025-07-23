<?php

namespace App\Http\Requests\CourseRequests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUsingFiltersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'searchTitle' => 'string|nullable',
            'searchAuthor' => 'string|nullable',

            'categoriesId' => 'array',
            'categoriesId.*' => 'integer|exists:categories,id',

            'proficienciesId' => 'array',
            'proficienciesId.*' => 'integer|exists:proficiencies,id',

            'languagesId' => 'array',
            'languagesId.*' => 'integer|exists:languages,id',

            'pricingId' => 'array',
            'pricingId.*' => 'integer|exists:pricings,id',
        ];
    }
}
