<?php

namespace App\Imports;

use App\Enums\RoleType;
use App\Models\Department;
use App\Models\Level;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection
{
    private $departmentShortNameMapping = [
        'تكنولوجيا المعلومات' => 'IT',
        'الأمن السيبراني'    => 'CYBER',
        'علوم حاسوب'          => 'CS',
        'نظم معلومات'         => 'IS',
        'جرافكس'             => 'GM',
    ];

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                // Skip header row
                if ($index === 0) {
                    continue;
                }

                // Convert row to array then map columns from Excel, trimming each field
                [$uuid, $fullName, $departmentName, $genderArabic, $email, $studentLevel] = array_map('trim', $row->toArray());

                // Break loop if row is empty (all key fields are empty)
                if ($this->isEmptyRow($uuid, $fullName, $departmentName, $genderArabic, $email, $studentLevel)) {
                    Log::info('End of data reached. Stopping import.');
                    break;
                }

                // Convert gender from Arabic to English
                $gender = $genderArabic === 'ذكر' ? 'male' : 'female';

                // Split full name into first and last names
                [$firstName, $lastName] = $this->splitName($fullName);

                // Map department name to its short name and validate
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

                // Find level using the student level from Excel
                $levelName = 'level ' . $studentLevel;
                $level = Level::where('name', $levelName)->first();
                if (!$level) {
                    Log::warning("Level not found: $levelName for student: $uuid");
                    continue;
                }
                $levelId = $level->id;

                // Check for duplicate user by email
                if (User::where('email', $email)->exists()) {
                    Log::info("Duplicate user skipped: Email - $email");
                    continue;
                }

                // Get the student role from RoleType enum
                $role = Role::where('name', RoleType::Student)->first();
                if (!$role) {
                    Log::error("Student role not found for student: $uuid");
                    continue;
                }

                // Use first word of the last name as username or adjust as needed
                $username = strtok($lastName, ' ');

                // Create the user record
                $user = User::create([
                    'username'   => $username,
                    'email'      => $email,
                    'password'   => bcrypt('defaultPassword123'),
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'phone'      => '7777777777', // Default phone value
                    'role_id'    => $role->id,
                    'gender'     => $gender,
                    'is_active'  => true,
                ]);

                // Prepare student data array and create the student record
                Student::create([
                    'uuid'           => $uuid,
                    'user_id'        => $user->id,
                    'department_id'  => $departmentId,
                    'study_plan_id'  => 1,
                    'group_id'       => 1,
                    'sub_group_id'   => 1,
                    'level_id'       => $levelId,
                ]);

                Log::info("New student created: UUID - $uuid, Email - $email, Level: $levelName");
            }
        });
    }

    /**
     * Check if all provided fields are empty.
     */
    private function isEmptyRow(...$fields): bool
    {
        foreach ($fields as $field) {
            if (!empty($field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Split full name into first and last names.
     */
    private function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', $fullName);
        $firstName = array_shift($parts);
        $lastName = implode(' ', $parts);
        return [$firstName, $lastName];
    }
}
