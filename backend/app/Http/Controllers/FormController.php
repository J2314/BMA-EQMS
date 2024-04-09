<?php

namespace App\Http\Controllers;

use App\Models\FormDownloading;
use App\Models\FormFiles;
use Illuminate\Http\Request;
use App\Models\Forms;
use App\Models\FormViewing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'file_name' => 'required|string',
            'file_code' => 'required|string',
            'description' => 'required|string',
            'department_id' => 'required|numeric|exists:departments,id',
        ]);

        $existingForm = Forms::where('file_name', $validatedData['file_name'])
            ->orWhere('file_code', $validatedData['file_code'])
            ->first();

        if ($existingForm) {
            return response()->json(['message' => 'A form with the same file name or file code already exists'], 400);
        }

        $formData = new Forms();
        $formData->file_name = $validatedData['file_name'];
        $formData->file_code = $validatedData['file_code'];
        $formData->description = $validatedData['description'];
        $formData->department_id = $validatedData['department_id'];
        $formData->is_removed = false;
        $formData->save();

        return response()->json(['message' => 'Form submitted successfully'], 201);
    }

    public function getForms()
    {
        $forms = Forms::where('is_removed', false)->with('department')->get();

        return response()->json($forms);
    }

    function retrieve_forms($data)
    {
        $form = Forms::with('department')->with('form_files')->find($data);
        return response(compact('form'), 200);
    }

    public function incrementViewCount(Request $request)
    {
        try {
            if (Auth::guard('sanctum')->check()) {
                $user = Auth::guard('sanctum')->user();
                $userId = $user->id;
                $formId = $request->input('form_id');

                if (!$formId) {
                    return response()->json(['error' => 'Form ID is required'], 400);
                }

                $formFiles = FormFiles::where('form_id', $formId)->first();

                if (!$formFiles) {
                    return response()->json(['error' => 'Form Files not found'], 404);
                }

                $formViewing = new FormViewing();
                $formViewing->user_id = $userId;
                $formViewing->form_id = $formId;
                $formViewing->form_files_id = $formFiles->id;
                $formViewing->save();

                $formViewing->load('form');

                return response()->json([
                    'message' => 'Form viewing recorded successfully',
                    'form_viewing' => $formViewing,
                ], 200);
            } else {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Failed to record form view', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
    }

    public function incrementDownloadCount(Request $request)
{
    try {
        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            $userId = $user->id;
            $formId = $request->input('form_id');

            if (!$formId) {
                return response()->json(['error' => 'Form ID is required'], 400);
            }

            $formFiles = FormFiles::where('form_id', $formId)->first();

            if (!$formFiles) {
                return response()->json(['error' => 'Form Files not found'], 404);
            }

            $formViewing = new FormDownloading();
            $formViewing->user_id = $userId;
            $formViewing->form_id = $formId;
            $formViewing->form_files_id = $formFiles->id; 
            $formViewing->save();

            $formViewing->load('form');

            return response()->json([
                'message' => 'Form download recorded successfully',
                'form_viewing' => $formViewing,
            ], 200);
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    } catch (\Exception $e) {
        Log::error('Failed to record form download', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
    }
}
}
