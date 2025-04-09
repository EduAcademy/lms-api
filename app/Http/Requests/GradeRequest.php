<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'course_id' => 'required|integer|exists:courses,id',
            'student_id' => 'integer|exists:students,id',
            'group_id' => 'nullable',
            'sub_group_id' => 'nullable',
            'instructor_id' => 'required|integer|exists:instructors,id',
            'grade' => 'required|integer',
        ];
    }
}
