<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quantite_Decharge;
use App\Models\BDecharge;
use App\Models\quantite_sortie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuantiteSortieController extends Controller
{
    public function show( $b_sortie_id){
       
        $quantities = quantite_sortie::where('b_sortie_id', $b_sortie_id)->get();
       // dd($quantities);
        // Check if quantities exist
        if ($quantities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No quantities found for the provided id_BS.'
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'quantities' => $quantities
        ], 200);
    }
    public function getQunatityConsu($user_id){

        $listofbci = DB::table('b_c_internes')
            ->where('user_id', $user_id)
            ->pluck('id');
    
        $BS = DB::table('b_sortie_b_c_interne')
            ->whereIn('b_c_interne_id', $listofbci)
            ->pluck('b_sortie_id');
    
        $qs = quantite_sortie::whereIn('b_sortie_id', $BS)->sum('quantity');
        
        return response()->json([
            'quntité' => $qs,
        ]);
    }
    public function produitRetourne($user_id){

        $listofbci = DB::table('b_c_internes')
            ->where('user_id', $user_id)
            ->pluck('id');
    
        $BS = DB::table('b_decharge_b_c_interne')
            ->whereIn('b_c_interne_id', $listofbci)
            ->pluck('b_decharge_id');
            //dd($BS);
        $bd_ids = BDecharge::whereIn('id', $BS)
            ->where('Recovery', 1)
            ->pluck('id');
    
        $qs = Quantite_Decharge::whereIn('b_decharge_id', $bd_ids)->sum('quantity');
    
        return response()->json([
            'quntité' => $qs,
        ]);
    }
    
}
