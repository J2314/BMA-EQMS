<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policies;

class PolicyRetrieve extends Controller
{
    public function getPolicies()
    {
        $policies = Policies::where('is_active', true)->select('id', 'document_type', 'document_name', 'file_path')->get();

        return response()->json($policies);
    }
}   