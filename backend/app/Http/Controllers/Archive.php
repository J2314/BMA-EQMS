<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Forms;

class Archive extends Controller
{    
    public function archiveDepartment($id)
    {
        try {
            $department = Department::find($id);
            
            if (!$department) {
                return response()->json(['error' => 'Department with ID ' . $id . ' not found'], 404);
            }
    
            $department->is_Active = false; 
            $department->save();
    
            return response()->json(['message' => 'Department archived successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error archiving department: ' . $e->getMessage()], 500);
        }
    }

    public function archiveForms($id)
    {
        try {
            $forms = Forms::find($id);
            
            if (!$forms) {
                return response()->json(['error' => 'Forms with ID ' . $id . ' not found'], 404);
            }
    
            $forms->is_removed = true; 
            $forms->save();
    
            return response()->json(['message' => 'Forms archived successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error archiving department: ' . $e->getMessage()], 500);
        }
    }
    
}
