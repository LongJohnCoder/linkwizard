<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests;
use App\Url;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
//use App\CountryUrl;
//use App\Events\MailEvent;
//use Event;
//use Exception;
//use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Get Application index page
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        if(Auth::check()) {
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
        $country = Session::get('country');

        if($search) {
            $find = Url::find($search->id);

            $find->countries()->attach($country);
            $find->count = $find->count+1;
            $find->save();

            return view('loader', ['url' => $search->actual_url]);
            //return redirect('http://'.$search->actual_url);
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
    public function postHitCountry(Request $request)
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

        return response()->json([
            'status' => 'success',
            'location' => $location
        ]);
    }

    /**
     * Store a location when a short link is clicked from a country
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postStoreLocation(Request $request)
    {
        $country = Country::where('code', $request->location['country_code'])->first();
        Session::put('country', $country);

        return response()->json([
            'status' => 'success',
            'location' => $request->location
        ]);
    }

    /**
     * Get an URL information on AJAX request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postFetchUrlInfo(Request $request) {
        $url = Url::find($request->id);

        return response()->json([
            'status' => "success",
            'url' => $url
        ]);
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
     * Fetch the title of an actual url
     * 
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    private function getPageTitle($url) {
        $string = file_get_contents($url);
        if(strlen($string) > 0) {
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

        if(Url::where('shorten_suffix', $random_string)->first()) {
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

        if($user->save() && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
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
        if(Auth::check()) {
            $user = Auth::user();
            $urls = Url::where('user_id', $user->id)->get();
            return view('dashboard', [
                'user' => $user,
                'urls' => $urls
            ]);
        } else {
            return redirect()->action('HomeController@getIndex');
        }
    }
}
