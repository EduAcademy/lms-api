<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return Department::all();
    }
    public function createDepartment(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'shortName' => 'required','max:5',
            'description' => 'required|string|min:3|max:255',
        ]);
        $department = Department::create($data);
        return response()->json($department, 201); // Return the created department
    }
}