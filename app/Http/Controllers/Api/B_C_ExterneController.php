<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BCExterne;
use Illuminate\Http\Request;

class B_C_ExterneController extends Controller
{ 
    public function index()
    {
        $bcExternes = BCExterne::all();
        return response()->json($bcExternes, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'fournisseur_id' =>'required',
            
        ]);

        $BCE = BCExterne::create($request->all());

        return response()->json($BCE, 201);
    }
    public function show($id)
    {
        $bcExterne = BCExterne::findOrFail($id);
        return response()->json($bcExterne, 200);
    }
    public function destroy($id)
    {
        $bcExterne = BCExterne::findOrFail($id);
        $bcExterne->delete();

        return response()->json(null, 204);
    }
    public function nbrofBce (){
        $bce = BCExterne::count();
        return $bce;
    }
}
