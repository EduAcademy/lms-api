<?php

namespace App\Imports;

use App\Enums\RoleType;
use App\Helpers\StringHelper;
use App\Models\Department;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentImport implements ToCollection
{

    private $departmentShortNameMapping = [
        'تكنولوجيا المعلومات' => 'IT',  // IT
        'الأمن السيبراني' => 'CYS',     // CYS
        'علوم حاسوب' => 'CS',           // CS
        'نظم معلومات' => 'IS',          // IS
    ];


    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                // Map the columns to the correct attributes
                $uuid = $row[0]; // كود الطالب (Student Code)
                $firstName = $row[1]; // اسم الطالب (Student Name)
                $lastName = $row[26]; // إسم الطالب باللغه الانجليزيه (Student Name in English)
                $email = $row[14]; // الايميل (Email)
                $phone = $row[13]; // التلفون (Phone)
                $gender = $row[4] === 'ذكر' ? 'male' : 'female'; // النوع (Gender)
                $departmentName = $row[2]; // التخصص (Specialization)

                $shortName = $this->departmentShortNameMapping[$departmentName] ?? null;

                if (!$shortName) {
                    Log::warning("Invalid department name: $departmentName for student: $uuid");
                    continue;
                }

                $department = Department::where('short_name', $shortName)->first();
                if (!$department) {
                    Log::warning("Department not found for short name: $shortName for student: $uuid");
                    continue;
                }

                $departmentId = $department->id;

                $existingUser = User::where('email', $email)->first();

                if ($existingUser) {
                    Log::info("Duplicate user skipped: Email - $email");
                    continue;
                }

                $role = Role::where('name', RoleType::Student)->first();

                $username = StringHelper::getBeforeWhitespace($lastName);

                $user = User::create([
                    'username' => $username,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'gender' => $gender,
                    'password' => bcrypt('defaultPassword123'),
                    'role_id' => $role->id,
                ]);

                Student::create([
                    'uuid' => $uuid,
                    'user_id' => $user->id,
                    'department_id' => $departmentId,
                    'study_plan_id' => 1,
                    'group_id' => 1,
                    'sub_group_id' => 1,
                ]);

                Log::info("New student created: Username - $uuid, Email - $email");
            }
        });
    }
}
