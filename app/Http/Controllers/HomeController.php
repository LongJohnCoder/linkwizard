<?php

namespace App\Http\Controllers;

use App\Browser;
use App\Country;
use App\Limit;
use App\LinkLimit;
use App\Platform;
use App\Referer;
use App\RefererUrl;
use App\Subdomain;
use App\Url;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Get Application index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        if (Auth::check()) {
            return redirect()->action('HomeController@getDashboard');
        } else {
            return view('index');
        }
    }

    /**
     * Get requested url and serach for the actual url. If found redirect to
     * actual url else show 404.
     *
     * @param string $url
     *
     * @return \Illuminate\Http\Response
     */
    public function getRequestedUrl($url)
    {
        $search = Url::where('shorten_suffix', $url)->first();

        if ($search) {
            $find = Url::find($search->id);
            $find->count = $find->count + 1;
            $find->save();

            return view('loader', ['url' => $search]);
        } else {
            abort(404);
        }
    }

    /**
     * Return URL data for chart.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postFetchChartData(Request $request)
    {
        $urls = Url::where('user_id', $request->user_id)
                    ->orderBy('id', 'DESC')
                    ->get();
        foreach ($urls as $key => $url) {
            $URLs[$key]['name'] = url('/').'/'.$url->shorten_suffix;
            $URLs[$key]['y'] = (int) $url->count;
            $URLs[$key]['drilldown'] = url('/').'/'.$url->shorten_suffix;

            $start_date = DB::table('referer_url')
                ->selectRaw('min(created_at) as `min`')
                ->where('url_id', $url->id)
                ->first()->min;
            $end_date = DB::table('referer_url')
                ->selectRaw('max(created_at) as `max`')
                ->where('url_id', $url->id)
                ->first()->max;
            $alldates = DB::table('referer_url')
                ->select('created_at')
                ->where('url_id', $url->id)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
            $date = [];
            foreach ($alldates as $index => $eachdate) {
                $date[$index] = date('Y-m-d', strtotime($eachdate->created_at));
            }
            $dates = array_unique($date);
            $index = 0;
            $URLstat[$key] = [];
            foreach ($dates as $date) {
                $URLstat[$key][$index][0] = date('M d, Y', strtotime($date));
                $URLstat[$key][$index][1] = (int) DB::table('referer_url')
                        ->selectRaw('count(url_id) as `clicks`')
                        ->where([
                            ['url_id', $url->id],
                            ['created_at', 'like', $date.'%'],
                        ])
                        ->first()->clicks;
                ++$index;
            }
        }

        return response()->json([
            'status' => 'success',
            'user_id' => $request->user_id,
            'urls' => $URLs,
            'urlStat' => $URLstat,
        ]);
    }

    /**
     * Return URL data for chart filtered by date range.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postChartDataFilterDateRange(Request $request)
    {
        $urls = Url::where('user_id', $request->user_id)
                    ->orderBy('id', 'DESC')
                    ->get();

        $start_date = new \DateTime($request->start_date);
        $end_date = new \DateTime($request->end_date);

        $date_range = new \DatePeriod($start_date, new \DateInterval('P1D'), $end_date);

        $chartData = [];
        foreach ($date_range as $key => $date) {
            $chartData[$key]['name'] = $date->format('M d');
            /*$urls = DB::table('referer_url')
                    ->selectRaw('distinct(url_id), count(url_id) as clicks')
                    ->where('created_at', 'like', $date->format('Y-m-d').'%')
                    ->get();*/
            $urls = \App\RefererUrl::where('created_at', 'like', $date->format('Y-m-d').'%')->get();
            if ($urls) {
                $chartData[$key]['y'] = $urls->count();
            } else {
                $chartData[$key]['y'] = 0;
            }
        }

        return response()->json([
            'status' => 'success',
            'chartData' => $chartData,
        ]);
    }

    /**
     * Return URL data by date for chart.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postFetchChartDataByDate(Request $request)
    {
        $chartData = [];
        $key = 0;
        for ($count = 0; $count < 24; $count = $count + 2) {
            if ($count < 10) {
                $prefix = 0;
            } else {
                $prefix = null;
            }
            $countNext = (int) $count + 2;
            if ($countNext == 10) {
                $chartData[$key]['name'] = date('h:i A', strtotime($prefix.$count.':00:00')).' - 10:00 AM';
            } else {
                $chartData[$key]['name'] = date('h:i A', strtotime($prefix.$count.':00:00')).' - '.date('h:i A', strtotime($prefix.$countNext.':00:00'));
            }
            $clicks = DB::table('referer_url')
                        ->selectRaw('count(url_id) as clicks')
                        ->where('url_id', $request->url_id)
                        ->whereBetween('created_at', [
                            $request->date.' '.$prefix.$count.':00:00',
                            $request->date.' '.$prefix.$countNext.':00:00',
                        ])
                        ->first();
            if ($clicks) {
                $chartData[$key]['y'] = (int) $clicks->clicks;
            } else {
                $chartData[$key]['y'] = 0;
            }
            ++$key;
        }

        return response()->json([
            'status' => 'success',
            'chartData' => $chartData,
        ]);
    }

    /**
     * Get Advanced Analytics by Date for a particualr URL.
     *
     * @param Request $request
     * @param string  $url
     * @param string  $date
     * Return URL data by country for chart.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postFetchChartDataByCountry(Request $request)
    {
        $clicks = DB::table('country_url')
                        ->selectRaw('country_url.created_at, count(country_url.created_at) as clicks')
                        ->join('countries', 'countries.id', '=', 'country_url.country_id')
                        ->where('country_url.url_id', $request->url_id)
                        ->where('country_url.country_id', $request->country_id)
                        ->groupBy('country_url.created_at')
                        ->get();
        $chartData = [];

        foreach ($clicks as $key => $click) {
            $chartData[$key]['name'] = date('M d, Y h:i:s A', strtotime($click->created_at));
            $chartData[$key]['y'] = (int) $click->clicks;
        }

        return response()->json([
            'status' => 'success',
            'chartData' => $chartData,
        ]);
    }

    /**
     * Get Advanced Analytics by Date for a particualr URL.
     *
     * @param string  $url
     * @param string  $date
     *
     * @return Illuminate\Http\Response
     */
    public function getAnalyticsByDate($url, $date)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $date = date('Y-m-d', strtotime($date));
            $url = DB::table('urls')
                    ->join('country_url', 'urls.id', '=', 'country_url.url_id')
                    ->join('browser_url', 'urls.id', '=', 'browser_url.url_id')
                    ->join('platform_url', 'urls.id', '=', 'platform_url.url_id')
                    ->join('referer_url', 'urls.id', '=', 'referer_url.url_id')
                    ->selectRaw('distinct(urls.id) as url_id')
                    ->where('country_url.created_at', 'like', $date.'%')
                    ->where('browser_url.created_at', 'like', $date.'%')
                    ->where('platform_url.created_at', 'like', $date.'%')
                    ->where('referer_url.created_at', 'like', $date.'%')
                    ->where('urls.shorten_suffix', $url)
                    ->first();
            if ($url) {
                $url = Url::find($url->url_id);

                return view('analytics.date', ['user' => $user, 'url' => $url, 'date' => $date]);
            } else {
                return redirect()->action('HomeController@getDashboard')
                            ->with('error', 'Sorry, for this inconvenience. There is no analytical records founds on '.date('M d, Y', strtotime($date)));
            }
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }

    /**
     * Get Advanced Analytics by Date for a particualr URL.
     *
     * @param string  $url
     * @param string  $date
     *
     * @return Illuminate\Http\Response
     */
    public function getAnalyticsByCountry($url, $country_code)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $country = Country::where('code', $country_code)->first();

            $url = DB::table('urls')
                    ->join('country_url', 'urls.id', '=', 'country_url.url_id')
                    ->join('browser_url', 'urls.id', '=', 'browser_url.url_id')
                    ->join('platform_url', 'urls.id', '=', 'platform_url.url_id')
                    ->join('referer_url', 'urls.id', '=', 'referer_url.url_id')
                    ->join('countries', 'countries.id', '=', 'country_url.country_id')
                    ->selectRaw('distinct(urls.id) as url_id')
                    ->where('countries.code', $country_code)
                    ->where('urls.shorten_suffix', $url)
                    ->first();
            if ($url) {
                $url = Url::find($url->url_id);

                return view('analytics.country', ['user' => $user, 'url' => $url, 'country' => $country]);
            } else {
                return redirect()->action('HomeController@getDashboard')
                            ->with('error', 'Sorry, for this inconvenience. There is no analytical records founds on '.$country_code);
            }
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }

    /**
     * Get Advanced Analytics by Date for a particualr URL using AJAX.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postAnalyticsByDate(Request $request)
    {
        $location[0][0] = 'Country';
        $location[0][1] = 'Clicks';

        $countries = DB::table('country_url')
                ->join('countries', 'countries.id', '=', 'country_url.country_id')
                ->selectRaw('countries.code AS `code`, count(country_url.country_id) AS `count`')
                ->where('country_url.url_id', $request->url_id)
                ->where('country_url.created_at', 'like', $request->date.'%')
                ->groupBy('country_url.country_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($countries as $key => $country) {
            $location[++$key][0] = $country->code;
            $location[$key][1] = (int) $country->count;
        }

        $operating_system[0][0] = 'Platform';
        $operating_system[0][1] = 'Clicks';

        $platforms = DB::table('platform_url')
                ->join('platforms', 'platforms.id', '=', 'platform_url.platform_id')
                ->selectRaw('platforms.name, count(platform_url.platform_id) AS `count`')
                ->where('platform_url.url_id', $request->url_id)
                ->where('platform_url.created_at', 'like', $request->date.'%')
                ->groupBy('platform_url.platform_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($platforms as $key => $platform) {
            $operating_system[++$key][0] = $platform->name;
            $operating_system[$key][1] = (int) $platform->count;
        }

        $web_browser[0][0] = 'Browser';
        $web_browser[0][1] = 'Clicks';

        $browsers = DB::table('browser_url')
                ->join('browsers', 'browsers.id', '=', 'browser_url.browser_id')
                ->selectRaw('browsers.name, count(browser_url.browser_id) AS `count`')
                ->where('browser_url.url_id', $request->url_id)
                ->where('browser_url.created_at', 'like', $request->date.'%')
                ->groupBy('browser_url.browser_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($browsers as $key => $browser) {
            $web_browser[++$key][0] = $browser->name;
            $web_browser[$key][1] = (int) $browser->count;
        }

        $referring_channel[0][0] = 'Referer';
        $referring_channel[0][1] = 'Clicks';

        $referers = DB::table('referer_url')
                ->join('referers', 'referers.id', '=', 'referer_url.referer_id')
                ->selectRaw('referers.name, count(referer_url.referer_id) AS `count`')
                ->where('referer_url.url_id', $request->url_id)
                ->where('referer_url.created_at', 'like', $request->date.'%')
                ->groupBy('referer_url.referer_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($referers as $key => $referer) {
            if ($referer->name == null) {
                $referring_channel[++$key][0] = 'Dark Traffic';
            } else {
                $referring_channel[++$key][0] = $referer->name;
            }
            $referring_channel[$key][1] = (int) $referer->count;
        }

        return response()->json([
            'status' => 'success',
            'location' => $location,
            'platform' => $operating_system,
            'browser' => $web_browser,
            'referer' => $referring_channel,
        ]);
    }

    /**
     * Get Advanced Analytics by Country for a particualr URL using AJAX.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postAnalyticsByCountry(Request $request)
    {
        $operating_system[0][0] = 'Platform';
        $operating_system[0][1] = 'Clicks';

        $platforms = DB::table('platform_url')
                ->join('platforms', 'platforms.id', '=', 'platform_url.platform_id')
                ->join('country_url', 'country_url.url_id', '=', 'platform_url.url_id')
                ->selectRaw('platforms.name, count(platform_url.platform_id) as `count`')
                ->where('platform_url.url_id', $request->url_id)
                ->where('country_url.country_id', $request->country_id)
                ->groupBy('platform_url.platform_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($platforms as $key => $platform) {
            $operating_system[++$key][0] = $platform->name;
            $operating_system[$key][1] = sqrt($platform->count);
        }

        $web_browser[0][0] = 'Browser';
        $web_browser[0][1] = 'Clicks';

        $browsers = DB::table('browser_url')
                ->join('browsers', 'browsers.id', '=', 'browser_url.browser_id')
                ->join('country_url', 'country_url.url_id', '=', 'browser_url.url_id')
                ->selectRaw('browsers.name, count(browser_url.browser_id) as `count`')
                ->where('browser_url.url_id', $request->url_id)
                ->where('country_url.country_id', $request->country_id)
                ->groupBy('browser_url.browser_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($browsers as $key => $browser) {
            $web_browser[++$key][0] = $browser->name;
            $web_browser[$key][1] = sqrt($browser->count);
        }

        $referring_channel[0][0] = 'Referer';
        $referring_channel[0][1] = 'Clicks';

        $referers = DB::table('referer_url')
                ->join('referers', 'referers.id', '=', 'referer_url.referer_id')
                ->join('country_url', 'country_url.url_id', '=', 'referer_url.url_id')
                ->selectRaw('referers.name, count(referer_url.referer_id) as `count`')
                ->where('referer_url.url_id', $request->url_id)
                ->where('country_url.country_id', $request->country_id)
                ->groupBy('referer_url.referer_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($referers as $key => $referer) {
            if ($referer->name == null) {
                $referring_channel[++$key][0] = 'Dark Traffic';
            } else {
                $referring_channel[++$key][0] = $referer->name;
            }
            $referring_channel[$key][1] = sqrt($referer->count);
        }

        return response()->json([
            'status' => 'success',
            'platform' => $operating_system,
            'browser' => $web_browser,
            'referer' => $referring_channel,
        ]);
    }

    /**
     * Return analytics data.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postFetchAnalytics(Request $request)
    {
        $location[0][0] = 'Country';
        $location[0][1] = 'Clicks';

        $countries = DB::table('country_url')
                ->join('countries', 'countries.id', '=', 'country_url.country_id')
                ->selectRaw('countries.code AS `code`, count(country_url.country_id) AS `count`')
                ->where('country_url.url_id', $request->url_id)
                ->groupBy('country_url.country_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($countries as $key => $country) {
            $location[++$key][0] = $country->code;
            $location[$key][1] = (int) $country->count;
        }

        $operating_system[0][0] = 'Platform';
        $operating_system[0][1] = 'Clicks';

        $platforms = DB::table('platform_url')
                ->join('platforms', 'platforms.id', '=', 'platform_url.platform_id')
                ->selectRaw('platforms.name, count(platform_url.platform_id) AS `count`')
                ->where('platform_url.url_id', $request->url_id)
                ->groupBy('platform_url.platform_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($platforms as $key => $platform) {
            $operating_system[++$key][0] = $platform->name;
            $operating_system[$key][1] = (int) $platform->count;
        }

        $web_browser[0][0] = 'Browser';
        $web_browser[0][1] = 'Clicks';

        $browsers = DB::table('browser_url')
                ->join('browsers', 'browsers.id', '=', 'browser_url.browser_id')
                ->selectRaw('browsers.name, count(browser_url.browser_id) AS `count`')
                ->where('browser_url.url_id', $request->url_id)
                ->groupBy('browser_url.browser_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($browsers as $key => $browser) {
            $web_browser[++$key][0] = $browser->name;
            $web_browser[$key][1] = (int) $browser->count;
        }

        $referring_channel[0][0] = 'Referer';
        $referring_channel[0][1] = 'Clicks';

        $referers = DB::table('referer_url')
                ->join('referers', 'referers.id', '=', 'referer_url.referer_id')
                ->selectRaw('referers.name, count(referer_url.referer_id) AS `count`')
                ->where('referer_url.url_id', $request->url_id)
                ->groupBy('referer_url.referer_id')
                ->orderBy('count', 'DESC')
                ->get();

        foreach ($referers as $key => $referer) {
            if ($referer->name == null) {
                $referring_channel[++$key][0] = 'Dark Traffic';
            } else {
                $referring_channel[++$key][0] = $referer->name;
            }
            $referring_channel[$key][1] = (int) $referer->count;
        }

        return response()->json([
            'status' => 'success',
            'location' => $location,
            'platform' => $operating_system,
            'browser' => $web_browser,
            'referer' => $referring_channel,
        ]);
    }

    /**
     * Get an User Agent and country Information on AJAX request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postUserInfo(Request $request)
    {
        $status = 'error';

        $country = Country::where('code', $request->country['country_code'])->first();
        if ($country) {
            $country->urls()->attach($request->url);
            global $status;
            $status = 'success';
        } else {
            global $status;
            $status = 'error';
        }

        $platform = Platform::where('name', $request->platform)->first();
        if ($platform) {
            $platform->urls()->attach($request->url);
            global $status;
            $status = 'success';
        } else {
            $platform = new Platform();
            $platform->name = $request->platform;
            $platform->save();
            $platform->urls()->attach($request->url);

            if ($platform) {
                global $status;
                $status = 'success';
            } else {
                global $status;
                $status = 'error';
            }
        }

        $browser = Browser::where('name', $request->browser)->first();
        if ($browser) {
            $browser->urls()->attach($request->url);
            global $status;
            $status = 'success';
        } else {
            $browser = new Browser();
            $browser->name = $request->browser;
            $browser->save();
            $browser->urls()->attach($request->url);

            if ($browser) {
                global $status;
                $status = 'success';
            } else {
                global $status;
                $status = 'error';
            }
        }

        $referer = Referer::where('name', $request->referer)->first();
        if ($referer) {
            $referer->urls()->attach($request->url);
            global $status;
            $status = 'success';
        } else {
            $referer = new Referer();
            $referer->name = $request->referer;
            $referer->save();
            $referer->urls()->attach($request->url);

            if ($referer) {
                global $status;
                $status = 'success';
            } else {
                global $status;
                $status = 'error';
            }
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Get an URL information on AJAX request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postEditUrlInfo(Request $request)
    {
        $url = Url::find($request->id);

        $url->title = $request->title;

        if ($url->save()) {
            return response()->json([
                'status' => 'success',
                'url' => $url,
            ]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Get actual long url on AJAX call and convert it into an random string,
     * save both actual and shorten url into the database and return status as
     * AJAX response.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postShortUrlTier5(Request $request)
    {
        if (starts_with($request->url, 'https://')) {
            $actual_url = str_replace('https://', null, $request->url);
            $protocol = 'https';
        } else {
            $actual_url = str_replace('http://', null, $request->url);
            $protocol = 'http';
        }

        $random_string = $this->randomString();

        $url = new Url();
        $url->actual_url = $actual_url;
        $url->protocol = $protocol;
        $url->shorten_suffix = $random_string;
        $url->title = $this->getPageTitle($request->url);
        $url->user_id = $request->user_id;

        if ($url->save()) {
            return response()->json([
                'status' => 'success',
                'url' => url('/').'/'.$random_string,
            ]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Get actual long url and custom short url on AJAX call and return status as
     * AJAX response.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postCustomUrlTier5(Request $request)
    {
        if (starts_with($request->actual_url, 'https://')) {
            $actual_url = str_replace('https://', null, $request->actual_url);
        } else {
            $actual_url = str_replace('http://', null, $request->actual_url);
        }

        $url = new Url();
        $url->actual_url = $actual_url;
        $url->shorten_suffix = $request->custom_url;
        $url->title = $this->getPageTitle($request->actual_url);
        $url->user_id = $request->user_id;
        $url->is_custom = 1;

        if ($url->save()) {
            return response()->json([
                'status' => 'success',
                'url' => url('/').'/'.$request->custom_url,
            ]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Fetch the title of an actual url.
     *
     * @param string $url
     *
     * @return \Illuminate\Http\Response
     */
    private function getPageTitle($url)
    {
        $string = file_get_contents($url);
        if (strlen($string) > 0) {
            if (preg_match("/\<title\>(.*)\<\/title\>/i", (string) $string, $title)) {
                return $title[1];
            } else {
                return null;
            }
        }
    }

    /**
     * URL suffix random string generator.
     *
     * @return string
     */
    private function randomString()
    {
        $character_set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = null;

        for ($i = 0; $i < 6; ++$i) {
            $random_string = $random_string.$character_set[rand(0, strlen($character_set))];
        }

        if (Url::where('shorten_suffix', $random_string)->first()) {
            $this->RandomString();
        } else {
            return $random_string;
        }
    }

    /**
     * Attempt login a regstered user.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'useremail' => 'required|email',
            'passwordlogin' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->useremail, 'password' => $request->passwordlogin], $request->remember)) {
            return redirect()->action('HomeController@getDashboard');
        } else {
            return redirect()->action('HomeController@getIndex')
                    ->with('error', 'Login unsucessful, cannot matches any credential!');
        }
    }

    /**
     * Attempt sign up a new user.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            //'g-recaptcha-response' => 'recaptcha',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->remember_token = $request->_token;

        if ($user->save() && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $limit = new LinkLimit();
            $limit->user_id = $user->id;
            $limit->limit_of_links = 10;
            $number_of_links = 0;
            $limit->save();

            return redirect()->action('HomeController@getDashboard')
                    ->with('success', 'You have registered successfully!');
        } else {
            return redirect()->route('getIndex')
                    ->with('error', 'Cannot register now, please try after sometime!');
        }
    }

    /**
     * Logout a logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->action('HomeController@getIndex');
    }

    /**
     * Get Dashboard access for resgistered user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $urls = Url::where('user_id', $user->id)
                    ->orderBy('id', 'DESC')
                    ->get();

            $count = DB::table('urls')
                ->selectRaw('count(user_id) AS `count`')
                ->where('user_id', $user->id)
                ->groupBy('user_id')
                ->get();

            $total_links = null;
            if ($count) {
                $total_links = $count[0]->count;
                $limit = LinkLimit::where('user_id', $user->id)->first();
                if ($limit) {
                    $limit->number_of_links = $total_links;
                    $limit->save();
                }
            }

            if ($user->subscribed('main', 'tr5Advanced')) {
                $subscription_status = 'tr5Advanced';
                $limit = Limit::where('plan_code', 'tr5Advanced')->first();
            } elseif ($user->subscribed('main', 'tr5Basic')) {
                $subscription_status = 'tr5Basic';
                $limit = Limit::where('plan_code', 'tr5Basic')->first();
            } else {
                $subscription_status = false;
                $limit = Limit::where('plan_code', 'tr5free')->first();
            }

            $filter = [];
            if (isset($request->from) and isset($request->to)) {
                $filter['type'] = 'date';
                $filter['start'] = $request->from;
                $filter['end'] = date('Y-M-d', strtotime('+1 day', strtotime($request->to)));
            }

            return view('dashboard', [
                'user' => $user,
                'urls' => $urls,
                'subscription_status' => $subscription_status,
                'limit' => $limit,
                'total_links' => $total_links,
                'filter' => $filter,
            ]);
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }

    /**
     * Post a brand logo.
     *
     * @return Illuminate\Http\Response
     */
    public function postBrandLogo(Request $request)
    {
        $this->validate($request, [
            'brandLogo' => 'image|dimensions:min_width=64px,min_height=64px,max_width:512px,max_height:512px,ratio:1:1',
            'redirectingTime' => 'numeric',
        ]);

        $url = Url::find($request->url_id);

        if ($request->hasFile('brandLogo')) {
            $upload_path = 'uploads/brand_images';
            $image_name = $request->brandLogo->getClientOriginalName();
            $request->brandLogo->move($upload_path, $image_name);
            $url->uploaded_path = $upload_path.'/'.$image_name;
        }
        $url->redirecting_time = $request->redirectingTime * 1000;
        $url->redirecting_text_template = $request->redirectingTextTemplate;
        if ($url->save()) {
            return redirect()->back()
                    ->with('success', 'Upload successful.');
        } else {
            return redirect()->back()
                    ->with('error', 'Please try again later.');
        }
    }

    /**
     * Post a brand logo.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postBrandLink(Request $request)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'name' => 'required|unique:subdomains',
                'type' => 'required',
            ]);

            $user = Auth::user();

            $subdomain = new Subdomain();
            $subdomain->name = strtolower($request->name);
            $subdomain->user_id = $user->id;
            $subdomain->url_id = $request->url_id;
            $subdomain->type = $request->type;

            if ($subdomain->save()) {
                return redirect()->back()
                        ->with('success', ucfirst($request->type).' created successfully');
            } else {
                return redirect()->back()
                        ->with('error', 'Can not create subdomain right now. Please try again later!');
            }
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }

    /**
     * Get Subscription form for registered user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubscribe()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->subscribed('main', 'tr5Advanced')) {
                return redirect()->action('HomeController@getDashboard');
            } elseif ($user->subscribed('main', 'tr5Basic')) {
                $subscription_status = 'tr5Basic';

                return view('subscription', [
                        'user' => $user,
                        'subscription_status' => $subscription_status,
                    ]);
            } else {
                $subscription_status = null;

                return view('subscription', [
                        'user' => $user,
                        'subscription_status' => $subscription_status,
                    ]);
            }
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }

    /**
     * Get Subscription details from Stripe about a registered user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSubscription(Request $request)
    {
        $user = Auth::user();
        try {
            $user->newSubscription('main', $request->plan)
                    ->create($request->stripeToken_, [
                        'email' => $user->email,
                    ]);

            $limit = LinkLimit::where('user_id', $user->id)->first();
            if (!isset($limit)) {
                $limit = new LinkLimit();
                $limit->user_id = $user->id;
            }
            if ($request->plan == 'tr5Basic') {
                $limit->limit_of_links = 100;
            } elseif ($request->plan == 'tr5Advanced') {
                $limit->limit_of_links = null;
            } else {
                $limit->limit_of_links = 10;
            }
            $limit->save();

            return redirect()->route('getDashboard')
                    ->with('success', 'Subscription is completed.');
        } catch (Exception $e) {
            return back()->with('success', $e->getMessage());
        }
    }

    /**
     * Get Brand for registered user.
     *
     * @return Illuminate\Http\Response
     */
    public function getAdminDashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_admin == 1) {
                $limits = Limit::all();

                return view('admin', ['user' => $user, 'limits' => $limits]);
            } else {
                return redirect()->action('HomeController@getDashboard');
            }
        }
    }

    /**
     * Post Package Limit.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function postPackageLimit(Request $request)
    {
        $limit = Limit::find($request->id);
        if ($request->has('plan_name')) {
            $limit->plan_name = $request->plan_name;
        }
        $limit->limits = $request->limits;
        if ($limit->save()) {
            return redirect()->back()->with('success', 'Updated!');
        } else {
            return redirect()->back()->with('error', 'Failed to update!');
        }
    }

    /**
     * Get requested brand subdomain url and serach for the actual url.
     * If found redirect to actual url else show 404.
     * 
     * @param  string $subdomain
     * @param  string $url
     * 
     *
     * @param string $subdomain
     * @param string $url
     *
     * @return Illuminate\Http\Response
     */
    public function getRequestedSubdomainUrl($subdomain, $url)
    {
        $redirectUrl = Url::where('shorten_suffix', $url)->first();
        if ($redirectUrl) {
            $subDomain = Subdomain::where('name', $subdomain)
                            ->where('type', 'subdomain')
                            ->where('url_id', $redirectUrl->id)
                            ->first();
            if ($subDomain) {
                echo $this->getRequestedUrl($url);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get requested url branf subdirectory and serach for the actual url.
     * If found redirect to actual url else show 404.
     *
     * @param string $subdirectory
     * @param string $url
     *
     * @return Illuminate\Http\Response
     */
    public function getRequestedSubdirectoryUrl($subdirectory, $url)
    {
        $redirectUrl = Url::where('shorten_suffix', $url)->first();
        if ($redirectUrl) {
            $subDirectory = Subdomain::where('name', $subdirectory)
                            ->where('type', 'subdirectory')
                            ->where('url_id', $redirectUrl->id)
                            ->first();
            if ($subDirectory) {
                echo $this->getRequestedUrl($url);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Check a email is available or not from sign up page
     * 
     * @param  Request $response
     * @return \Illuminate\Http\Response
     */
    public function postEmailCheck(Request $response)
    {
        $user = User::where('email', $response->email)->first();
        if ($user) {
            $exist = true;
        } else {
            $exist = false;
        }

        return response()->json([
            'status' => 'success',
            'exist' => $exist,
        ]);
    }
}
