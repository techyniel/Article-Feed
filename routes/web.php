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

Route::get('/', 'BlogController@index');
Route::get('/articles/{articles}', 'BlogController@articles');
Route::post('/articles/{articles}/comment', 'BlogController@comment')->middleware('auth');

Auth::routes();
Route::get('/profile', 'Auth\\ProfileController@index')->middleware('auth');
Route::get('/setting', 'Auth\\SettingController@index')->middleware('auth');
Route::get('/changePassword','SettingController@ChangePassword')->middleware('auth');
Route::post('/changePassword','SettingController@ChangePassword')->middleware('auth');

Route::get('states', 'HomeController@index');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::resource('/articles', 'ArticlesController');
    Route::put('/Articles/{Articles}/publish', 'ArticlesController@publish')->middleware('admin');
    Route::resource('/categories', 'CategoryController', ['except' => ['show']]);
    Route::resource('/tags', 'TagController', ['except' => ['show']]);
    Route::resource('/comments', 'CommentController', ['only' => ['index', 'destroy']]);
    // Route::resource('/like', 'PostController@LikePost', ['only' => ['index', 'destroy']]);
    Route::resource('/users', 'UserController', ['middleware' => 'admin', 'only' => ['index', 'destroy']]);
});
