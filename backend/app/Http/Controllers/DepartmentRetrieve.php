<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentRetrieve extends Controller
{
    public function getDepartments()
    {
        $departments = Department::where('is_Active', true)->get();
        
        return response()->json($departments);
    }
}
