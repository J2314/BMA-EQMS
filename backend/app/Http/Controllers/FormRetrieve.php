<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forms;

class FormRetrieve extends Controller
{
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
}
