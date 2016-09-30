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

Route::group(['domain' => env('APP_URL')], function () {
    Route::get('/', [
        'uses' => 'HomeController@getIndex',
        'as' => 'getIndex'
    ]);

    Route::get('/{url}', [
        'uses' => 'HomeController@getRequestedUrl',
        'as' => 'getRequestedUrl'
    ]);

    Route::post('/url/fetchanalytics', [
        'uses' => 'HomeController@postFetchAnalytics',
        'as' => 'postFetchAnalytics'
    ]);

    Route::any('/url/fetchchartdata', [
        'uses' => 'HomeController@postFetchChartData',
        'as' => 'postFetchChartData'
    ]);

    Route::post('/url/editurlinfo', [
        'uses' => 'HomeController@postEditUrlInfo',
        'as' => 'postEditUrlInfo'
    ]);

    Route::post('/url/userinfo', [
        'uses' => 'HomeController@postUserInfo',
        'as' => 'postUserInfo'
    ]);

    Route::post('/url/short', [
        'uses' => 'HomeController@postShortUrlTier5',
        'as' => 'postShortUrlTier5'
    ]);

    Route::post('/url/custom', [
        'uses' => 'HomeController@postCustomUrlTier5',
        'as' => 'postCustomUrlTier5'
    ]);

    Route::get('/{url}/analytics', [
        'uses' => 'HomeController@getAnalytics',
        'as' => 'getAnalytics'
    ]);

    Route::get('/{url}/{date}/analytics', [
        'uses' => 'HomeController@getAnalyticsByDate',
        'as' => 'getAnalyticsByDate'
    ]);

    Route::post('/analytics-by-date', [
        'uses' => 'HomeController@postAnalyticsByDate',
        'as' => 'postAnalyticsByDate'
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

    Route::post('/user/brand-logo', [
        'uses' => 'HomeController@postBrandLogo',
        'as' => 'postBrandLogo'
    ]);

    Route::get('/user/subscribe', [
        'uses' => 'HomeController@getSubscribe',
        'as' => 'getSubscribe'
    ]);

    Route::post('/user/subscription', [
        'uses' => 'HomeController@postSubscription',
        'as' => 'postSubscription'
    ]);

    Route::get('/admin/dashboard', [
        'uses' => 'HomeController@getAdminDashboard',
        'as' => 'getAdminDashboard'
    ]);

    Route::post('/admin/package-limit', [
        'uses' => 'HomeController@postPackageLimit',
        'as' => 'postPackageLimit'
    ]);
});

Route::group(['domain' => '{subdomain}.urlshortner.dev'] , function () {
    Route::get('/', function ($subdomain) {
        return $subdomain;
    });
});
