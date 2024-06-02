<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Chapter;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles, 200);
    }
    public function index1(Chapter $chapter)
    {
        $articles = $chapter->articles;
        return response()->json($articles);
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
            'chapiter_id' => 'required|exists:chapters,id',
            'label' => 'required|string|max:255',
            
        ]);

        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
  
    public function show(Chapter $chapter, Article $article)
    {
        $article->load('products');
        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'chapiter_id' => 'required|exists:chapters,id',
            'label' => 'required|string|max:255',
           
        ]);

        $article->update($request->all());

        return response()->json($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([], 204);
    }
    public function nbrofArticles (){
        $articles = Article::count();
        return $articles;
    }
   
}
