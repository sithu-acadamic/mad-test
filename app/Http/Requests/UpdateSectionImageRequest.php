<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionImageRequest extends FormRequest
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
    public function rules()
    {
        return [
            'section' => 'required|string|exists:sections_images,section_code',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
         ];
    }

    public function messages()
    {
        return [
            'section.required' => 'Please select a section.',
            'section.exists' => 'Invalid section selected.',
            'image.required' => 'Please upload an image.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Only JPG, PNG, and JPEG formats are allowed.',
            'image.max' => 'Image size must be less than 5MB.',
        ];
    }
}
