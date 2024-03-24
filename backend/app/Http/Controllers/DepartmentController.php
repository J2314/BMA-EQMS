<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function addDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
        ]);
        
        $existingDepartment = Department::where('name', $validatedData['name'])
            ->orWhere('code', $validatedData['code'])
            ->first();

        if ($existingDepartment) {
            return response()->json(['message' => 'Department with the same name or code already exists'], 400);
        }

        try {
            $department = new Department();

            $department->name = $validatedData['name'];
            $department->code = $validatedData['code']; 
            $department->is_Active = true; 

            $department->save();

            return response()->json(['message' => 'Department added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add department'], 500);
        }
    }

    public function getDepartments()
    {
        $departments = Department::where('is_Active', true)->get();
        
        return response()->json($departments);
    }
}
