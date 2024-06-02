<?php

namespace App\Http\Controllers;

use App\Models\inventaire;
use Illuminate\Http\Request;

class InvantaireController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        $BCE = inventaire::create($request->all());

        return response()->json($BCE, 201);
    }
}
