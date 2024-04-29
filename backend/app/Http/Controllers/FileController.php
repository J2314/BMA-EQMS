<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\FormFiles;
use App\Models\Forms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PhpOffice\PhpWord\IOFactory;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:doc,docx,pdf|max:10240',
            'form_id' => 'required|string|max:255',
        ]);

        $form = Forms::findOrFail($request->input('form_id'));
        $departmentId = $form->department_id;
        $departmentName = Department::findOrFail($departmentId)->name;

        $originalFileName = $request->file('file')->getClientOriginalName();
        $filename = $originalFileName;
        $isConverted = false;

        if (
            $request->file('file')->getClientOriginalExtension() === 'doc' ||
            $request->file('file')->getClientOriginalExtension() === 'docx'
        ) {
            $convertedPath = $this->convertToPdf($request->file('file'), $departmentName);
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
                $path = 'uploads/departments/' . $departmentName . '/' . $filename . '.pdf';
            } else {
                $path = 'uploads/departments/' . $departmentName . '/' . $originalFileName;
            }

            Storage::disk('public')->put($path, fopen($request->file('file'), 'r+'));
            $path = URL::to('/') . '/storage/' . $path;

            $fileRecord = new FormFiles();
            $fileRecord->form_id = $request->input('form_id');
            $fileRecord->file_path = $path;
            $fileRecord->is_active = true;
            $fileRecord->save();

            return response()->json([
                'message' => 'File uploaded successfully',
                'file_id' => $fileRecord->id,
                'is_converted' => $isConverted,
                'original_filename' => $originalFileName,
                'converted_filename' => $filename,
            ]);
        }

        return response()->json(['error' => 'File upload failed'], 422);
    }

    private function convertToPdf($file, $departmentName)
    {
        $pdfPath = 'uploads/departments/' . $departmentName . '/' . time() . '_' . $file->getClientOriginalName() . '.pdf';

        $phpWord = IOFactory::load($file->getPathname());
        $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
        $pdfWriter->save($pdfPath);

        return $pdfPath;
    }

    public function retrieveUploads($formId)
    {
        $uploads = FormFiles::where('form_id', $formId)
            ->where('file_path', 'LIKE', '%.pdf')
            ->select('id', 'form_id', 'file_path', 'created_at')
            ->get();

        return response()->json($uploads);
    }
}
