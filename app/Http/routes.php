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
Route::get(config('settings.APP_REDIRECT_HOST'),[
        'uses' => 'HomeController@getIndex',
        'as' => 'getIndex',
    ]);

Route::pattern('domain', config('settings.APP_HOST').'|'.config('settings.APP_LOGIN_HOST'));

/**Test Route Start**/
Route::get('/test', function(){
    $url = 'http://insidetech.monster.com/benefits/articles/8537-10-best-tech-blogs';
    dd(app('App\Http\Controllers\HomeController')->getPageMetaContents($url));
});

Route::get('/test12', function () {
    dd(env('PUBLISHABLE_KEY'));
});
/**Test Route Start**/

Route::post('priceRequest', [
    'uses' => 'HomeController@requestForPrice',
    'as' => 'priceRequest',
]);
Route::get('/blog' , 'HomeController@blog');
Route::get('/pricing' , 'HomeController@pricing');
Route::get('/features' , 'HomeController@features');
Route::get('/about' , 'HomeController@about');

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
    Route::post('create-subscriber',[
        'uses'  => 'ApiController@createNewSubscriber',
        'as'    => 'createNewSubscriber'
    ]);

    Route::post('/link/create', [
        'uses' => 'ApiController@createShortLink',
        'as' => 'createShortLink',
    ]);

    Route::any('/authenticate-zapier-key/{api_key}', [
        'uses' => 'ZapierController@authenticateZapierKey',
        'as' => 'authenticateZapierKey',
    ]);

    Route::any('/create/zapier/untrackedlink/{api_key}', [
        'uses' => 'ZapierController@createUntrackedLink',
        'as' => 'createUntrackedLinkFromZapier',
    ]);

    Route::any('/create/zapier/grouplink/{api_key}', [
        'uses' => 'ZapierController@groupMultipleLink',
        'as' => 'createGroupLinkFromZapier',
    ]);

    Route::post('/create/grouplink', [
        'uses' => 'UrlController@createsingleGroupLink',
        'as' => 'createsingleGroupLink',
    ]);

    /*Webhooks*/
    Route::post('suspend-subscriber',[
        'uses'  => 'ApiController@suspendSubsciber',
        'as'    => 'suspendSubsciber'
    ]);
    Route::post('unsuspend-subscriber',[
        'uses'  => 'ApiController@unsuspendSubsciber',
        'as'    => 'unsuspendSubsciber'
    ]);
    /* End Webhooks */
});
/* API routes ends here*/


Route::group(['domain' => config('settings.APP_HOST'), ['middlewareGroups' => 'web']], function () {
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

    Route::post('postShortUrlNoLogin', [
      'uses'  =>  'HomeController@postShortUrlNoLogin',
      'as'    =>  'postShortUrlNoLogin'
    ]);
});

//actual rooutes goes here
Route::group(['domain' => config('settings.APP_LOGIN_HOST'), ['middlewareGroups' => ['web','auth']]], function () {
    Route::post('imgUploader', [
        'uses'  =>  'HomeController@imgUploader',
        'as'    =>  'imgUploader'
    ]);
    Route::post('/check_custom' , 'HomeController@check_custom');

    Route::any('/getallcountry', 'GeoLocationController@getAllCountry');
    Route::post('/getCountryDetails', 'GeoLocationController@getCountryDetails');
    Route::post('/getnotSelectedcountry', 'GeoLocationController@getnotSelectedcountry');
    Route::post('/getDenyCountryInAllowAll', 'GeoLocationController@getDenyCountryInAllowAll');
    
    
    Route::get('test' , function(){
        return view('test');
    });
    Route::post('/test' , 'HomeController@test');
    Route::get('/api_test' , 'HomeController@api_test');
    Route::get('/short_url_api' , 'HomeController@short_url_api');
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

    Route::get('reset-password/{email}/{token}', [
        'uses' => 'HomeController@resetPassword',
        'as' => 'reset-password'
    ]);

    Route::post('set-password', [
        'uses' => 'HomeController@setPassword',
        'as' => 'setPassword'
    ]);

    Route::group(['prefix' => 'app'], function () {
        Route::group(['prefix' => 'url'], function () {
            //search url with links
            Route::get('/{id}/link_preview', [
                'uses' => 'HomeController@getLinkPreview',
                'as' => 'getLinkPreview'
            ]);

            // load retarget pixel view
            Route::get('/pixels', [
                'uses' => 'HomeController@loadPixels',
                'as' => 'pixels'
            ]);

            // Edit url routing
            Route::get('/{id?}/edit_url_view', 'UrlController@editUrlView')->name('edit_url_view');

            /* dashboard delete short url  */
            Route::get('/delete_url/{id?}', 'UrlController@deleteUrl')->name('delete_short_url');

            /* error 404 for linkscheduler */
            Route::get('/error_url', function(){
                return view('errors.404');
            })->name('error_url');

            /**add new tab for special link schedule for ajax*/
            Route::get('/add_tab_schedule', 'HomeController@add_schedule_tab')->name('ajax_schedule_tab');

            Route::post('giveMyTags', [
                'uses'  =>  'HomeController@giveMyTags',
                'as'    =>  'giveMyTags'
            ]);

            Route::post('short', [
                'uses' => 'HomeController@postShortUrlTier5',
                'as' => 'postShortUrlTier5',
            ]);

            Route::post('postShortUrlNoSession', [
                'uses'  =>  'HomeController@postShortUrlNoSession',
                'as'    =>  'postShortUrlNoSession'
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

            /*Route::post('userinfo', [
                'uses' => 'HomeController@postUserInfo',
                'as' => 'postUserInfo',
            ]);*/
            Route::post('userinfo', [
                'uses' => 'UrlController@postUserInfo',
                'as' => 'postUserInfo',
            ]);

            Route::post('analytics-by-date', [
                'uses' => 'HomeController@postAnalyticsByDate',
                'as' => 'postAnalyticsByDate',
            ]);

            Route::post('deleteShortenUrl', [
                'uses' => 'HomeController@deleteShortenUrl',
                'as' => 'deleteShortenUrl',
            ]);

            Route::post('check_suffix_availability', [
                'uses' => 'UrlController@checkSuffixAvailability',
                'as' => 'checkSuffixAvailability',
            ]);

            Route::post('delete/group/link', [
                'uses' => 'UrlController@deleteGroupLink',
                'as' => 'deleteGroupLink',
            ]);

            
        });

        Route::group(['prefix' => 'user'], function () {
            //Settings section for an user
            Route::group(['prefix' => 'settings'], function(){

                Route::get('reset-password-settings',[
                  'uses'  =>  'HomeController@resetPasswordSettings',
                  'as'    =>  'resetPasswordSettings'
                ]);

                Route::get('profile',[
                    'uses'  =>  'UrlController@profile',
                    'as'    =>  'profileSettings'
                ]);

                Route::post('set-password-settings',[
                  'uses'  =>  'HomeController@setPasswordSettings',
                  'as'    =>  'setPasswordSettings'
                ]);

                Route::get('all-settings',[
                  'uses'  =>  'SettingsController@getSettingsPage',
                  'as'    =>  'getSettingsPage'
                ]);

                Route::post('create-zapier-key',[
                  'uses'  =>  'ZapierController@createZapierKey',
                  'as'    =>  'createZapierKey'
                ]);

                Route::post('modify-default-redirect-time',[
                  'uses'  =>  'SettingsController@modifyDefaultRedirectTime',
                  'as'    =>  'modifyDefaultRedirectTime'
                ]);


            });

            Route::post('shortenUrl', [
                'uses' => 'UrlController@creatShortUrl',
                'as'   => 'shortenUrl'
            ]);
            /*******************/
            Route::get('create_shortened_link',[
                'uses'  => 'HomeController@createShortenedLink',
                'as'    => 'createShortenedLink'
            ]);

            Route::get('create_custom_link',[
                'uses'  => 'HomeController@createCustomLink',
                'as'    => 'createCustomLink'
            ]);
            /*******************/
            Route::get('create_link/{type}',[
                'uses'  => 'UrlController@createLink',
                'as'    => 'createLink'
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

            /*******************/
            Route::get('show-group-details/{linkid}',[
                'uses'  => 'UrlController@showGroupDetails',
                'as'    => 'show-group-details'
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
Route::group(['domain' => '{subdomain}.'.config('settings.APP_REDIRECT_HOST'), ['middlewareGroups' => ['web','auth']]], function () {
    Route::get('/{url}', 'HomeController@getRequestedSubdomainUrl');
});
//routing for subdomains ends here

//router for subdirectories
Route::group(['domain' => config('settings.APP_REDIRECT_HOST') , ['middlewareGroups' => ['web','auth']]], function () {
    //Route::get('/{url}', 'HomeController@getRequestedSubdomainUrl');
    Route::get('/{subdirectory}/{url}', [
        'uses' => 'HomeController@getRequestedSubdirectoryUrl',
        'as' => 'getRequestedSubdirectoryUrl',
    ]);

   /* Route::get('/{url}', [
        'uses' => 'HomeController@getRequestedUrl',
        'as' => 'getRequestedUrl',
    ]);*/

    Route::get('/{url}', [
        'uses' => 'UrlController@getRequestedUrl',
        'as' => 'getRequestedUrl',
    ]);

    Route::get('/', [
        'uses' => 'HomeController@redirectUrl',
        'as' => 'redirectUrl',
    ]);
});
//routing for subdirectories ends here
Route::post('/{id?}/editshorturl', 'UrlController@editUrl')->name('edit_short_url');

/*** Edit url routing*/
Route::post('/editurl', 'UrlController@editUrl')->name('edit_url');

//Store pixel for management
Route::post('/savepixel', 'HomeController@savePixels')->name('savepixel');

//Edit pixel for management
Route::post('/editpixel', 'HomeController@editPixels')->name('editpixel');

//Delete pixel for management
Route::post('/deletepixel', 'HomeController@deletePixels')->name('deletepixel');

//Pixel name check
Route::post('/pixelnames', 'UrlController@checkPixelName')->name('pixelnames');

//Pixel name id
Route::post('/pixelids', 'UrlController@checkPixelId')->name('pixelids');

//Store profile informations
Route::post('/saveprofile', 'UrlController@saveProfile')->name('saveprofile');