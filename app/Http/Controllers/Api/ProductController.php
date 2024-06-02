<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Chapter;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products], 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'min' => 'required|integer',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'article_id' => 'nullable|exists:articles,id'
        ]);

        $product = Product::create($request->all());
        return response()->json(['product' => $product], 201);
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['product' => $product], 200);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
            'quantity' => 'integer',
            'price' => 'numeric',
            'min' => 'integer',
            'fournisseur_id' => 'exists:fournisseurs,id',
            'article_id' => 'nullable|exists:articles,id'
        ]);

        $product->update($request->all());
        return response()->json(['product' => $product], 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
    public function nbrofproduct (){
        $products = Product::count();
        return $products;
    }
    public function getTopProductsByStructure($structureId)
    {
        $topProducts = Product::select('products.id', 'products.name', DB::raw('SUM(quantite_demandes.quantity) as total_quantity'))
            ->join('quantite_demandes', 'products.id', '=', 'quantite_demandes.product_id')
            ->join('b_c_internes', 'quantite_demandes.b_c_interne_id', '=', 'b_c_internes.id')
            ->join('users', 'b_c_internes.user_id', '=', 'users.id')
            ->join('structure_user', 'users.id', '=', 'structure_user.user_id')
            ->join('structures', 'structure_user.structure_id', '=', 'structures.id')
            ->where('structures.id', $structureId)
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->take(4)
            ->get();

        return response()->json($topProducts);
    }
}

