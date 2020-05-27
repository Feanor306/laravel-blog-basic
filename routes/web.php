<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// });

//Route::view('/', 'home')->name('home');
Route::get('/', 'HomeController@home')->name('home');
//->middleware('auth');

Route::get('/contact', 'HomeController@contact')->name('contact');

//RESOURCE DEFAULT ROUTES
//index, store, create, show, update, destroy, edit
Route::resource('/posts', 'PostController');
//->only['',''];
//->except['','']

Route::get('/posts/tag/{tag}', 'PostTagController@index')->name('posts.tags.index');

Auth::routes();