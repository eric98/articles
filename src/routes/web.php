<?php

Route::group(['namespace' => "Ergare17\Articles\Http\Controllers"], function () {
    Route::get('/articles','ArticleController@index'); // 1 Retrieve -> Llista completa -> Paginació

    Route::get('/articles/create','ArticleController@create');
    Route::post('/articles/create','ArticleController@store');

    Route::get('/articles/edit','ArticleController@edit');

    Route::get('/articles/{article}','ArticleController@show'); // 2 Retrieve -> recurs concret
    Route::get('/articles_alt/{id}','ArticleController@show1'); // 2 Retrieve -> recurs concret
});