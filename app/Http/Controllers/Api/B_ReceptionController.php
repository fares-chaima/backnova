<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\B_Reception;
use App\Models\BCExterne;
use App\Models\Quantite_livre;
use Illuminate\Support\Facades\DB;
class B_ReceptionController extends Controller
{
    public function index()
    {
       
        $breception = B_Reception::all();
        return response()->json($breception, 200);
    } 
    
    public function create_br(Request $request, $id_b_c_externe)
    {
        if (!BCExterne::where('id', $id_b_c_externe)->exists()) {
            return response()->json(['message' => 'Invalid b_c_externe_id'], 400);
        }
        
        $bReception = B_Reception::create([
            'date' => now(),
            'b_c_externe_id' => $id_b_c_externe,
            'fournisseur_id' =>DB::table('b_c_externes')
            ->where('id', $id_b_c_externe)
            ->value('fournisseur_id') ,
        ]);
        $ListOfProducts = DB::table('quantite_commandes')
        ->where('b_c_externe_id', $id_b_c_externe)->get();
        foreach ($ListOfProducts as $product) {  
            $QS =  Quantite_livre::create([
            'product_id'=> $product->product_id,
            'b_reception_id'=> $bReception->id,
            'quantity'=> 0,
            ]);
        } if ($bReception) {
            return response()->json(['message' => 'B_Reception created successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to create B_Reception'], 500);
        }
    }
    public function destroy($id)
    {
        $BR = B_Reception::findOrFail($id);
        $BR->delete();
    
        return response()->json([], 204);
    }
    public function show($id)
    {
        $br = B_Reception::findOrFail($id);

        return response()->json($br, 200);
    }
 }

