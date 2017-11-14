<?php

Route::group(['namespace' => "Ergare17\Articles\Http\Controllers", "middleware" => 'web'], function () {




    Route::group(["middleware" => 'auth'], function () {

        //WEB
        Route::get('/articles', 'ArticleController@index'); // 1 Retrieve -> Llista completa -> Paginació
        Route::get('/articles/create', 'ArticleController@create');
        Route::post('/articles', 'ArticleController@store');
        Route::get('/articles/edit/{article}', 'ArticleController@edit');
        Route::put('/articles/{article}', 'ArticleController@update');
        Route::delete('/articles/{article}', 'ArticleController@destroy');  // 2 Retrieve -> 1 recurs concret
        Route::get('/articles/{article}', 'ArticleController@show'); // 2 Retrieve -> recurs concret
        Route::get('/articles_alt/{id}', 'ArticleController@show1'); // 2 Retrieve -> recurs concret

        //API
        Route::get('/api/v1/articles', 'APIArticlesController@index');
        Route::get('/api/v1/articles/{article}', 'APIArticlesController@show');
        Route::post('/api/v1/articles', 'APIArticlesController@store');
        Route::put('/api/v1/articles/{article}', 'APIArticlesController@update');
        Route::delete('/api/v1/articles/{article}', 'APIArticlesController@destroy');

    });
});