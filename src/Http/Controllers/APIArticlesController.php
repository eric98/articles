<?php

namespace Ergare17\Articles\Http\Controllers;

use Ergare17\Articles\Http\Requests\DestroyArticle;
use Ergare17\Articles\Http\Requests\ListArticle;
use Ergare17\Articles\Http\Requests\ShowArticle;
use Ergare17\Articles\Http\Requests\StoreArticle;
use Ergare17\Articles\Http\Requests\UpdateArticle;
use Ergare17\Articles\Models\Article;

class APIArticlesController extends Controller
{
    public function index(ListArticle $request)
    {
        return Article::all();
    }

    public function show(ShowArticle $article)
    {
        return $article;
    }

    // Injeccció de depèndències
    public function store(StoreArticle $request)
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

    public function destroy(DestroyArticle $request, Article $article)
    {
        $article->delete();
        return $article;
    }

    public function update(UpdateArticle $request, Article $article)
    {
        $request->validate([
            'title' => 'required'
        ]);
        $article->title = $request->title;
        $article->save();
        return $article;
    }
}
