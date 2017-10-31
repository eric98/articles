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

Route::get('/articles','APIArticlesController@index');
Route::get('/articles/{article}','APIArticlesController@show');

//Route::group(['namespace' => 'Ergare17\Articles\Http\Controllers', 'middleware' => 'api'], function(){
//    Route::get('/api/articles', 'APIArticlesController@index');
//    Route::get('/api/articles/{article}', 'APIArticlesController@show');
//});