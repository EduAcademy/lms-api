<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    GroupController,
    LevelController,
    StatsController,
    StudentController,
    SubGroupController,
    StudyPlanController,
    AssignmentController,
    NotificationController,
    CourseMaterialController,
    StudyPlanCourseController,
    StudyPlanCourseInstructorController,
    StudyPlanCourseInstructorSubGroupController
};
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Instructor\InstructorController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->middleware('customThrottle:3,1');
    Route::post('/validate-token', [AuthController::class, 'validateToken']);
    Route::post('/register', [AuthController::class, 'register']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        // Authentication
        Route::prefix('auth')->group(function () {
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/update-profile', [AuthController::class, 'updateProfile']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
            Route::post('/reset-password', [AuthController::class, 'resetPassword']);
            Route::patch('/activate/{id}', [AuthController::class, 'activateUser']);
            Route::patch('/deactivate/{id}', [AuthController::class, 'deactivateUser']);
        });

        // User management
        Route::prefix('users')->group(function () {
            Route::get('/', [AuthController::class, 'index']);
            Route::get('/{id}', [AuthController::class, 'show']);
            Route::patch('/{id}', [AuthController::class, 'patch']);
            Route::delete('/{id}', [AuthController::class, 'delete']);
        });

        Route::get('roles', [RoleController::class, 'index']);

        // Upload routes
        Route::post('/upload-students', [StudentController::class, 'uploadStudent']);
        Route::post('/upload-depts', [DepartmentController::class, 'createDepartment']);

        // API resources
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('instructors', InstructorController::class);
        Route::apiResource('students', StudentController::class);
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('study_plans', StudyPlanController::class);
        Route::apiResource('groups', GroupController::class);
        Route::apiResource('levels', LevelController::class)->only(['index', 'store']);
        Route::apiResource('sub_groups', SubGroupController::class);
        Route::apiResource('course_materials', CourseMaterialController::class);
        Route::apiResource('study_plan_courses', StudyPlanCourseController::class);
        Route::apiResource('spc_instructors', StudyPlanCourseInstructorController::class);
        Route::apiResource('spci_subgroups', StudyPlanCourseInstructorSubGroupController::class);
        Route::apiResource('assignment', AssignmentController::class);

        // Extra Department routes
        Route::get('/departments/levels/{departmentId}', [DepartmentController::class, 'getLevels']);

        // Extra Course routes
        Route::get('/courses/department/{departmentId}', [CourseController::class, 'showbyDepartment']);

        // Extra Study Plan routes
        Route::get('/study_plans/department/{departmentId}', [StudyPlanController::class, 'showbyDepartment']);
        Route::get('/study_plans/course/{courseId}', [StudyPlanController::class, 'showbyCourse']);

        // Extra Group routes
        Route::get('/groups/group/{name}', [GroupController::class, 'showByName']);

        // Extra Sub Group routes
        Route::get('/sub_groups/sub_group/{name}', [SubGroupController::class, 'showByName']);
        Route::get('/sub_groups/group/{id}', [SubGroupController::class, 'showByGroupId']);

        // Extra Level routes
        Route::get('/levels/{levelId}', [LevelController::class, 'getAllGroupsByLevel']);

        // StudyPlanCourse extra filters
        Route::get('/study_plan_courses/semester/{levelId}', [StudyPlanCourseController::class, 'getSemesterByLevelId']);
        Route::get('/study_plan_courses/course/{department_id}/{level_id}/{semester}', [StudyPlanCourseController::class, 'getCoursBySemesterId']);
        Route::get('/study_plan_courses/group/{department_id}/{level_id}/{semesterId}/{courseid}', [StudyPlanCourseController::class, 'getGroupByCourseid']);
        Route::get('/study_plan_courses/subgroup/{department_id}/{level_id}/{semesterId}/{courseid}/{groupid}', [StudyPlanCourseController::class, 'getSubGroupByGroupid']);

        Route::get('/study_plan_courses/getCourseInstructor/{department_id}/{level_id}/{semesterId}/{instructorId}', [StudyPlanCourseController::class, 'getCourseByInstructorId']);

        // assignment

        Route::get('/assignment/instructor/{instructorId}', [AssignmentController::class, 'getbyInstructorId']);
        Route::get('/assignment/group/{groupId}', [AssignmentController::class, 'getbyGroupId']);

        // Notification routes
        Route::prefix('notifications')->group(function () {
            Route::post('/all', [NotificationController::class, 'notifyAllStudents']);
            Route::post('/department', [NotificationController::class, 'notifyDepartment']);
            Route::post('/group', [NotificationController::class, 'notifyGroup']);
            Route::post('/student', [NotificationController::class, 'notifyStudent']);
        });



        // Stats
        Route::prefix('stats')->group(function () {
            Route::get('/', StatsController::class);
        });
    });
});
