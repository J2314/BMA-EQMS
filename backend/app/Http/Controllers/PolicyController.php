<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policies;
use Illuminate\Support\Facades\Storage;

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
        $validateData = $request->validate([
            'file' => 'required|file|mimes:txt,doc,docx,pdf|max:10240',
            'department_id' => 'required|numeric|exists:departments,id',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (!$file->isValid()) {
                return response()->json(['error' => 'The uploaded file is invalid.'], 422);
            }

            $filename = uniqid() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('uploads', $filename, 'public');

            $url = Storage::url($path);

            $existingPolicy = Policies::where('file_name', $file->getClientOriginalName())
                ->orWhere('file_code', $request['file_code'])
                ->first();

            if ($existingPolicy) {
                return response()->json(['error' => 'A policy with the same file name or file code already exists.'], 422);
            }

            $policy = new Policies();
            $policy->file_name = $file->getClientOriginalName(); 
            $policy->file_path = $url;
            $policy->document_type = $request->input('document_type');
            $policy->department_id = $request->input('department_id');
            $policy->is_active = true;
            $policy->save();

            return response()->json(['message' => 'File uploaded successfully'], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 422);
    }
}
