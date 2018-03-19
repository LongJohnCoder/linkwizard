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

//test route
Route::get('/test', function(){
    dd(env('APP_HOST'));
});

Route::get('/test12',function(){
    dd(env('PUBLISHABLE_KEY'));
});

/* API Routes */
Route::group(['prefix' => 'api/v1'],function() {
  Route::post('post-subscriber',[
    'uses'  => 'ApiController@createUserByEmail',
    'as'    => 'createUserByEmail'
  ]);
  Route::post('delete-subscriber',[
    'uses'  => 'ApiController@deleteUserByEmail',
    'as'    => 'deleteUserByEmail'
  ]);
});
/* API routes ends here


//before login this url is the base url
//tr5.* for production */
Route::group(['domain' => env('APP_HOST')], function () {
  Route::get('/', [
      'uses' => 'HomeController@getIndex',
      'as' => 'getIndex',
  ]);

  Route::get('forgot_password', [
    'uses'  => 'HomeController@forgotPassword',
    'as'    => 'forgotPassword'
  ]);

  Route::post('forgotPasswordEmail', [
    'uses'  =>  'HomeController@forgotPasswordEmail',
    'as'    =>  'forgotPasswordEmail'
  ]);

  Route::get('reset-password/{email}/{token}', [
    'uses'  =>  'HomeController@resetPassword',
    'as'    =>  'reset-password'
  ]);

  Route::post('set-password', [
    'uses'  =>  'HomeController@setPassword',
    'as'    =>  'setPassword'
  ]);
});

//actual rooutes goes here
Route::group(['domain' => env('APP_LOGIN_HOST')], function () {


    Route::post('/check_custom' , 'HomeController@check_custom');
    Route::get('test' , function(){
        return view('test');
    });
    Route::post('/test' , 'HomeController@test');

    Route::get('/api_test' , 'HomeController@api_test');

    Route::get('/short_url_api' , 'HomeController@short_url_api');

    Route::get('/blog' , 'HomeController@blog');
    Route::get('/pricing' , 'HomeController@pricing');
    Route::get('/features' , 'HomeController@features');
    Route::get('/about' , 'HomeController@about');

    // Route::get('/{url}', [
    //     'uses' => 'HomeController@getRequestedUrl',
    //     'as' => 'getRequestedUrl',
    // ]);

    // Route::get('/{subdirectory}/{url}', [
    //     'uses' => 'HomeController@getRequestedSubdirectoryUrl',
    //     'as' => 'getRequestedSubdirectoryUrl',
    // ]);

    Route::get('/{url}/date/{date}/analytics', [
        'uses' => 'HomeController@getAnalyticsByDate',
        'as' => 'getAnalyticsByDate',
    ]);

    Route::get('/{url}/{subdirectory}/date/{date}/analytics', [
        'uses' => 'HomeController@getAnalyticsBySubdirectoryDate',
        'as' => 'getAnalyticsBySubdirectoryDate',
    ]);

    Route::get('/{url}/country/{country}/analytics', [
        'uses' => 'HomeController@getAnalyticsByCountry',
        'as' => 'getAnalyticsByCountry',
    ]);

    Route::group(['prefix' => 'app'], function () {
        Route::group(['prefix' => 'url'], function () {

            //search url with links
            Route::get('/{id}/link_preview',[
              'uses'  =>  'HomeController@getLinkPreview',
              'as'    =>  'getLinkPreview'
            ]);

            Route::post('giveMyTags', [
              'uses'  =>  'HomeController@giveMyTags',
              'as'    =>  'giveMyTags'
            ]);

            Route::post('short', [
                'uses' => 'HomeController@postShortUrlTier5',
                'as' => 'postShortUrlTier5',
            ]);

            Route::post('custom', [
                'uses' => 'HomeController@postCustomUrlTier5',
                'as' => 'postCustomUrlTier5',
            ]);

            Route::post('fetchanalytics', [
                'uses' => 'HomeController@postFetchAnalytics',
                'as' => 'postFetchAnalytics',
            ]);

            Route::post('fetchanalyticsbydate', [
                'uses' => 'HomeController@postAnalyticsByDate',
                'as' => 'postAnalyticsByDate',
            ]);

            Route::post('fetchanalyticsbycountry', [
                'uses' => 'HomeController@postAnalyticsByCountry',
                'as' => 'postAnalyticsByCountry',
            ]);

            Route::any('fetchchartdata', [
                'uses' => 'HomeController@postFetchChartData',
                'as' => 'postFetchChartData',
            ]);

            Route::any('postchartdatafilterdaterange', [
                'uses' => 'HomeController@postChartDataFilterDateRange',
                'as' => 'postChartDataFilterDateRange',
            ]);

            Route::any('fetchchartdatabydate', [
                'uses' => 'HomeController@postFetchChartDataByDate',
                'as' => 'postFetchChartDataByDate',
            ]);

            Route::any('fetchchartdatabycountry', [
                'uses' => 'HomeController@postFetchChartDataByCountry',
                'as' => 'postFetchChartDataByCountry',
            ]);

            Route::post('editurlinfo', [
                'uses' => 'HomeController@postEditUrlInfo',
                'as' => 'postEditUrlInfo',
            ]);

            Route::post('userinfo', [
                'uses' => 'HomeController@postUserInfo',
                'as' => 'postUserInfo',
            ]);

            Route::post('analytics-by-date', [
                'uses' => 'HomeController@postAnalyticsByDate',
                'as' => 'postAnalyticsByDate',
            ]);
        });

        Route::group(['prefix' => 'user'], function () {

            Route::post('shortenUrl', [
              'uses' => 'HomeController@shortenUrl',
              'as'   => 'shortenUrl'
            ]);

            Route::get('create_shortened_link',[
              'uses'  => 'HomeController@createShortenedLink',
              'as'    => 'createShortenedLink'
            ]);

            Route::get('create_custom_link',[
              'uses'  => 'HomeController@createCustomLink',
              'as'    => 'createCustomLink'
            ]);

            Route::post('register', [
                'uses' => 'HomeController@postRegister',
                'as' => 'postRegister',
            ]);

            Route::post('login', [
                'uses' => 'HomeController@postLogin',
                'as' => 'postLogin',
            ]);

            Route::get('logout', [
                'uses' => 'HomeController@getLogout',
                'as' => 'getLogout',
            ]);

            Route::get('dashboard', [
                'uses' => 'HomeController@getDashboard',
                'as' => 'getDashboard',
            ]);

            Route::get('subscribe', [
                'uses' => 'HomeController@getSubscribe',
                'as' => 'getSubscribe',
            ]);

            Route::post('subscription', [
                'uses' => 'HomeController@postSubscription',
                'as' => 'postSubscription',
            ]);

            Route::post('brand-logo', [
                'uses' => 'HomeController@postBrandLogo',
                'as' => 'postBrandLogo',
            ]);

            Route::post('brand-link', [
                'uses' => 'HomeController@postBrandLink',
                'as' => 'postBrandLink',
            ]);

            Route::post('email-check', [
                'uses' => 'HomeController@postEmailCheck',
                'as' => 'postEmailCheck',
            ]);
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::get('dashboard', [
                'uses' => 'HomeController@getAdminDashboard',
                'as' => 'getAdminDashboard',
            ]);

            Route::post('package-limit', [
                'uses' => 'HomeController@postPackageLimit',
                'as' => 'postPackageLimit',
            ]);
        });
    });
});


//router for subdomains
Route::group(['domain' => '{subdomain}.'.env('APP_REDIRECT_HOST')], function () {
  Route::get('/{url}', 'HomeController@getRequestedSubdomainUrl');
});
//routing for subdomains ends here

//router for subdirectories
Route::group(['domain' => env('APP_REDIRECT_HOST')], function () {
  //Route::get('/{url}', 'HomeController@getRequestedSubdomainUrl');
  Route::get('/{subdirectory}/{url}', [
      'uses' => 'HomeController@getRequestedSubdirectoryUrl',
      'as' => 'getRequestedSubdirectoryUrl',
  ]);

  Route::get('/{url}', [
      'uses' => 'HomeController@getRequestedUrl',
      'as' => 'getRequestedUrl',
  ]);
});
//routing for subdirectories ends here


// Route::group(['domain' => '{subdomain}.'.env('APP_HOST')], function () {
//     Route::get('/', function ($subdomain) {
//         return redirect()->route('getIndex');
//     });
//
//     Route::get('/{url}', [
//         'uses' => 'HomeController@getRequestedSubdomainUrl',
//         'as' => 'getRequestedSubdomainUrl',
//     ]);
// });
