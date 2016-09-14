<?php

namespace App\Http\Controllers;

use App\Browser;
use App\Country;
use App\Http\Requests;
use App\LinkLimit;
use App\Platform;
use App\Referer;
use App\Url;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Get Application index page
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
     * actual url else show 404
     * 
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    public function getRequestedUrl($url)
    {
        $search = Url::where('shorten_suffix', $url)->first();

        if ($search) {
            $find = Url::find($search->id);
            $find->count = $find->count+1;
            $find->save();

            return view('loader', ['url' => $search]);
        } else {
            abort(404);
        }
    }

    /**
     * Return country list and total clicks from a country of a shorten url
     * 
     * @param  Request $request
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
            $location[$key][1] = (int)$country->count;
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
            $operating_system[$key][1] = (int)$platform->count;
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
            $web_browser[$key][1] = (int)$browser->count;
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
            $referring_channel[$key][1] = (int)$referer->count;
        }

        return response()->json([
            'status' => 'success',
            'location' => $location,
            'platform' => $operating_system,
            'browser' => $web_browser,
            'referer' => $referring_channel
        ]);
    }

    /**
     * Get an User Agent and country Information on AJAX request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postUserInfo(Request $request) {
        $status = 'error';

        $country = Country::where('code', $request->country['country_code'])->first();
        if ($country) {
            $country->urls()->attach($request->url);
            global $status;
            $status = "success";
        } else {
            global $status;
            $status = "error";
        }

        $platform = Platform::where('name', $request->platform)->first();
        if ($platform) {
            $platform->urls()->attach($request->url);
            global $status;
            $status = "success";
        } else {
            $platform = new Platform();
            $platform->name = $request->platform;
            $platform->save();
            $platform->urls()->attach($request->url);
            
            if ($platform) {
                global $status;
                $status = "success";
            } else {
                global $status;
                $status = "error";
            }
        }
        
        $browser = Browser::where('name', $request->browser)->first();
        if ($browser) {
            $browser->urls()->attach($request->url);
            global $status;
            $status = "success";
        } else {
            $browser = new Browser();
            $browser->name = $request->browser;
            $browser->save();
            $browser->urls()->attach($request->url);
            
            if ($browser) {
                global $status;
                $status = "success";
            } else {
                global $status;
                $status = "error";
            }
        }

        $referer = Referer::where('name', $request->referer)->first();
        if ($referer) {
            $referer->urls()->attach($request->url);
            global $status;
            $status = "success";
        } else {
            $referer = new Referer();
            $referer->name = $request->referer;
            $referer->save();
            $referer->urls()->attach($request->url);
            
            if ($referer) {
                global $status;
                $status = "success";
            } else {
                global $status;
                $status = "error";
            }
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Get an URL information on AJAX request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postEditUrlInfo(Request $request) {
        $url = Url::find($request->id);

        $url->title = $request->title;

        if ($url->save()) {
            return response()->json([
                'status' => "success",
                'url' => $url
            ]);
        } else {
            return response()->json(['status' => "error"]);
        }
    }

    /**
     * Get actual long url on AJAX call and convert it into an random string,
     * save both actual and shorten url into the database and return status as
     * AJAX response.
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postShortUrlTier5(Request $request)
    {
        if (starts_with($request->url, "https://")) {
            $actual_url = str_replace("https://", null ,$request->url);
        } else {
            $actual_url = str_replace("http://", null ,$request->url);
        }

        $random_string = $this->randomString();

        $url = new Url();
        $url->actual_url = $actual_url;
        $url->shorten_suffix = $random_string;
        $url->title = $this->getPageTitle($request->url);
        $url->user_id = $request->user_id;

        if($url->save()) {
            return response()->json([
                'status' => "success",
                'url' => url('/').'/'.$random_string
            ]);
        } else {
            return response()->json(['status' => "error"]);
        }
    }

    /**
     * Get actual long url and custom short url on AJAX call and return status as
     * AJAX response.
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postCustomUrlTier5(Request $request)
    {
        if (starts_with($request->actual_url, "https://")) {
            $actual_url = str_replace("https://", null ,$request->actual_url);
        } else {
            $actual_url = str_replace("http://", null ,$request->actual_url);
        }

        $url = new Url();
        $url->actual_url = $actual_url;
        $url->shorten_suffix = $request->custom_url;
        $url->title = $this->getPageTitle($request->actual_url);
        $url->user_id = $request->user_id;

        if($url->save()) {
            return response()->json([
                'status' => "success",
                'url' => url('/').'/'.$request->custom_url
            ]);
        } else {
            return response()->json(['status' => "error"]);
        }
    }

    /**
     * Fetch the title of an actual url
     * 
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    private function getPageTitle($url) {
        $string = file_get_contents($url);
        if (strlen($string) > 0) {
            if (preg_match("/\<title\>(.*)\<\/title\>/i", (string)$string, $title)) {
                return $title[1];
            } else {
                return null;
            }
        }
    }

    /**
     * URL suffix random string generator
     *
     * @return string
     */
    private function randomString()
    {
        $character_set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = null;

        for ($i = 0; $i < 6; $i++) {
            $random_string = $random_string.$character_set[rand(0, strlen($character_set))];
        }

        if (Url::where('shorten_suffix', $random_string)->first()) {
            $this->RandomString();
        } else {
            return $random_string;
        }
    }

    /**
     * Attempt login a regstered user
     * 
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'useremail' => 'required|email',
            'passwordlogin' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->useremail, 'password' => $request->passwordlogin], $request->remember)) {
            return redirect()->action('HomeController@getDashboard')
                    ->with('success', 'You are now logged in!');
        } else {
            return redirect()->action('HomeController@getIndex')
                    ->with('error', 'Login unsucessful, cannot matches any credential!');
        }
    }

    /**
     * Attempt sign up a new user
     * 
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'g-recaptcha-response' => 'recaptcha'
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
    public function getDashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $urls = Url::where('user_id', $user->id)->get();

            $count = DB::table('urls')
                ->selectRaw('count(user_id) AS `count`')
                ->where('user_id', $user->id)
                ->groupBy('user_id')
                ->get();
            $total_links = null;
            if($count) {
                $total_links = $count[0]->count;
                $limit = LinkLimit::where('user_id', $user->id)->first();
                if ($limit) {
                    $limit->number_of_links = $total_links;
                    $limit->save();
                }
            }

            if ($user->subscribed('main', 'tr5Advanced')) {
                $subscription_status = 'tr5Advanced';
            } elseif ($user->subscribed('main', 'tr5Basic')) {
                $subscription_status = 'tr5Basic';
            } else {
                $subscription_status = false;
            }

            return view('dashboard', [
                'user' => $user,
                'urls' => $urls,
                'subscription_status' => $subscription_status,
                'total_links' => $total_links
            ]);
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
                        'subscription_status' => $subscription_status
                    ]);
            } else {
                $subscription_status = null;
                return view('subscription', [
                        'user' => $user,
                        'subscription_status' => $subscription_status
                    ]);
            }
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }

    /**
     * Get Subscription details from Stripe about a registered user.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postSubscription(Request $request)
    {
        $user = Auth::user();
        try {
            $user->newSubscription('main', $request->plan)
                    ->create($request->stripeToken_, [
                        'email' => $user->email
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
}
