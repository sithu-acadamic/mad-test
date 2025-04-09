<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OurServiceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title_one' => 'required|string|max:255',
            'title_two' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
