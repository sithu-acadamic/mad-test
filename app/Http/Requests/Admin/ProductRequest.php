<?php

namespace App\Http\Requests\Admin;


use App\Rules\ImageRequiredIfOldValue;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'product_name' => 'required|string',
            'product_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'product_type' =>'required|string',
            'product_short_description' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_additional_information' => 'required|string'
        ];


        // Check if image_old_value is present
        $imageOldValue = $this->has('image_old_value');

        if ($imageOldValue && $this->filled('image_old_value')) {
            $rules['product_image'] = 'nullable|image|dimensions:width=470,height=520';
        } else {
            $rules['product_image'] = 'required|image|dimensions:width=470,height=520';
        }

        return $rules;
    }
}
