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
    ];

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                // Skip header row
                if ($index === 0) {
                    continue;
                }

                // Map columns from Excel:
                // 0: كود الطالب (Student Code)
                // 1: اسم الطالب (Student Name)
                // 2: التخصص (Specialization)
                // 3: النوع (Gender)
                // 4: الايميل (Email)
                // 5: مستوى الطالب (Student Level)
                $uuid = trim($row[0]);
                $fullName = trim($row[1]);
                $departmentName = trim($row[2]);
                $genderArabic = trim($row[3]);
                $email = trim($row[4]);
                $studentLevel = trim($row[5]);

                // Stop processing if the row is empty
                if (empty($uuid) && empty($fullName) && empty($departmentName) && empty($genderArabic) && empty($email) && empty($studentLevel)) {
                    Log::info('End of data reached. Stopping import.');
                    break;
                }

                // Convert gender from Arabic to English
                $gender = $genderArabic === 'ذكر' ? 'male' : 'female';

                // Split full name into first and last names
                $nameParts = preg_split('/\s+/', $fullName);
                $firstName = array_shift($nameParts);
                $lastName = implode(' ', $nameParts);

                // Get department short name
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

                // Look up the student level in the levels table
                $levelName = 'level ' . $studentLevel;
                $level = Level::where('name', $levelName)->first();
                if (!$level) {
                    Log::warning("Level not found: $levelName for student: $uuid");
                    continue;
                }
                $levelId = $level->id;

                // Check for duplicate user
                $existingUser = User::where('email', $email)->first();
                if ($existingUser) {
                    Log::info("Duplicate user skipped: Email - $email");
                    continue;
                }

                // Get the student role
                $role = Role::where('name', RoleType::Student)->first();
                if (!$role) {
                    Log::error("Student role not found for student: $uuid");
                    continue;
                }

                // Use the first word of the last name as username
                $username = strtok($lastName, ' ');

                // Create the user (mimicking createStudent)
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

                // Prepare student data
                $studentData = [
                    'uuid'           => $uuid,
                    'user_id'        => $user->id,
                    'department_id'  => $departmentId,
                    'study_plan_id'  => 1,
                    'group_id'       => 1,
                    'sub_group_id'   => 1,
                    'level_id'       => $levelId,
                ];

                // Create the student record
                Student::create($studentData);

                Log::info("New student created: UUID - $uuid, Email - $email, Level: $levelName");
            }
        });
    }
}
