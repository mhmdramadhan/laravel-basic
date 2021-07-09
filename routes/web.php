<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::get('/', 'HomeController');

Route::get('posts', 'PostController@index');
Route::prefix('posts')->middleware('auth')->group(function () {
    // withoutMiddleware fungsi untuk pengecualian
    // Route::get('posts', 'PostController@index')->withoutMiddleware('auth');
    Route::get('create', 'PostController@create');
    Route::post('store', 'PostController@store');
    Route::get('{post:slug}/edit', 'PostController@edit');
    Route::patch('{post:slug}/edit', 'PostController@update');
    Route::delete('{post:slug}/delete', 'PostController@destroy');
});
Route::get('post/{post:slug}', 'PostController@show')->withoutMiddleware('auth');

Route::get('categories/{category:slug}', 'CategoryController@show');
Route::get('tags/{tag:slug}', 'TagController@show');


Route::view('/contact', 'contact');
Route::view('/about', 'about');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
