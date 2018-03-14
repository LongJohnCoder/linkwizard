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
  //dd('This is a test route');
  //dd(\App\UrlTag::firstOrCreate(['tag'=>'tag5']));
  $userId = 8;
  // dd(\App\UrlTag::whereHas('urlTagMap',function($q) use($userId) {
  //                 $q->whereHas('url', function($q1) use($userId) {
  //                   $q1->where('user_id',$userId);
  //                 })->whereHas('urlTag', function($q1) {
  //                   $q1->select('tag');
  //                 });
  //           })->toSql());

  dd(\App\UrlTag::whereHas('urlTagMap.url',function($q) use($userId) {
                    $q->where('user_id',$userId);
                  })->pluck('tag')->toArray());

  dd(\App\Url::where('user_id',1)->first()->urlTag()->get());

  $allowTags = true;
  $searchTags = ['lakd','aduyf','ajdflad','aldg'];

  if($allowTags && count($searchTags) > 0) {
    foreach ($searchTags as $key => $tag) {
      dd(\App\UrlTag::firstOrCreate(['tag'=>(string)$tag]));
      //dd($urlTag);
      // $urlTagMap  = new \App\UrlTagMap;
      // $urlTagMap->url_id = $urlId;
      // $urlTagMap->url_tag_id = $urlTag->id;
      // $urlTagMap->save();
    }
    dd('success');
  }


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
});



//actual rooutes goes here
Route::group(['domain' => env('APP_HOST')], function () {

    Route::post('/check_custom' , 'HomeController@check_custom');
    Route::get('test' , function(){
        return view('test');
    });
    Route::post('/test' , 'HomeController@test');

    Route::get('/', [
        'uses' => 'HomeController@getIndex',
        'as' => 'getIndex',
    ]);

    Route::get('/api_test' , 'HomeController@api_test');

    Route::get('/short_url_api' , 'HomeController@short_url_api');

    Route::get('/blog' , 'HomeController@blog');
    Route::get('/pricing' , 'HomeController@pricing');
    Route::get('/features' , 'HomeController@features');
    Route::get('/about' , 'HomeController@about');

    Route::get('/{url}', [
        'uses' => 'HomeController@getRequestedUrl',
        'as' => 'getRequestedUrl',
    ]);

    Route::get('/{subdirectory}/{url}', [
        'uses' => 'HomeController@getRequestedSubdirectoryUrl',
        'as' => 'getRequestedSubdirectoryUrl',
    ]);

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

Route::group(['domain' => '{subdomain}.'.env('APP_HOST')], function () {
    Route::get('/', function ($subdomain) {
        return redirect()->route('getIndex');
    });

    Route::get('/{url}', [
        'uses' => 'HomeController@getRequestedSubdomainUrl',
        'as' => 'getRequestedSubdomainUrl',
    ]);
});
