<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentSubmissionRequest extends FormRequest
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
            'data' => 'nullable|string',
            'student_id' => 'integer|exists:students,id',
            'assignment_id' => 'required|integer|exists:assignments,id',
            'assignment_status_id' => 'required|integer|exists:assignment_status,id',
            'file_url' => 'nullable|string',
        ];
    }
}
