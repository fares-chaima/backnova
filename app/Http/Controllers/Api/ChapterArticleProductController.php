<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Chapter;
use App\Models\Product;

class ChapterArticleProductController extends Controller
{
    /**
     * Display a listing of chapter article products
     * 
     * display a list of products for the given article
     * for the given chapter
    */
    public function index(Chapter $chapter, Article $article){
        /**
         * check if the article belongs to the targeted chapter
         * otherwise abort 404 Not found HTTP error
        */
        abort_unless( $chapter->articles()->contains($article->id), 404);

        /**
         * display the products for the targeted article
        */
        return response()->json(
            $article->products
        );
    }

    /**
     * Display a specific reosurce of chapter article product
     * 
     * display a certain product within a certain article within
     * a certain chapter
     * 
    */
    public function show(Chapter $chapter, Article $article, Product $product){

        /**
         * check whether this article belongs to the givven chapter
         * otherwise abort 404 HTTP error
        */
        abort_unless( $chapter->articles()->contains($article->id), 404);

        /**
         * check wthether this produc belongs to the givven article
         * otherwise abort 404 HTTP error
        */
        abort_unless($article->products()->contains($product->id), 404);

        /**
         * return data for this product
        */
        return response()->json(
            $product
        );
    }
}
