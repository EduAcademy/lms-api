<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\CourseMaterialServiceInterface;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{

    protected $course_materialService;
    public function __construct(CourseMaterialServiceInterface $courseMaterialService)
    {
        $this->course_materialService = $courseMaterialService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->course_materialService->getAllCourseMaterials();

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
    public function store(Request $request)
    {
        //

        $result = $this->course_materialService->createCourseMaterial($request->all());

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->course_materialService->getCourseMaterialById($id);

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseMaterial $courseMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->course_materialService->updateCourseMaterial($id, $request->all());

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $result = $this->course_materialService->deleteCourseMaterial($id);

        return $result;
    }
}
