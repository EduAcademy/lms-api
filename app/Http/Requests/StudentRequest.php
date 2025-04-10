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
            'username'      => 'required|string|unique:users,username',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'phone'         => 'required|string',
            'gender'        => 'required|string|in:male,female',
            'department_id' => 'required|exists:departments,id',
            'study_plan_id' => 'required|exists:study_plans,id',
            'group_id'      => 'required|exists:groups,id',
            'sub_group_id'  => 'required|exists:sub_groups,id',
            'level_id'   => 'required|exists:levels,id',

        ];
    }
}
