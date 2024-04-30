<?php

namespace App\Http\Controllers;

use App\Models\WorkInstructions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\QueryException;

class WorkInstructionsController extends Controller
{
    public function getWork()
    {
        $work = WorkInstructions::where('is_active', true)
            ->where('file_path', 'LIKE', '%.pdf') 
            ->select('id', 'document_type', 'employee_name', 'document_name', 'file_path', 'created_at')
            ->get();
    
        return response()->json($work);
    }

    public function uploadWorkInstructions(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'file' => 'required|file|mimes:pdf|max:10240',
                'document_name' => 'required|string',
                'document_type' => 'required|string',
                'employee_name' => 'required|string',
            ]);

            $url = null;
            $isConverted = false;

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                if (!$file->isValid()) {
                    return response()->json(['error' => 'The uploaded file is invalid.'], 422);
                }

                $originalFileName = $file->getClientOriginalName();
                $filename = $originalFileName;

                if (
                    $file->getClientOriginalExtension() === 'doc' ||
                    $file->getClientOriginalExtension() === 'docx'
                ) {
                    $convertedPath = $this->convertToPdf($file, $request->input('document_type'));
                    $file = $convertedPath;

                    $filename = pathinfo($convertedPath, PATHINFO_FILENAME);
                    $isConverted = true;
                }

                if ($isConverted) {
                    $path = 'uploads/workinstructions/document_type/' . $request->input('document_type') . '/' . $filename . '.pdf';
                } else {
                    $path = 'uploads/workinstructions/document_type/' . $request->input('document_type') . '/' . $originalFileName;
                }

                $path = $file->storeAs($path, $filename, 'public');
                $url = URL::to('/') . '/storage/' . $path;
            }

            $workins = new WorkInstructions();
            $workins->document_name = $request->input('document_name');
            $workins->file_path = $url;
            $workins->document_type = $request->input('document_type');
            $workins->employee_name = $request->input('employee_name');
            $workins->is_active = true;
            $workins->save();

            return response()->json(['message' => 'Procedure uploaded successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }
}
