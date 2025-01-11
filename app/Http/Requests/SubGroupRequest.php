<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubGroupRequest extends FormRequest
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
            //
            'name' => 'required|string|unique:sub_groups,name',
            'groups_id' => 'required|integer|exists:groups,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
        ];
    }
}
