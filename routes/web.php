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

Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::post('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::get('/gallery', ['as' => 'yourRoute.view','uses' => 'MyLaradropController@view']);
Route::get('/gallery/projects/{id}', ['as' => 'filemanager.project.gallery','uses' => 'MyLaradropController@getConnectors']);

Route::resource('projects', 'ProjectController');
Route::group(['prefix' => 'projects', 'middleware' => ['web']], function () {
    Route::get('{id}/gallegy',['as'=>'projects.admin.gallery.view', 'uses' => 'ProjectController@galleryView']);
});
Route::resource('catalogs', 'CatalogController');


Route::group(['prefix' => 'users', 'middleware' => ['web']], function () {
    Route::get('/register',['as'=>'user.admin.register.view', 'uses' => 'HomeController@register']);
});