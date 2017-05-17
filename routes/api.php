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

Route::post('register', 'Api\RegistrationController@register');

Route::post('verify', 'Api\RegistrationController@verify');

Route::post('hello', function (){
    return "Jello";
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('test', 'TestingController@testData')->name('test')->middleware('auth:api');

Route::post('mpesa/receive','Api\RegistrationController@receiver');