<?php

namespace App\Http\Controllers;

use App\Models\Records;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RecordController extends Controller
{
    public function getRecord()
    {
        $records = Records::where('is_active', true)
            ->where('file_path', 'LIKE', '%.pdf') 
            ->select('id', 'record_type', 'record_name', 'document_name', 'file_path', 'created_at')
            ->get();
    
        return response()->json($records);
    }

    public function uploadRecord(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'file' => 'required|file|mimes:pdf|max:10240',
                'record_type' => 'required|string',
                'record_name' => 'required|string',
                'document_name' => 'required|string',
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
                    $path = 'uploads/record/record_type/' . $request->input('record_type') . '/' . $filename . '.pdf';
                } else {
                    $path = 'uploads/record/record_type/' . $request->input('record_type') . '/' . $originalFileName;
                }

                $path = $file->storeAs($path, $filename, 'public');
                $url = URL::to('/') . '/storage/' . $path;
            }

            $record = new Records();
            $record->record_type = $request->input('record_type');
            $record->file_path = $url;
            $record->record_name = $request->input('record_name');
            $record->document_name = $request->input('document_name');
            $record->is_active = true;
            $record->save();

            return response()->json(['message' => 'Procedure uploaded successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }
}
