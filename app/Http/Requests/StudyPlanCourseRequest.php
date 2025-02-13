<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyPlanCourseRequest extends FormRequest
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
            'study_plan_id' => 'required|integer|exists:study_plans,id',
            'department_id' => 'required|integer|exists:departments,id',
            'course_id' => 'required|array',
            'course_id.*' => 'integer|exists:courses,id',
            'level_id' => 'required|integer|exists:levels,id',
            'semester' => 'required|integer|in:1,2',
        ];
    }
}
