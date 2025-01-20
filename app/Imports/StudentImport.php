<?php

namespace App\Imports;

use App\Enums\RoleType;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {

                if ($index === 0) {
                    continue;
                }

                if (!isset($row[1], $row[2], $row[3], $row[4])) {
                    Log::warning("Row skipped due to missing fields: " . json_encode($row));
                    continue;
                }

                //We suppose that excel file has these records in order.
                $username = $row[1];
                $firstName = $row[2];
                $lastName = $row[3];
                $email = $row[4];

                $existingUser = User::where('username', $username)
                    ->orWhere('email', $email)
                    ->first();

                if ($existingUser) {
                    Log::info("Duplicate user skipped: Username - $username, Email - $email");
                    continue;
                }

                $existingStudent = Student::where('user_id', $existingUser?->id)
                    ->first();

                if ($existingStudent) {
                    Log::info("Duplicate student skipped: User ID - {$existingUser->id}");
                    continue;
                }

                $role = Role::where('name', RoleType::Student);

                $user = User::create([
                    'username' => $username,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'password' => bcrypt('defaultPassword123'),
                    'role_id' => $role->id,
                ]);

                Student::create([
                    'user_id' => $user->id,
                    'department_id' => $row[5] ?? null,
                    'study_plan_id' => $row[6] ?? null,
                    'group_id' => $row[7] ?? null,
                    'sub_group_id' => $row[8] ?? null,
                ]);

                Log::info("New student created: Username - $username, Email - $email");
            }
        });
    }
}
