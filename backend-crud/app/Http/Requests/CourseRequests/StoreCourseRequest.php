<?php

namespace App\Http\Requests\CourseRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'language_id' => 'required|exists:languages,id',
            'proficiency_id' => 'required|exists:proficiencies,id',
            'pricing_id' => 'required|exists:pricings,id',
            'based_price' => 'required|numeric',
            'discounted_price' => 'numeric|nullable',
            'discount_start_date' => 'date|nullable',
            'discount_end_date' => 'date|nullable',
            'requirements' => 'array',
            'goals' => 'array',
            'image' => 'required|image|max:2048',
        ];
    }
}
