<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use App\Models\Groups;
use App\Models\Level;
use App\Shared\Constants\MessageResponse;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //

    public function index()
    {
        $result = Level::all();

        return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }

    public function getAllGroupsByLevel($levelId)
    {
        $groups = Groups::select('groups.*')
            ->join('spc_instructors', 'groups.id', '=', 'spc_instructors.group_id')
            ->join('study_plan_courses', 'spc_instructors.study_plan_course_id', '=', 'study_plan_courses.id')
            ->where('study_plan_courses.level_id', $levelId)
            ->distinct()
            ->get();
        return Result::success($groups, MessageResponse::FETCHED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }

    public function store(LevelRequest $request)
    {

        $data = $request->validated();
        $result = Level::create($data);
        return Result::success($result, MessageResponse::CREATED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }
}
