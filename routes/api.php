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

Route::get('projects/{input}/', 'ProjectAPIController@show');
Route::get('projects/{project_id}/gallery', 'ProjectAPIController@gallery');
Route::get('/projects/categories/{category_id}')->uses('ProjectAPIController@index');

Route::resource('catalogs', 'CatalogAPIController');