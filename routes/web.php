<?php

Route::group(['namespace' => "Ergare17\Articles\Http\Controllers", "middleware" => 'web'], function () {


    //WEB
    Route::get('/articles_php', 'ArticleController@index'); // 1 Retrieve -> Llista completa -> Paginació
    Route::get('/articles_php/create', 'ArticleController@create');
    Route::post('/articles_php', 'ArticleController@store');
    Route::get('/articles_php/edit/{article}', 'ArticleController@edit');
    Route::put('/articles_php/{article}', 'ArticleController@update');
    Route::delete('/articles_php/{article}', 'ArticleController@destroy');  // 2 Retrieve -> 1 recurs concret
    Route::get('/articles_php/{article}', 'ArticleController@show'); // 2 Retrieve -> recurs concret
    Route::get('/articles_alt/{id}', 'ArticleController@show1'); // 2 Retrieve -> recurs concret


    Route::view('/articles', 'articles');
});
