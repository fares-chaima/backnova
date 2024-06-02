<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BSortie;
use App\Models\BDecharge;
use App\Models\Product;
use App\Models\Quantite_Decharge;
use App\Models\quantite_sortie;
use Illuminate\Support\Facades\DB;


class B_SortieController extends Controller
{
   public function index_b_sortie (){
    $bsortie = BSortie::all();
        return response()->json($bsortie, 200);
   }
   public function index_b_decharge (){
      $bdecharge = BDecharge::all();
      return response()->json($bdecharge, 200);
   }
   public function createBSorBD($id_b_c_interne)
   { 
      
       $status = DB::table('b_c_internes')
                       ->where('id', $id_b_c_interne)
                       ->value('status');
                      
       $type = DB::table('b_c_internes')
                       ->where('id', $id_b_c_interne)
                       ->value('type');
                      
       if ($status == 3 and $type== 0 ) {
         $bSortie = BSortie::create([
            'date' => now(), ]);
            DB::table('b_sortie_b_c_interne')->insert([
               'b_sortie_id' => $bSortie->id,
               'b_c_interne_id' => $id_b_c_interne,
           ]);
           $ListOfProducts = DB::table('quantite_demandes')
         ->where('b_c_interne_id', $id_b_c_interne)->get();
         foreach ($ListOfProducts as $product) {  
        $QS =  quantite_sortie::create([
        'product_id'=> $product->product_id,
        'b_sortie_id'=> $bSortie->id,
        'quantity'=>$product->quantity,
        ]);
        $p = Product::find($product['product_id']);
        $p->update(['quantity' => $p->quantity - $product['quantity']]);
     }
           
       }else if($status == 3 and $type== 1) {
         $bDecharge = BDecharge::create([
            'date' => now(),
            'observation'=>DB::table('b_c_internes')
            ->where('id', $id_b_c_interne)
            ->value('observation'),
             'Recovery'=>DB::table('b_c_internes')
             ->where('id', $id_b_c_interne)
             ->value('Recovery'),
          ]);
          $ListOfProducts = DB::table('quantite_demandes')
          ->where('b_c_interne_id', $id_b_c_interne)->get();

          foreach ($ListOfProducts as $product) {  
           
            $QS =  Quantite_Decharge::create([
            'product_id'=> $product->product_id,
            'b_decharge_id' => $bDecharge->id,
            'quantity'=>$product->quantity,
            ]);
            $p = Product::find($product['product_id']);
            $p->update(['quantity' => $p->quantity - $product['quantity']]);
         
         }
          DB::table('b_decharge_b_c_interne')->insert([
            'b_decharge_id' => $bDecharge->id,
            'b_c_interne_id' => $id_b_c_interne,
        ]);
      }
   }
   public function RetourDeProduit($id_decharge){
      if (!BDecharge::where('id', $id_decharge)->exists()) {
        return response()->json(['message' => 'Invalid b_decharge_id'], 400);
     }
     $Recovery = DB::table('b_decharges')
     ->where('id', $id_decharge)
     ->value('Recovery');
     if ($Recovery == 0){
      $Recovery = 1;
      $ListOfProducts = DB::table('quantite_decharges')
          ->where('b_decharge_id', $id_decharge)->get();
          foreach ($ListOfProducts as $product) {  
            $p = Product::find($product['product_id']);
            $p->update(['quantity' => $p->quantity + $product['quantity']]);
         
         }
     }else{
      return response()->json(['message '=> 'there is no quantity to return']);
     }
     
   }
}
