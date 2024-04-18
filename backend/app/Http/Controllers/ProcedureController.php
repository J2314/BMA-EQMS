<?php

namespace App\Http\Controllers;

use App\Models\Procedures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\QueryException;

class ProcedureController extends Controller
{
    public function getProcedure()
    {
        $procedures = Procedures::where('is_active', true)->select('id', 'document_type', 'department_id', 'document_name', 'file_path')->get();

        return response()->json($procedures);
    }

    public function uploadProcedure(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'file' => 'nullable|file|mimes:txt,doc,docx,pdf|max:10240',
                'file_path' => 'nullable|string',
                'document_name' => 'required|string',
                'department_id' => 'required|numeric|exists:departments,id',
            ]);
    
            $url = null;
    
            if ($request->hasFile('file')) {
                $file = $request->file('file');
    
                if (!$file->isValid()) {
                    return response()->json(['error' => 'The uploaded file is invalid.'], 422);
                }
    
                $filename = uniqid() . '_' . $file->getClientOriginalName();
    
                $path = $file->storeAs('uploads', $filename, 'public');
    
                $url = URL::to('/') . '/storage/' . $path;
            } elseif ($request->filled('file_path')) {
                $url = $request->input('file_path');
            } else {
                return response()->json(['error' => 'Either a file or file path is required.'], 422);
            }
    
            $procedure = new Procedures();
            $procedure->file_path = $url;
            $procedure->document_type = $request->input('document_type');
            $procedure->department_id = $request->input('department_id');
            $procedure->document_name = $request->input('document_name');
            $procedure->is_active = true;
            $procedure->save();
    
            return response()->json(['message' => 'Procedure uploaded successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }
}
