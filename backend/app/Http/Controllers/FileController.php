<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Adjust max file size as needed
        ]);

        // Store the file
        $uploadedFile = $request->file('file');
        $fileName = $uploadedFile->getClientOriginalName(); // You can customize the file name if needed
        $uploadedFile->storeAs('uploads', $fileName); // Store the file in the storage/app/uploads directory

        // Save file information to the database
        $submittedFile = new SubmittedFile();
        $submittedFile->name = $fileName;
        $submittedFile->uploaded_by = auth()->user()->name; // Assuming you have authentication set up
        $submittedFile->save();

        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function submittedFiles()
    {
        // Fetch submitted files from the database
        $files = SubmittedFile::all();

        return response()->json($files);
    }
}