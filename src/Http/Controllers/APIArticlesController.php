<?php

namespace Ergare17\Articles\Http\Controllers;

use App\Article;
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
}
