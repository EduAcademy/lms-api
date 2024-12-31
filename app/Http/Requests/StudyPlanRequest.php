<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyPlanRequest extends FormRequest
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
            'study_plan_no' => 'required|integer|unique:study_plans,study_plan_no',
            'level' => 'required|integer',
            'semester' => 'required|integer',
            'issued_at' => 'required|date',
            'department_id' => 'required|integer|exists:departments,id',
            'courses' => 'required|array',
            'courses.*.course_id' => 'required|integer|exists:courses,id',
        ];
    }
}
