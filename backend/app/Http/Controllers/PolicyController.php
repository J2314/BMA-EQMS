<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policies;
use Illuminate\Support\Facades\URL;

class PolicyController extends Controller
{
    public function getPolicies()
    {
        $policies = Policies::where('is_active', true)->select('id', 'document_type', 'document_name', 'file_path')->get();

        return response()->json($policies);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt,doc,docx,pdf|max:10240'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (!$file->isValid()) {
                return response()->json(['error' => 'The uploaded file is invalid.'], 422);
            }

            $filename = uniqid() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('uploads', $filename, 'public');

            $url = URL::to('/') . '/storage/' . $path;

            $policy = new Policies();
            $policy->file_path = $url;
            $policy->document_type = $request->input('document_type');
            $policy->document_name = $request->input('document_name');
            $policy->is_active = true;
            $policy->save();

            return response()->json(['message' => 'File uploaded successfully'], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 422);
    }
}
