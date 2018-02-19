<?php

namespace Ergare17\Articles\Http\Controllers;

use Ergare17\Articles\Models\Article;
use Illuminate\Http\Request;

class APIArticlesController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function show(Article $article)
    {
        return $article;
    }

    // Injeccció de depèndències
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id
        ]);

        return $article;
    }

    public function destroy(Request $request, Article $article)
    {
        $article->delete();
        return $article;
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required'
        ]);
        $article->title = $request->title;
        $article->save();
        return $article;
    }
}
