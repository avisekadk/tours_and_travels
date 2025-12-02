<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'max_people' => 'nullable|integer|min:1',
            'min_people' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|exists:destinations,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tour title is required',
            'description.required' => 'Tour description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'duration.required' => 'Duration is required',
            'category_id.required' => 'Please select a category',
            'destination_id.required' => 'Please select a destination',
        ];
    }
}