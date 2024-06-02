<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\quantite_demande;
use App\Models\Product;
use App\Http\Requests\CreateQunatitiesDemandeRequest;

class QunatiteDemandeController extends Controller
{
    public function store(CreateQunatitiesDemandeRequest $request)
    {
        $data = array_map(function($product) use($request) {
            return array_merge($request->only('b_c_interne_id'), $product);
        }, $request->products); 
        quantite_demande::insert($data);
        return response()->json([
            'status' => true,
            'message' => 'registered requested quantity for each product for the current bon de command successfully.',

        ], 200);
    }

   
    public function update(CreateQunatitiesDemandeRequest $request, $b_c_interne_id){

        foreach ($request->products as $product) {
        
            $record = quantite_demande::where('b_c_interne_id', $b_c_interne_id)
                ->where('product_id', $product['product_id'])
                ->first();
    
            if ($record) {
                
                $record->update(['quantity' => $product['quantity']]);
            } else {
                }
        }
            return response()->json([
                'status' => true,
                'message' => 'Quantities updated successfully for b_c_interne_id: ' . $b_c_interne_id,
            ], 200);
        }
    public function show( $b_c_interne_id){
       
        $quantities = quantite_demande::where('b_c_interne_id', $b_c_interne_id)->get();
    
            if ($quantities->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No quantities found for the provided id_bci.'
                ], 404);
            }
            
            return response()->json([
                'status' => true,
                'quantities' => $quantities
            ], 200);
     }
     public function mostDemandedProducts() {
        $mostDemandedProducts = quantite_demande::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(3)
            ->get();
    
        $products = [];
        foreach ($mostDemandedProducts as $item) {
            $product = product::find($item->product_id); 
            if ($product) {
                $products[] = [
                    'name' => $product->name,
                    'quantity' => $item->total_quantity
                ];
            }
        }
    
        return response()->json([
            'status' => true,
            'most_demanded_products' => $products
        ], 200);
    }
}
