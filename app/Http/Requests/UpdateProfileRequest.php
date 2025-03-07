<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'image_url' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    protected function prepareForValidation()
    {
        // Convert empty string to null for image_url
        if ($this->has('image_url') && $this->input('image_url') === '') {
            $this->merge(['image_url' => null]);
        }
    }
}
