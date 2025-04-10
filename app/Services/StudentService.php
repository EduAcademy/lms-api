<?php

namespace App\Services;

use App\Contracts\StudentRepositoryInterface;
use App\DTOs\StudentDTO;
use App\Http\Requests\StudentRequest;
use App\Interfaces\Services\StudentServiceInterface;
use App\Mappings\StudentMapping;
use App\Models\Student;
use App\Models\User;
use App\Repositories\GenericRepository;
use App\Shared\Constants\MessageResponse;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\UploadedFiles;

class StudentService implements StudentServiceInterface
{
    private $studentRepository;
    private $genericRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->genericRepository = new GenericRepository(new Student);
    }

    public function getAllStudents()
    {
        try {
            // Eager load related models with only necessary attributes
            $result = Student::with([
                'user',
                'department' => function ($query) {
                    $query->select('id', 'name');
                },
                'study_plan' => function ($query) {
                    $query->select('id', 'name');
                },
                'group' => function ($query) {
                    $query->select('id', 'name');
                },
                'sub_group' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
                ->whereHas('user', function ($query) {
                    $query->where('role_id', 3);
                })
                ->get();

            return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error in StudentService::getAllStudents: ' . $e->getMessage());
            return Result::error('An error occurred while fetching students', StatusResponse::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function getStudentById($id)
    {
        $student = $this->studentRepository->findById($id);

        if (!$student) {
            return Result::error(MessageResponse::RESOURCE_NOT_FOUND, StatusResponse::HTTP_NOT_FOUND);
        }

        // Eager load related models with only the necessary fields.
        $student->load([
            'user',
            'department' => function ($query) {
                $query->select('id', 'name');
            },
            'study_plan' => function ($query) {
                $query->select('id', 'name');
            },
            'group' => function ($query) {
                $query->select('id', 'name');
            },
            'sub_group' => function ($query) {
                $query->select('id', 'name');
            }
        ]);

        $studentData = StudentMapping::toStudent($student);
        $result = StudentDTO::fromArray($studentData);

        return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }

    public function createStudent(array $data)
    {
        $validator = Validator::make($data, (new StudentRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        try {
            // Create a user first
            $userData = [
                'username'   => $data['username'],
                'email'      => $data['email'],
                'password'   => bcrypt($data['password']),
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'phone'      => $data['phone'],
                'role_id'    => 3, // Assuming 3 is the role ID for students
                'gender'     => $data['gender'],
                'is_active'  => true,
            ];

            $user = User::create($userData);

            // Add the created user's ID to the student data
            $data['user_id'] = $user->id;

            // Create the student record
            $result = $this->genericRepository->create($data);

            if (!$result) {
                return Result::error('Failed in creating Student', StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return Result::success($result, 'Student is Created Successfully', StatusResponse::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Error in StudentService::createStudent: ' . $e->getMessage());
            return Result::error('An error occurred while creating the student', StatusResponse::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function updateStudent($id, array $data)
    {
        $validator = Validator::make($data, [
            'uuid'           => 'required|string|unique:students,uuid,' . $id,
            'department_id'  => 'required|exists:departments,id',
            'study_plan_id'  => 'required|exists:study_plans,id',
            'user_id'        => 'required|exists:users,id',
            'group_id'       => 'required|exists:groups,id',
            'sub_group_id'   => 'required|exists:sub_groups,id',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $updatedStudent = $this->genericRepository->update($id, $data);

        if (!$updatedStudent) {
            return Result::error('Failed to update student', StatusResponse::HTTP_BAD_REQUEST);
        }

        return Result::success($updatedStudent, 'Student Updated Successfully', StatusResponse::HTTP_OK);
    }

    public function getStudentsByDepartment($departmentId)
    {
        $students = $this->studentRepository->findByDepartmentId($departmentId);

        if ($students->isEmpty()) {
            return Result::error('No students found for the given department', StatusResponse::HTTP_NOT_FOUND);
        }

        $students->load([
            'user',
            'department' => function ($query) {
                $query->select('id', 'name');
            },
            'study_plan' => function ($query) {
                $query->select('id', 'name');
            },
            'group' => function ($query) {
                $query->select('id', 'name');
            },
            'sub_group' => function ($query) {
                $query->select('id', 'name');
            }
        ]);

        return Result::success($students, 'Students found Successfully by department', StatusResponse::HTTP_OK);
    }

    public function getStudentsByGroup($groupId)
    {
        $students = $this->studentRepository->findByGroupId($groupId);

        if ($students->isEmpty()) {
            return Result::error('No students found for the given group', StatusResponse::HTTP_NOT_FOUND);
        }
        return Result::success($students, 'Students found Successfully by Group', StatusResponse::HTTP_OK);
    }

    public function getStudentsBySubGroupId($subgroupId)
    {
        $students = $this->studentRepository->getStudentsBySubGroupId($subgroupId);

        if ($students->isEmpty()) {
            return Result::error('No students found for the given group', StatusResponse::HTTP_NOT_FOUND);
        }
        return Result::success($students, 'Students found Successfully by Group', StatusResponse::HTTP_OK);
    }

    public function count(): int
    {
        return $this->studentRepository->count();
    }

    public function findByUserId($userId)
    {
        $students = $this->studentRepository->findByUserId($userId);

        if ($students->isEmpty()) {
            return Result::error('No students found for the given user', StatusResponse::HTTP_NOT_FOUND);
        }
        return Result::success($students, 'Students found Successfully by user', StatusResponse::HTTP_OK);
    }

    public function uploadAndImportStudents($file)
    {
        $filePath = $file->getRealPath();
        $fileHash = hash_file('sha256', $filePath);
        $fileSize = $file->getSize();
        $lastModified = Carbon::createFromTimestamp($file->getMTime())->toDateTimeString();
        $fileName = $file->getClientOriginalName();

        // Check if the file was already uploaded
        $existingFile = UploadedFiles::where('file_hash', $fileHash)
            ->orWhere(function ($query) use ($fileName, $fileSize, $lastModified) {
                $query->where('file_name', $fileName)
                    ->where('file_size', $fileSize)
                    ->where('last_modified', $lastModified);
            })
            ->first();

        if ($existingFile) {
            return Result::error('This file has already been uploaded and processed.', 400);
        }

        // Store file metadata
        UploadedFiles::create([
            'file_name'     => $fileName,
            'file_hash'     => $fileHash,
            'file_size'     => $fileSize,
            'last_modified' => $lastModified,
        ]);

        try {
            $data = Excel::toArray(new \App\Imports\StudentImport, $file)[0];
            // remove header row
            unset($data[0]);

            foreach ($data as $row) {
                // Map Excel row columns to studentData structure expected by createStudent.
                $studentData = [
                    'department_id' => $row[0],
                    'study_plan_id' => $row[1],
                    // Note: Omit 'user_id' here so that createStudent creates a new user.
                    'group_id'      => $row[2],
                    'sub_group_id'  => $row[3],
                    'username'      => $row[4],
                    'email'         => $row[5],
                    'password'      => $row[6],
                    'first_name'    => $row[7],
                    'last_name'     => $row[8],
                    'phone'         => $row[9],
                    'gender'        => $row[10]
                ];

                $result = $this->createStudent($studentData);
                if ($result instanceof \App\Shared\Handler\Result && $result->isError()) {
                    throw new \Exception('Failed to create student for row: ' . json_encode($row) . ' Errors: ' . $result->getMessage());
                }
            }
        } catch (\Exception $e) {
            return Result::error('Error processing file: ' . $e->getMessage(), 500);
        }

        return Result::success(
            ['message' => 'File uploaded and processed successfully.'],
            'File uploaded and processed successfully.',
            200
        );
    }
}
