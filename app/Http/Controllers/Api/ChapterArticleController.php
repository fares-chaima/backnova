<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Article;
class ChapterArticleController extends Controller
{
    public function index(Chapter $chapter){
        

        /**
         * display the articles for the targeted chpater
        */
        return response()->json(
            $chapter->articles
        );
    }

    public function show(Chapter $chapter, Article $article){
        /**
         * check wthether this artcile belongs to the givven chapter
         * otherwise abort 404 HTTP error
        */
        abort_unless($chapter->articles()->contains($article->id), 404);

        /**
         * return data for this article
        */
        return response()->json(
            $article
        );
    }
}
