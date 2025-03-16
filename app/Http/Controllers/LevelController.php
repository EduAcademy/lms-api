<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
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

    public function store(LevelRequest $request)
    {

        $data = $request->validated();
        $result = Level::create($data);
        return Result::success($result, MessageResponse::CREATED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }
}
