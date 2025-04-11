<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Interfaces\Services\GroupServiceInterface;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    //

    protected $groupService;
    public function __construct(GroupServiceInterface $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = $this->groupService->getAllGroups();
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
    public function store(GroupRequest $request)
    {
        //
        $data = $request->validated();
        $result = $this->groupService->createGroup($data);
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $result = $this->groupService->getGroupById($id);
        return $result;
    }

    public function showByName($name)
    {
        $result = $this->groupService->getGroupByName($name);
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
        $result = $this->groupService->updateGroup($id, $request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $result = $this->groupService->deleteGroup($id);
        return $result;
    }
}
