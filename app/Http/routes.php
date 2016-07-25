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

Route::get('/', [
    'uses' => 'HomeController@getIndex',
    'as' => 'getIndex'
]);

Route::get('/{url}', [
    'uses' => 'HomeController@getRequestedUrl',
    'as' => 'getRequestedUrl'
]);

Route::post('/url/storelocation', [
    'uses' => 'HomeController@postStoreLocation',
    'as' => 'postStoreLocation'
]);

Route::post('/url/hitcountry', [
    'uses' => 'HomeController@postHitCountry',
    'as' => 'postHitCountry'
]);

Route::post('/url/short', [
    'uses' => 'HomeController@postShortUrlTier5',
    'as' => 'postShortUrlTier5'
]);

Route::get('/user/login', [
    'uses' => 'HomeController@getLogin',
    'as' => 'getLogin'
]);

Route::post('/user/register', [
    'uses' => 'HomeController@postRegister',
    'as' => 'postRegister'
]);

Route::post('/user/login', [
    'uses' => 'HomeController@postLogin',
    'as' => 'postLogin'
]);

Route::get('/user/logout', [
    'uses'=>'HomeController@getLogout',
    'as'=>'getLogout'
]);

Route::get('/user/dashboard', [
    'uses' => 'HomeController@getDashboard',
    'as' => 'getDashboard'
]);
