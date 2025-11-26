<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'The image must be an image.',
            'image.mimes' => 'The image must be a jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image must be less than 2MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'image' => 'Image',
        ];
    }
}
