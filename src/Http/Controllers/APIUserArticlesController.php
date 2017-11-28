<?php

namespace Ergare17\Articles\Http\Controllers;

use Auth;
use Ergare17\Articles\Models\Article;

/**
 * Class APIUserArticlesController.
 *
 * @package App\Http\Controllers
 */
class APIUserArticlesController extends Controller
{
    /**
     * Show list of articles.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Auth::user()->articles;
    }

    /**
     * Store article for logged user.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function store(UserStoreArticle $request)
    {
        $article = Article::create($request->only(['name','user_id','description']));
        Auth::user()->articles()->save($article);
        return $article;
    }

}
