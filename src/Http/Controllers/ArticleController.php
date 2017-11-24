<?php

namespace Ergare17\Articles\Http\Controllers;

use Ergare17\Articles\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Redirect;
use Session;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // CRUD -> Retrieve --> List
        // BREAD -> Browse Read Edit Add Delete
        $articles = Article::all();
        return view('articles::list_article', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles::create_article');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Article::create($request->only(['title','description']));

        Session::flash('status', 'Created ok!');
        return Redirect::to('/articles_php/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
//        dump($artice->title);
//        return view('show_article',compact('article'));
        return view('articles::show_article', compact('article'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show1($id)
    {
        dump($id);
        dump($article = Article::find($id));

//        if ($article == null)abort(404);
//        try{
//            $article = Article::findOrFail($id);
//        } catch(\Exception $e){
//            abort(404);
//        }
        $article = Article::findOrFail($id);

        dump($article->title);
//        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles::edit_article', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->only(['title','description']));

        Session::flash('status', 'Edited ok!');
        return Redirect::to('/articles_php/edit/'.$article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        Session::flash('status', 'Article was deleted successful!');
        return Redirect::to('/articles_php');
    }
}
