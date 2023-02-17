<?php

use Illuminate\Support\Facades\Auth;
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
//     return view('welcome');
// });

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/', function (){
    return view('auth.login');
});

Route::get('/contact/create', 'ContactController@create')->name('contact.create')->middleware('guest');
Route::post('/contact/store', 'ContactController@store')->name('contact.store');

Route::middleware(['verified'])->group(function() {
Route::get('/home', 'HomeController@index')->name('home');

//リソースコントローラからupdateを除外
Route::resource('/post', 'PostController', ['except' => ['update']]);
//post.updateにミドルウェアをかける
Route::put('/post/{post}', 'PostController@update')->middleware('can:update,post')->name('post.update');

Route::post('/post/comment/store', 'CommentController@store')->name('comment.store');

Route::get('/mypost', 'HomeController@mypost')->name('home.mypost');
Route::get('/mycomment', 'HomeController@mycomment')->name('home.mycomment');


//管理者用画面
Route::middleware(['can:admin'])->group(function() {
    Route::get('/profile/index', 'ProfileController@index')->name('profile.index');
});
});