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

//Route::get('/projects/{id}')->uses('ProjectAPIController@show');
Route::get('/projects/categories/{category_id}')->uses('ProjectAPIController@index');


//Route::get('projects/{input}/', 'ProjectAPIController@test');
//Route::resource('projects', 'ProjectAPIController');

Route::resource('catalogs', 'CatalogAPIController');