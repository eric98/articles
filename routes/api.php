<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => "Ergare17\Articles\Http\Controllers",'middleware' => 'api','prefix' => 'api/v1', 'middleware' => ['throttle','bindings']], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/articles', 'APIArticlesController@index');
        Route::get('/articles/{article}', 'APIArticlesController@show');
        Route::post('/articles', 'APIArticlesController@store');
        Route::put('/articles/{article}', 'APIArticlesController@update');
        Route::delete('/articles/{article}', 'APIArticlesController@destroy');

        Route::post('read-article/{article}', 'ApiReadArticleController@store');
        Route::delete('read-article/{article}', 'ApiReadArticleController@destroy');

        Route::put('description-article/{article}', 'ApiDescriptionArticleController@update');

        Route::put('user_id-article/{article}', 'ApiUserIdArticleController@update');

        Route::get('users', 'ApiUserController@index');
        Route::get('users/{user}', 'ApiUserController@show');
        Route::post('users', 'ApiUserController@store');
        Route::put('users/{user}', 'ApiUserController@update');
        Route::delete('users/{user}', 'ApiUserController@destroy');
    });
});
