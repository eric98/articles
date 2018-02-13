<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDescriptionArticle;
use Ergare17\Articles\Models\Article;

class ApiDescriptionArticleController extends Controller
{
    public function update(UpdateDescriptionArticle $request, Article $article)
    {
        $request->validate([
            'description' => 'required',
        ]);
        $article->description = $request->description;
        $article->save();

        return $article;
    }
}
