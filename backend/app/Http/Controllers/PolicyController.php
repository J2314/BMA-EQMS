<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policies;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class PolicyController extends Controller
{
    public function getPolicies()
    {
        $policies = Policies::where('is_active', true)
            ->select('id', 'document_type', 'department_id', 'document_name', 'file_path')
            ->get();

        return response()->json($policies);
    }

    public function uploadPolicy(Request $request)
    {
        try {
            $validateData = $request->validate([
                'file' => 'nullable|file|mimes:txt,doc,docx,pdf|max:10240',
                'file_path' => 'nullable|string',
                'document_name' => 'required|string',
                'department_id' => 'required|numeric|exists:departments,id',
            ]);
    
            $filename = null;
            $url = null;
    
            if ($request->hasFile('file')) {
                $file = $request->file('file');
    
                if (!$file->isValid()) {
                    return response()->json(['error' => 'The uploaded file is invalid.'], 422);
                }
    
                $filename = uniqid() . '_' . $file->getClientOriginalName();
    
                $path = $file->storeAs('uploads', $filename, 'public');
    
                $url = Storage::url($path);
            } elseif ($request->filled('file_path')) {
                $url = $request->input('file_path');
            } else {
                return response()->json(['error' => 'Either a file or file path is required.'], 422);
            }
    
            $existingPolicy = Policies::where('department_id', $request->input('department_id'))
                ->where('document_name', $request->input('document_name'))
                ->first();
    
            if ($existingPolicy) {
                return response()->json(['error' => 'A policy with the same document name already exists.'], 422);
            }
    
            $policy = new Policies();
            $policy->document_name = $request->input('document_name');
            $policy->file_path = $url;
            $policy->document_type = $request->input('document_type');
            $policy->department_id = $request->input('department_id');
            $policy->is_active = true;
            $policy->save();
    
            return response()->json(['message' => 'Policy uploaded successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }
}
