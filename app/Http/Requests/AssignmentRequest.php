<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'instructor_id' => 'required|exists:instructors,id',
            'study_plan_course_instructor_id' => 'required|exists:spc_instructors,id',
            'study_plan_course_instructor_sub_group_id' => 'nullable',
        ];
    }
}
