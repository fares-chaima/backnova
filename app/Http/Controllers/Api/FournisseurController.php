<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Fournisseur::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'adresse' => 'required',
            'number' => 'required',
            'email' => 'required|email|unique:fournisseurs,email,',
            'NIS' => 'required',
            'NIF' => 'required',
            'RC' => 'required',
        ]);

        $fournisseur = Fournisseur::create($request->all());

        return response()->json($fournisseur, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        return response()->json($fournisseur, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'adresse' => 'required',
            'number' => 'required',
            'email' => 'required|email|unique:fournisseurs,email,',
            'NIS' => 'required',
            'NIF' => 'required',
            'RC' => 'required',
        ]);

        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($request->all());

        return response()->json($fournisseur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return response()->json(['message' => 'Fournisseur deleted successfully!'], 200);
    }
    public function listing()
{
    $listOfFour = Fournisseur::all();
    $data = [];

    foreach ($listOfFour as $f) {
        $data[] = [
            'nom' => $f->name,
            'addresse' => $f->adresse,
            'number' => $f->number,
        ];
    }

    return response()->json($data, 200);
}

}
