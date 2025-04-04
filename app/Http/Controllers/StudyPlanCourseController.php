<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\StudyPlanCourseServiceInterface;
use App\Http\Requests\StudyPlanCourseRequest;
use Database\Seeders\StudyPlanSeeder;
use Illuminate\Http\Request;

class StudyPlanCourseController extends Controller
{
    //
    protected $spCourseService;
    public function __construct(StudyPlanCourseServiceInterface $spCourseService)
    {
        $this->spCourseService = $spCourseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->spCourseService->getAllStudyPlanCourses();

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudyPlanCourseRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->spCourseService->createStudyPlanCourse($data);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->spCourseService->getStudyPlanCourseById($id);

        return $result;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->spCourseService->updateStudyPlanCourse($id, $request->all());

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->spCourseService->deleteStudyPlanCourse($id);

        return $result;
    }
    public function getSemesterByLevelId($levelId)
    {
        //
        $result = $this->spCourseService->getSemesterByLevelId($levelId);

        return $result;
    }
    public function getCoursBySemesterId($department_id, $level_id, $semester = 0)
    {
        //
        $result = $this->spCourseService->getCoursBySemesterId($department_id, $level_id, $semester);

        return $result;
    }
    public function getGroupByCourseid($department_id, $level_id, $semesterId, $courseid)
    {
        //
        $result = $this->spCourseService->getGroupByCourseid($department_id, $level_id, $semesterId, $courseid);

        return $result;
    }
    public function getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid)
    {
        //
        $result = $this->spCourseService->getSubGroupByGroupid($department_id, $level_id, $semesterId, $courseid, $groupid);

        return $result;
    }
    public function getCourseByInstructorId($department_id, $level_id, $semester, $instructorId)
    {
        //
        $result = $this->spCourseService->getCourseByInstructorId($department_id, $level_id, $semester, $instructorId);

        return $result;
    }
}
