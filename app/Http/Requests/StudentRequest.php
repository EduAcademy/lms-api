<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
             // 'uuid' => 'required|string|unique:students,uuid',
             'department_id' => 'required|exists:departments,id',
             'study_plan_id' => 'required|exists:study_plans,id',
             'user_id' => 'required|exists:users,id',
             'group_id' => 'required|exists:groups,id',
             'sub_group_id' => 'required|exists:sub_groups,id',
        ];
    }
}
