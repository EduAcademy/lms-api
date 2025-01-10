<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyPlanCourseInstructorRequest extends FormRequest
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
            'study_plan_course_id'=> 'required|integer|exists:study_plan_courses,id',
            'group_id'=> 'required|integer|exists:groups,id',
            'instructor_id'=> 'required|integer|exists:instructors,id'
        ];
    }
}
