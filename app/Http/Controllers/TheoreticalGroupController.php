<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\TheoreticalGroupServiceInterface;
use Illuminate\Http\Request;

class TheoreticalGroupController extends Controller
{
    //

    protected $theo_groupService;
    public function __construct(TheoreticalGroupServiceInterface $theoreticalGroupService)
    {
        $this->theo_groupService = $theoreticalGroupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->theo_groupService->getAllTheoGroups();
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
        $result = $this->theo_groupService->createTheoGroup($request->all());
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->theo_groupService->getTheoGroupById($id);
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $result = $this->theo_groupService->updateLabGroup($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $result = $this->theo_groupService->deleteLabGroup($id);
        return $result;
    }
}
