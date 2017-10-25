<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect('home');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/gallery', ['as' => 'gallery.view','uses' => 'MyFileController@view']);
Route::get('/projects/{category}/filter', ['as' => 'projects.filter','uses' => 'ProjectController@filtered']);

Route::resource('projects', 'ProjectController');

Route::resource('catalogs', 'CatalogController');

Route::resource('promotions', 'PromotionsController');

Route::group(['prefix' => 'users', 'middleware' => ['web']], function () {
    Route::get('/register',['as'=>'user.admin.register.view', 'uses' => 'HomeController@register']);
});

