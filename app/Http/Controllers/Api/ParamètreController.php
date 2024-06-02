<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\paramètre;

class ParamètreController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paramètres = Paramètre::all();
        return response()->json($paramètres);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Dénomination' => 'required|string',
            'Code_Gestionnaire' => 'required|integer',
            'adresse' => 'required|string',
            'Téléphone' => 'required|integer',
            'photo_url' => 'string',
        ]);

        $paramètre = Paramètre::create($validatedData);

        return response()->json($paramètre, 201);
    }
/**
     * Display the specified resource.
     *
     * @param  \App\Models\Paramètre  $paramètre
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Paramètre $paramètre)
    {
        return response()->json($paramètre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paramètre  $paramètre
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Paramètre $paramètre)
    {
        $validatedData = $request->validate([
            'Dénomination' => 'required|string',
            'Code_Gestionnaire' => 'required|integer',
            'adresse' => 'required|string',
            'Téléphone' => 'required|integer',
            'photo_url' => 'required|string',
        ]);

        $paramètre->update($validatedData);

        return response()->json($paramètre, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paramètre  $paramètre
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Paramètre $paramètre)
    {
        $paramètre->delete();

        return response()->json(null, 204);
    }
}
