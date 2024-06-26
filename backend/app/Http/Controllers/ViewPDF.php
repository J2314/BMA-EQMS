<?php

namespace App\Http\Controllers;

use App\Models\FormFiles;
use App\Models\Policies;
use App\Models\Procedures;
use App\Models\Records;
use App\Models\WorkInstructions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewPDF extends Controller
{
    public function getFileContent($fileId)
    {
        $file = FormFiles::find($fileId);

        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response(compact('file'), 200);
    }

    public function getContentPolicies($polId)
    {
        $policy = Policies::find($polId);

        if (!$policy) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response(compact('policy'), 200);
    }

    public function getContentProcedures($procId)
    {
        $procedure = Procedures::find($procId);

        if (!$procId) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response(compact('procedure'), 200);
    }

    public function getWorkInstructions($workId)
    {
        $work = WorkInstructions::find($workId);

        if (!$workId) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response(compact('work'), 200);
    }

    public function getRecord($recId)
    {
        $record = Records::find($recId);

        if (!$recId) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response(compact('record'), 200);
    }
}
