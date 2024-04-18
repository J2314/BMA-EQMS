<?php

namespace App\Http\Controllers;

use App\Models\Procedures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ProcedureController extends Controller
{
    public function getProcedure()
    {
        $procedures = Procedures::where('is_active', true)->select('id', 'document_type', 'department', 'document_name', 'file_path')->get();

        return response()->json($procedures);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt,doc,docx,pdf|max:10240',
            'department_id' => 'required|numeric|exists:departments,id'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (!$file->isValid()) {
                return response()->json(['error' => 'The uploaded file is invalid.'], 422);
            }

            $filename = uniqid() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('uploads', $filename, 'public');

            $url = URL::to('/') . '/storage/' . $path;

            $procedure = new Procedures();
            $procedure->file_path = $url;
            $procedure->document_type = $request->input('document_type');
            $procedure->department = $request->input('department');
            $procedure->document_name = $request->input('document_name');
            $procedure->is_active = true;
            $procedure->save();

            return response()->json(['message' => 'File uploaded successfully'], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 422);
    }
}
