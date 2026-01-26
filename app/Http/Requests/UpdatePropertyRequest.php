<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:5000',
            'price' => 'sometimes|numeric|min:0|max:999999999.99',
            'location' => 'sometimes|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'sometimes|in:rent,sale',
            'status' => 'sometimes|in:available,sold,rented,pending',
            'bedrooms' => 'nullable|integer|min:0|max:50',
            'bathrooms' => 'nullable|integer|min:0|max:50',
            'area' => 'nullable|numeric|min:0|max:999999.99',
            'property_type' => 'nullable|string|max:100',
            'features' => 'nullable|array|max:20',
            'features.*' => 'string|max:100',
            'category_id' => 'sometimes|exists:categories,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.string' => 'Property title must be a string.',
            'description.string' => 'Property description must be a string.',
            'price.numeric' => 'Price must be a valid number.',
            'type.in' => 'Property type must be either rent or sale.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}
