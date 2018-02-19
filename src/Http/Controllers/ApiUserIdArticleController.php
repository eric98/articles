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
        dd('article->user_id: '.$article->user_id);
        dd('request->user_id: '.$request->user_id);
        $article->user_id = $request->user_id;
        $article->save();

        return $article;
    }
}
