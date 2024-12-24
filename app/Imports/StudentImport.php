<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


class StudentImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Skip header row
            if ($index === 0) {
                continue;
            }

            // Ensure the required fields are present
            if (!isset($row[1], $row[2])) {
                Log::warning("Row skipped due to missing fields: " . json_encode($row));
                continue;
            }

            // Check for duplicates
            $existingDepartment = Student::where('name', $row[1])->first();
            if ($existingDepartment) {
                Log::info("Duplicate student skipped: " . $row[1]);
                continue;
            }

            // Create new student
            // Student::create([
            //     'id' => $row[0],
            //     'name' => $row[1],
            //     'short_name' => $row[2],
            //     'description' => $row[3],
            // ]);
        }
    }
}
