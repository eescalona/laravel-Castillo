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
Route::get('/test', 'HomeController@dropzoneStore');
Route::get('/projects/dz', 'MyFileController2@dropzoneTEST');
Route::get('/public/images/projects', ['as' => 'yourRoute.index']);
Route::get('dropzone', 'HomeController@dropzone');
Route::post('dropzone/store', ['as'=>'dropzone.store','uses'=>'MyFileController@dropzoneStore']);
Route::post('dropzone/delete', ['as'=>'dropzone.delete','uses'=>'MyFileController@deleteUpload']);
Route::get('dropzone/delete', ['as'=>'dropzone.delete','uses'=>'MyFileController@deleteUpload']);

Route::resource('projects', 'ProjectController');
Route::group(['prefix' => 'projects', 'middleware' => ['web']], function () {
    Route::get('{id}/gallegy',['as'=>'projects.admin.gallery.view', 'uses' => 'ProjectController@galleryView']);
});
Route::resource('catalogs', 'CatalogController');


Route::get('/test/catalog', '_test@catalog');

Route::group(['prefix' => 'users', 'middleware' => ['web']], function () {
    Route::get('/register',['as'=>'user.admin.register.view', 'uses' => 'HomeController@register']);
    //Route::get('/register-account', ['as'=>'user.register_account', 'uses' => 'HomeController@createAccount']);    // Modal View
    //Route::post('/register-account', ['as' => 'user.store','uses' => 'UserController@store']);    //Creates accounts.
});

Route::resource('myFiles', 'MyFileController');