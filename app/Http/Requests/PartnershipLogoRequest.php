<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnershipLogoRequest extends FormRequest
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
//    public function rules()
//    {
//        return [
//            'title' => 'required|string|max:255',
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//        ];
//    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'image' => [
                function ($attribute, $value, $fail) {
                    if (!$this->hasFile('image') && !$this->input('existing_image')) {
                        $fail('The image field is required.');
                    }
                },
                'mimes:jpeg,png,jpg,gif', // Allow only valid image formats
                'max:2048', // Limit file size to 2MB
            ],
        ];
    }

}
