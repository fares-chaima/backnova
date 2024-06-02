<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateQuantityCommandeRequest;
use App\Models\quantité_commande;
use App\Models\Product;
use App\Models\quantite_demande;
use App\Models\Quantite_livre;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuantitéCommandController extends Controller
{
    public function store(CreateQuantityCommandeRequest $request)
    {
        $data = array_map(function($product) use($request) {
            return array_merge($request->only('b_c_externe_id'), $product);
        }, $request->products); 
        quantité_commande::insert($data);
        //foreach ($request->products as $product) {
        //    $data = array_merge($product, $request->only('b_c_externe_id'));
        //    $QC = quantité_commande::create($data); // one per each round
        // }
        return response()->json([
            'status' => true,
            'message' => 'registered commanded quantity for each product for the current bon de command successfully.',

        ], 200);
    }
    public function update(CreateQuantityCommandeRequest $request, $b_c_externe_id){
    foreach ($request->products as $product) {
        // Find the record with the specific b_c_externe_id and product_id
        $record = quantité_commande::where('b_c_externe_id', $b_c_externe_id)
            ->where('product_id', $product['product_id'])
            ->first();

        if ($record) {
            // Update the quantity of the found record
            $record->update(['quantity' => $product['quantity']]);
        } else {
            }
    }
        return response()->json([
            'status' => true,
            'message' => 'Quantities updated successfully for b_c_externe_id: ' . $b_c_externe_id,
        ], 200);
    }
    public function show( $b_c_externe_id){
       
        $quantities = quantité_commande::where('b_c_externe_id', $b_c_externe_id)->get();

        // Check if quantities exist
        if ($quantities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No quantities found for the provided id_bce.'
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'quantities' => $quantities
        ], 200);
    }
    public function mostCommandedProducts() {
        $mostCommandedProducts = quantité_commande::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(3)
            ->get();
    
        // Fetch product details for each product_id
        $products = [];
        foreach ($mostCommandedProducts as $item) {
            $product = Product::find($item->product_id); 
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
    public function yearly($productId)
    {
        $query = quantité_commande::query();

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $data = $query->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->groupBy('year')
            ->get()
            ->pluck('total_quantity', 'year');

        return response()->json($data);
    }
    public function totalQuantity($bce_Id)
    {    
        $br=DB::table('b_receptions')
        ->where('id', $bce_Id)
        ->value('id');
        $CommandedQuantity = quantité_commande::where('b_c_externe_id', $bce_Id)->sum('quantity');
        $livredQuantity = Quantite_livre::where('b_reception_id', $br)->sum('quantity');

        return response()->json([
            'quantite commandée' => $CommandedQuantity,
            'quantite livré' => $livredQuantity,
        ]);
    }
}
