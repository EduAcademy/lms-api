<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Interfaces\Services\CourseServiceInterface;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $course_service;
    public function __construct(CourseServiceInterface $courseService)
    {
        $this->course_service = $courseService;
    }

    public function index()
    {
        //
        $result = $this->course_service->getAllCourses();

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->course_service->createCourse($data);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->course_service->getCourseById($id);

        return $result;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {

        $result = $this->course_service->updateCourse($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        //
        $result = $this->course_service->deleteCourse($id);
        return $result;

    }
}
