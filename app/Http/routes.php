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
Route::get('/test', function(){
  $url = 'https://tier5.us/';

  $html = file_get_contents($url);

  //reduction of https://www.invoicingyou.com/dashboard to invoicingyou.com
  $filtered_url = explode('/',$url);
  $final_url = null;
  if(strpos($filtered_url[2],'www.') && isset($filtered_url[2]) && strpos($filtered_url[2],'.')) {
    $final_url = (substr($filtered_url[2],strpos($filtered_url[2],'.')+1,strlen($filtered_url[2])));
  }
  else {
    $final_url = $filtered_url[2];
  }


  $meta = array();
  $meta['title'] = $meta['meta_description'] = null;
  $meta['og_title'] = $meta['og_description'] = $meta['og_url'] = $meta['og_image'] = null;
  $meta['twitter_title'] = $meta['twitter_description'] = $meta['twitter_url'] = $meta['twitter_image'] = null;
  if (strlen($html) > 0) {
      if (preg_match("/\<title\>(.*)\<\/title\>/i", (string) $html, $title)) {
          $meta['title'] = $title[1];
      }


      $doc = new \DOMDocument();
      @$doc->loadHTML($html);
      $metas = $doc->getElementsByTagName('meta');
      for ($i = 0; $i < $metas->length; $i++)
      {
          $m = $metas->item($i);
          switch ($m->getAttribute('property')) {

            //meta data attributes for fb
            case 'og:title':
                  $meta['og_title'] = $m->getAttribute('content');
              break;
            case 'og:description':
                  $meta['og_description'] = $m->getAttribute('content');
              break;
            case 'og:url':
                  $meta['og_url'] = $final_url != null ? $final_url : $m->getAttribute('content');
              break;
            case 'og:image':
                  $meta['og_image'] = $m->getAttribute('content');
              break;

            default:
              # code...
              break;
          }

          switch($m->getAttribute('name')) {
            //meta data attributes for instagram
            case 'twitter:title':
                  $meta['twitter_title'] = $m->getAttribute('content');
              break;

            case 'twitter:description':
                  $meta['twitter_description'] = $m->getAttribute('content');
              break;
            case 'twitter:url':
                  $meta['twitter_url'] = $final_url != null ? $final_url : $m->getAttribute('content');
              break;
            case 'twitter:image':
                  $meta['twitter_image'] = $m->getAttribute('content');
              break;

            default:
              # code...
              break;
          }

          switch($m->getAttribute('name')) {
            //meta data attributes for instagram

            case 'description':
                  $meta['meta_description'] = $m->getAttribute('content');
              break;

            default:
              # code...
              break;
          }
      }
  }
  if($meta['twitter_url'] == null){
    $meta['twitter_url'] = $final_url;
  }
  dd($meta);
});

Route::get('/test12',function(){
    dd(env('PUBLISHABLE_KEY'));
});

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

    Route::get('/{url}/country/{country}/analytics', [
        'uses' => 'HomeController@getAnalyticsByCountry',
        'as' => 'getAnalyticsByCountry',
    ]);

    Route::group(['prefix' => 'app'], function () {
        Route::group(['prefix' => 'url'], function () {
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
