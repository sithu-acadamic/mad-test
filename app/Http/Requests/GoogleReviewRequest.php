<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoogleReviewRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'review_message' => 'required|string',
            'star_rating' => 'required|integer|min:1|max:5',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'review_message.required' => 'Review message is required.',
            'star_rating.required' => 'Please provide a star rating (1-5).',
        ];
    }

}
