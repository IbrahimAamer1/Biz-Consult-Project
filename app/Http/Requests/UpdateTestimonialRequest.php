<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The name is required',
            'position.required' => 'The position is required',
            'image.required' => 'The image is required',
            'image.image' => 'The image must be an image',
            'image.mimes' => 'The image must be a jpeg, png, jpg, gif, or svg',
            'image.max' => 'The image must be less than 2MB',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'position' => 'Position',
            'image' => 'Image',
            'description' => 'Description',
        ];
    }
}
    