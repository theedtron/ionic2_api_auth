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
    return view('welcome');
});

Route::get('/text', 'TestingController@text');

Route::get('/login', function () {
    return "Error";
})->name('login');

Auth::routes();

Route::get('/home', 'HomeController@index');
