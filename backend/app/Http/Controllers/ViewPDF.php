<?php

namespace App\Http\Controllers;

use App\Models\FormFiles;
use App\Models\Policies;
use App\Models\Procedures;
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
}
