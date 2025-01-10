<?php

namespace App\Http\Requests;

use App\Models\StudyPlanCourseInstructorSubGroup;
use Illuminate\Foundation\Http\FormRequest;

class StudyPlanCourseInstructorSubGroupRequest extends FormRequest
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
            'spc_instructor_id'=>'required|integer|exists:spc_instructors,id',
            'sub_group_id'=>'required|integer|exists:sub_groups,id',
            'instructor_id'=>'required|integer|exists:instructors,id'
        ];
    }
}
