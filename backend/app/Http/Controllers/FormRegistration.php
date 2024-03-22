<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forms;

class FormRegistration extends Controller
{
    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'file_name' => 'required|string',
            'file_code' => 'required|string',
            'description' => 'required|string',
            'department_id' => 'required|numeric|exists:departments,id',
        ]);
    
        $existingForm = Forms::where('file_name', $validatedData['file_name'])
                              ->orWhere('file_code', $validatedData['file_code'])
                              ->first();
    
        if ($existingForm) {
            return response()->json(['message' => 'A form with the same file name or file code already exists'], 400);
        }
    
        $formData = new Forms();
        $formData->file_name = $validatedData['file_name'];
        $formData->file_code = $validatedData['file_code'];
        $formData->description = $validatedData['description'];
        $formData->department_id = $validatedData['department_id'];
        $formData->is_removed = false; 
        $formData->save();
        
        return response()->json(['message' => 'Form submitted successfully'], 201);
    }
    
}

