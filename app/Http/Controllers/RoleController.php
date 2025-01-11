<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\RoleServiceInterface;
use App\Http\Requests\LabGroupRequest;
use Illuminate\Http\Request;

class LabGroupController extends Controller
{
    //

    protected $roles_service;
    public function __construct(RoleServiceInterface $RoleService)
    {
        $this->roles_service = $RoleService;
    }

    public function index()
    {
        return $this->roles_service->getAllRoles();
    }
}
