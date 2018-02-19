<?php

namespace Ergare17\Articles\Http\Controllers;

use Ergare17\Articles\Http\Requests\UpdateUserIdArticle;
use Ergare17\Articles\Models\Article;

class ApiUserIdArticleController extends Controller
{
    public function update(UpdateUserIdArticle $request, Article $article)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $article->user_id = $request->user_id;
        $article->save();

        return $article;
    }
}
