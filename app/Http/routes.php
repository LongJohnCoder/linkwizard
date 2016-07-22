<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('urlshortner.index');
})->name('getIndex');
Route::get('/dashboard',['uses' => 'HomeController@getDashboard', 'as' => 'getDashboard']);

Route::post('/ShortUrl',['uses' => 'HomeController@postShortUrl', 'as' => 'postShortUrl']);

Route::get('/test', ['uses' => 'HomeController@test', 'as' => 'testUrl']);
Route::post('/LoginAttempt',['uses' => 'HomeController@LoginAttempt','as' => 'LoginAttempt']);
Route::post('/postRegister',['uses' => 'HomeController@postRegister', 'as' => 'postRegister']);
