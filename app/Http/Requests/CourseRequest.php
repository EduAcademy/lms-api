<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'name' => 'required|string|unique:courses,name',
            'description' => 'nullable|string',
            'course_code' => 'required|string|min:2',
            'course_hours' => 'required|integer',
            'type' => 'required|in:core,elective',
            'department_id' => 'required|integer|exists:departments,id',
        ];
    }
}
