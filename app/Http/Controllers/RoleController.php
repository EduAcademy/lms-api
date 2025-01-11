<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\RoleServiceInterface;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //

    protected $roles_service;
    public function __construct(RoleServiceInterface $RoleService)
    {
        $this->roles_service = $RoleService;
    }

    public function index()
    {
        $result = $this->roles_service->getAllRoles();
        return Result::success($result, 'Get all roles', StatusResponse::HTTP_OK);
    }
}
