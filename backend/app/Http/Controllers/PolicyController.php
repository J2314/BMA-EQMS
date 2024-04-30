<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policies;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
use PhpOffice\PhpWord\IOFactory;

class PolicyController extends Controller
{
    public function getPolicies()
    {
        $policies = Policies::where('is_active', true)
            ->where('file_path', 'LIKE', '%.pdf')
            ->select('id', 'document_type', 'department_id', 'document_name', 'file_path', 'created_at')
            ->get();

        return response()->json($policies);
    }

    public function uploadPolicy(Request $request)
    {
        try {
            $validateData = $request->validate([
                'file' => 'nullable|file|mimes:txt,doc,docx,pdf|max:10240',
                'document_name' => 'required|string',
                'document_type' => 'required|string',
            ]);

            $originalFileName = $request->file('file')->getClientOriginalName();
            $filename = $originalFileName;
            $isConverted = false;

            if (
                $request->file('file')->getClientOriginalExtension() === 'doc' ||
                $request->file('file')->getClientOriginalExtension() === 'docx'
            ) {
                $convertedPath = $this->convertToPdf($request->file('file'), $request->input('document_type'));
                $request->merge(['file' => $convertedPath]);

                $filename = pathinfo($convertedPath, PATHINFO_FILENAME);
                $isConverted = true;
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                if ($file->getSize() === 0) {
                    return response()->json(['error' => 'The uploaded file is empty.'], 422);
                }

                if ($isConverted) {
                    $path = 'uploads/policies/document_type/' . $request->input('document_type') . '/' . $filename . '.pdf';
                } else {
                    $path = 'uploads/policies/document_type/' . $request->input('document_type') . '/' . $originalFileName;
                }

                Storage::disk('public')->put($path, fopen($file, 'r+'));
                $url = URL::to('/') . '/storage/' . $path;

                $policy = new Policies();
                $policy->document_name = $request->input('document_name');
                $policy->file_path = $url;
                $policy->document_type = $request->input('document_type');
                $policy->department_id = $request->input('department_id'); 
                $policy->is_active = true;
                $policy->save();
            }

            return response()->json(['message' => 'Policy uploaded successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    // private function convertToPdf($file, $documentType)
    // {
    //     $pdfPath = 'uploads/document_type/' . $documentType . '/' . time() . '_' . $file->getClientOriginalName() . '.pdf';

    //     $phpWord = IOFactory::load($file->getPathname());
    //     $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
    //     $pdfWriter->save($pdfPath);

    //     return $pdfPath;
    // }
}
