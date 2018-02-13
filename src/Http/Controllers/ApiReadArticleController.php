<?php

namespace Ergare17\Articles\Http\Controllers;

use Ergare17\Articles\Http\Requests\DestroyReadArticle;
use Ergare17\Articles\Http\Requests\StoreReadArticle;
use Ergare17\Articles\Models\Article;

class ApiReadArticleController extends Controller
{
    public function store(StoreReadArticle $request, Article $article)
    {
        $article->read = true;
        $article->save();

        return $article;
    }

    public function destroy(DestroyReadArticle $request, Article $article)
    {
        $article->read = false;
        $article->save();

        return $article;
    }
}
