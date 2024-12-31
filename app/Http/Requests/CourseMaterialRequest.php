<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseMaterialRequest extends FormRequest
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
            'name' => 'required|string',
            'type' => 'required|in:theoretical,practical',
            'url' => 'nullable|url',
            'course_id' => 'required|integer|exists:courses,id',
            'instructor_id' => 'required|integer|exists:instructors,id'
        ];
    }
}
