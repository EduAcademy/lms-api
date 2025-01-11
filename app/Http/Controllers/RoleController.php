<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\RoleServiceInterface;
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
        return $this->roles_service->getAllRoles();
    }
}
