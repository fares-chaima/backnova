<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QuantitePerdu;
use Illuminate\Http\Request;
class QuantitePerduController extends Controller
{

public function store(Request $request)
{
    
    $validated = $request->validate([
        'inventaire_id' => 'required|exists:inventaires,id', 
        'products' => 'array|required',
        'products.*' => 'array|required',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.observation' => 'required'
    ]);

    foreach ($validated['products'] as $productData) {
        
        if (!isset($productData['product_id'])) {
            return response()->json([
                'status' => false,
                'message' => 'Product ID is missing in the request data.'
            ], 400);
        }

        $productId = $productData['product_id'];
        $bonCommandeId = $validated['inventaire_id'];
        $requestedQuantity = $productData['quantity'];
        $observation = $productData['observation'];

    
        $product = Product::findOrFail($productId);
        $storedQuantity = $product->quantity;

        if ($requestedQuantity !== $storedQuantity) {
            
            $lostQuantity = $storedQuantity - $requestedQuantity;
            $product->update([
                'quantity' => $requestedQuantity]);
          
            QuantitePerdu::create([
                'product_id' => $productId,
                'inventaire_id' => $bonCommandeId,
                'quantity' => $lostQuantity,
                'Observation' => $observation,
            ]);
        }
    }

    return response()->json([
        'status' => true,
        'message' => 'Registered requested quantity for each product for the current bon de command successfully.',
    ], 200);
}
public function show( $inventaire_id){
       
    $quantities = QuantitePerdu::where('inventaire_id', $inventaire_id)->get();
  
    if ($quantities->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No quantities perdu.'
        ], 404);
    }
    $quantities->makeHidden(['created_at', 'updated_at']);
    return response()->json([
        'status' => true,
        'quantities' => $quantities
    ], 200);
}
}
