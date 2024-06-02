<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\chapter;

class ChapterController extends Controller
{
     public function index()
    {
        $chapters = Chapter::all();
        return response()->json($chapters, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
        ]);

        $chapter = Chapter::create($request->all());

        return response()->json($chapter, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $chapter = Chapter::findOrFail($id);
        $chapter->update($request->all());
    
        return response()->json($chapter, 200);
    }
    

    public function destroy($id)
{
    $chapter = Chapter::findOrFail($id);
    $chapter->delete();

    return response()->json([], 204);
}

public function nbrofChapter (){
    $chapters = chapter::count();
    return $chapters;
}
}
