<?php

namespace App\Mappings;

use App\Models\Student;

class StudentMapping
{
    public static function toStudent(Student $student): array
    {
        return [
            'id' => $student->id,
            'uuid' => $student->uuid,
            'department_id' => $student->department_id,
            'study_plan_id' => $student->study_plan_id,
            'created_at' => $student->created_at,
            'updated_at' => $student->updated_at,
            'group_id' => $student->group_id,
            'sub_group_id' => $student->sub_group_id,
            'user_id' => $student->user->id,
            'username' => $student->user->username,
            'email' => $student->user->email,
            'first_name' => $student->user->first_name,
            'last_name' => $student->user->last_name,
            'phone' => $student->user->phone,
            'gender' => $student->user->gender,
            'is_active' => $student->user->is_active,
            'role_id' => $student->user->role_id,
        ];
    }
}
