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
use App\UrlFeature;
use App\UrlSearchInfo;
use App\UrlTag;
use App\UrlTagMap;
use App\PasswordReset;

use App\Http\Requests\ForgotPasswordRequest;

class HomeController extends Controller
{
    /**
     * Get Application index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_custom(Request $request)
    {
        $uid =  \Auth::user()->id;
        $cust_url = trim($request->custom_url);
        $url = Url::where('shorten_suffix' , $cust_url)->first();
        if($url == null)
            return 1;
        return 0;
    }

    public function forgotPassword() {
      if (\Auth::check()) {
          return redirect()->action('HomeController@getDashboard');
      } else {
          return view('settings.forgot_password');
      }
    }

    /** Sending mail with reset password link to user */
    public function forgotPasswordEmail(Request $request) {
      $v = \Validator::make($request->all(), [
          'email' => 'required|email|exists:users',
      ]);

      if($v->fails()) {
        \Session::flash('errs',$v->errors()->first('email'));
        return \Redirect::back();
      } else {
        try {
          $email = $request->email;

          $user    = User::where('email',$email)->first();
          $subject = 'Reset your password here!';
          $token = str_random(64);
          $reset = new PasswordReset();
          $reset->email = $user->email;
          $reset->token = $token;
          $reset->created_at = date('Y-m-d h:i:j');
          $reset->save();
          $url = url('/') . '/reset-password/' . base64_encode($user->email) . '/' . $token;
          $data    = array('name'=>$user->name,'url' => $url,'email' => $user->email);
          
          \Mail::send('mail.forgetPassword', $data, function($message) use($email,$user,$subject){
           $message->to($email, config('settings.company_name'))->subject($subject);
           $message->from('work@tier5.us',$user->name);
          });

          \Session::flash('success','Reset Password link send through mail. please check your mail.');
          return \Redirect::back();
        } catch (\Exception $e) {
          \Session::flash('errs',$e->getMessage());
          //\Session::flash('errs','It seems like the mail server is busy! Try again after a few minutes');
          return redirect()->back();
        }
      }
    }


    public function resetPassword(Request $request) {
      if (\Auth::check()) {
          return redirect()->action('HomeController@getDashboard');
      } else {
        $email = base64_decode($request->email);
        return view('settings.reset_password')->with('email',$email);
      }
    }

    // public function test(Request $request)
    // {
    //     //$a = $this->getPageTitle($request->url);
    //     $b = $this->getPageMetaContents($request->url);
    //     dd($b)
    //     return \Response::json(array('url'=>$a));
    // }

    public function testnow($url) {
        $url = 'https://www.invoicingyou.com/';
        //$a = $this->getPageTitle($request->url);
        $b = $this->getPageMetaContents($url);
        dd($b);
    }

    /** updating password  to user table */
    public function setPassword(Request $request) {
      $v = \Validator::make($request->all(), [
          'email' => 'required|email|exists:users',
          'password' => 'required',
          'password_confirmation' => 'required|same:password',
      ]);

      if($v->fails()) {
        $error_message = $v->errors()->first('email').'  '.$v->errors()->first('password_confirmation');
        \Session::flash('errs',$error_message);
        return \Redirect::back();
      } else {
        try {
          $reset = PasswordReset::where('email', $request->email)->where('token', $request->token)->first();
          $user = User::where('email', $request->email)->first();
          if ($user != null || $reset) {
              $user->password = bcrypt($request->password);
              $user->save();
              $password = PasswordReset::where('email', $user->email)->delete();
              
              Auth::attempt(['email' => $request->email, 'password' => $request->password]);
              return redirect()->action('HomeController@getDashboard' )
                        ->with('success', 'Password Reset Completed Successfully!');
             
          } else {

              $err_mesg = ($reset) ? 'Token is Invalid' : 'This email address does not exists';  
             \Session::flash('errs',$e->getMessage());
          }
        } catch (\Exception $e) {
          \Session::flash('errs',$e->getMessage());
          //\Session::flash('errs','It seems like the mail server is busy! Try again after a few minutes');
          return redirect()->back();
        }
      }
    }


    public function getIndex()
    {

        if (Auth::check()) {
            return redirect()->action('HomeController@getDashboard');
        } else {
            Session::put('login_error' , 'incorect username or password');
            return view('index1');
        }
    }

    public function blog()
    {
        return view('top_menu.blog');
    }

    public function pricing()
    {

        if (Auth::check())
        {
            return redirect()->action('HomeController@getSubscribe');
        }
        else
        {
            return view('top_menu.pricing' , [
                        'user' => null,
                        'subscription_status' => -1,
                    ]);
        }
    }

    public function features()
    {
        return view('top_menu.features');
    }

    public function about()
    {
        return view('top_menu.about');
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
        //dd($url);
        $search = Url::where('shorten_suffix', $url)->first();
        $url_features = UrlFeature::where('url_id', $search->id)->first();
        if ($search) {
            return view('loader2', ['url' => $search, 'url_features' => $url_features]);
        } else {
            abort(404);
        }
    }

    public function giveMyTags(Request $request){
      if(\Auth::user()) {
        $userId = \Auth::user()->id;
        $urlTags = UrlTag::whereHas('urlTagMap.url',function($q) use($userId) {
                      $q->where('user_id',$userId);
                    })->pluck('tag')->toArray();

        return \Response::json([
          'status'  =>  200,
          'data'    =>  $urlTags
        ]);
      }
    }

    private function getDataOfSearchTags($textToSearch = '', $tagsToSearch = '', $userId) {
      // $textToSearch = $request->textToSearch;
      // $tagsToSearch = $request->tagsToSearch;
      $flag = 0;
      if(strlen($textToSearch) > 0 || strlen($tagsToSearch) > 0){
        $urls = Url::where('user_id', $userId);
        if(strlen($textToSearch) > 0) {
          $urls = $urls->whereHas('urlSearchInfo', function($q) use($textToSearch) {
            $q->whereRaw("MATCH (description) AGAINST ('".$textToSearch."' IN BOOLEAN MODE)");
          });
          $flag = 1;
        }
        if(strlen($tagsToSearch) > 0) {
          $condition = $flag == 0 ? 'whereHas' : 'orWhereHas';
          $urls = $urls->$condition('urlTagMap', function($q) use($tagsToSearch) {
            $q->whereHas('urlTag', function($q2) use($tagsToSearch) {
              $refinedTags = str_replace($tagsToSearch,',',' ');
              $q2->whereRaw("MATCH (tag) AGAINST ('".$tagsToSearch."' IN BOOLEAN MODE)");
            });
          });
        }
        //print_r($urls->toSql());die();
        $urls = $urls->get();
        $count_url = $urls->count();
        return [
          'urls' => $urls,
          'count_url' => $count_url
        ];
      } else {

        $urls = Url::where('user_id', $userId)
                ->orderBy('id', 'DESC')
                ->get();
        $count_url = $urls->count();

        return [
          'urls' => $urls,
          'count_url' => $count_url
        ];
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

        //print_r("<pre>");print_r($request->all());

        $textToSearch = $request->textToSearch;
        $tagsToSearch = $request->tagsToSearch;
        // if(strlen($textToSearch) > 0 || strlen($tagsToSearch) > 0){
        //   $urls = Url::where('user_id', $user->id);
        //   if(strlen($textToSearch) > 0) {
        //     $urls = $urls->whereHas('urlSearchInfo', function($q) use($textToSearch) {
        //       $q->whereRaw("MATCH (description) AGAINST ('".$textToSearch."' IN BOOLEAN MODE)");
        //     });
        //   }
        //   if(strlen($tagsToSearch) > 0) {
        //     $urls = $urls->whereHas('urlTagMap', function($q) use($tagsToSearch) {
        //       $q->whereHas('urlTag', function($q2) use($tagsToSearch) {
        //         $refinedTags = str_replace($tagsToSearch,',',' ');
        //         //$q2->query(\DB::raw('selct tag from url_tags WHERE MATCH (tag) AGAINST ('.$refinedTags.')'));
        //         $q2->whereRaw("MATCH (tag) AGAINST ('".$tagsToSearch."' IN BOOLEAN MODE)");
        //       });
        //       //$q->select(\DB::raw('WHERE MATCH (description) AGAINST ('.$textToSearch.')'));
        //     });
        //   }
        //   $urls = $urls->get();
        //   $count_url = $urls->count();
        // } else {
        //
        // $urls = Url::where('user_id', $request->user_id)
        //             ->orderBy('id', 'DESC')
        //             ->get();
        // }

        $ret        = self::getDataOfSearchTags($textToSearch, $tagsToSearch, $request->user_id);
        $urls       = $ret['urls'];
        $count_url  = $ret['count_url'];

        $URLs = [];
        $URLstat = [];
        foreach ($urls as $key => $url) {

          if(isset($url->subdomain)) {
            if($url->subdomain->type == 'subdomain') {
              //$URLs[$key]['name']       = 'https://'.$url->subdomain->name.'.'.env('APP_HOST').'/'.$url->shorten_suffix;
              $URLs[$key]['name']       = 'http:/'.'/'.$url->subdomain->name.'.'.env( 'APP_REDIRECT_HOST' ).'/'.$url->shorten_suffix;
              $URLs[$key]['drilldown']  = $URLs[$key]['name'];
            }
            else if($url->subdomain->type == 'subdirectory') {
              //$URLs[$key]['name'] = route('getIndex').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
              $URLs[$key]['name']       = 'http:/'.'/'.env('APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
              $URLs[$key]['drilldown']  = $URLs[$key]['name'];
            }
          }
          else {
            //$URLs[$key]['name'] = route('getIndex').'/'.$url->shorten_suffix;
            $URLs[$key]['name'] = 'http:/'.'/'.env( 'APP_REDIRECT_HOST' ).'/'.$url->shorten_suffix;
            $URLs[$key]['drilldown']  = $URLs[$key]['name'];
          }


            //$URLs[$key]['name'] = url('/').'/'.$url->shorten_suffix;
            $URLs[$key]['y'] = (int) $url->count;
            //$URLs[$key]['drilldown'] = url('/').'/'.$url->shorten_suffix;

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
            'status'  => 'success',
            'user_id' => $request->user_id,
            'urls'    => $URLs,
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
    {   //print_r("<pre>");print_r($request->all());
        $start_date = new \DateTime($request->start_date);
        $end_date = new \DateTime($request->end_date);

        $date_range = new \DatePeriod($start_date, new \DateInterval('P1D'), $end_date);

        $chartData = [];
        $stat = [];
        $statData = [];
        foreach ($date_range as $key => $date) {
            $chartData[$key]['name'] = $date->format('M d');
            $urls = DB::table('referer_url')
                            ->selectRaw('distinct(url_id) as id')
                            ->join('urls', 'urls.id', '=', 'referer_url.url_id')
                            ->where('referer_url.created_at', 'like', $date->format('Y-m-d').' %')
                            ->where('urls.user_id', $request->user_id)
                            ->get();
            foreach ($urls as $index => $url) {
                $stat = DB::table('referer_url')
                            ->selectRaw('urls.shorten_suffix, count(referer_url.url_id) as clicks')
                            ->join('urls', 'urls.id', '=', 'referer_url.url_id')
                            ->where('referer_url.url_id', $url->id)
                            ->where('urls.user_id', $request->user_id)
                            ->where('referer_url.created_at', 'like', $date->format('Y-m-d').' %')
                            ->groupBy('referer_url.url_id')
                            ->first();
                if ($stat) {
                    $statData[$key][$index][0] = url('/').'/'.$stat->shorten_suffix;
                    $statData[$key][$index][1] = (int) $stat->clicks;
                } else {
                    $statData[$key][$index][0] = 0;
                    $statData[$key][$index][1] = 0;
                }
            }
            $chartData[$key]['drilldown'] = $date->format('M d');
            //$urls = RefererUrl::where('created_at', 'like', $date->format('Y-m-d').' %')->get();
            $clicks = DB::table('referer_url')
                            ->selectRaw('count(url_id) as count')
                            ->join('urls', 'urls.id', '=', 'referer_url.url_id')
                            ->where('referer_url.created_at', 'like', $date->format('Y-m-d').' %')
                            ->where('urls.user_id', $request->user_id)
                            ->first();
            if ($clicks) {
                $chartData[$key]['y'] = (int) $clicks->count;
            } else {
                $chartData[$key]['y'] = 0;
            }
            $chartData[$key]['year'] = $date->format('Y');
        }

        return response()->json([
            'status' => 'success',
            'chartData' => $chartData,
            'statData' => $statData,
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
        $url = Url::find($request->url_id);

        $clicks = DB::table('country_url')
                        ->selectRaw('substr(country_url.created_at, 1, 11) as date, count(country_url.created_at) as clicks')
                        ->join('countries', 'countries.id', '=', 'country_url.country_id')
                        ->where('country_url.url_id', $request->url_id)
                        ->where('country_url.country_id', $request->country_id)
                        ->groupBy('date')
                        ->get();
        $chartData = [];

        foreach ($clicks as $key => $click) {
            $chartData[$key]['name'] = date('M d, Y', strtotime($click->date));
            $chartData[$key]['y'] = (int) $click->clicks;
        }

        return response()->json([
            'status' => 'success',
            'chartData' => $chartData,
            'url' => $url,
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
    public function getAnalyticsByDate($url,$date)
    {
        //dd($url,$date);
        if (Auth::check()) {
            $user = Auth::user();
            $date = date('Y-m-d', strtotime($date));
            $url = DB::table('urls')->where('urls.shorten_suffix', $url)
                    ->join('country_url', 'urls.id', '=', 'country_url.url_id')
                    ->join('browser_url', 'urls.id', '=', 'browser_url.url_id')
                    ->join('platform_url', 'urls.id', '=', 'platform_url.url_id')
                    ->join('referer_url', 'urls.id', '=', 'referer_url.url_id')
                    ->selectRaw('distinct(urls.id) as url_id')
                    ->where('country_url.created_at', 'like', $date.'%')
                    ->where('browser_url.created_at', 'like', $date.'%')
                    ->where('platform_url.created_at', 'like', $date.'%')
                    ->where('referer_url.created_at', 'like', $date.'%')
                    ->first();
                    //dd($url);
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

    public function getAnalyticsBySubdirectoryDate($url,$subdirectory,$date)
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
        //die();
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
        //print_r($request->all());die();
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

            $find = Url::find($request->url);
            $find->count = $find->count + 1;
            $find->save();

            $referer->urls()->attach($request->url);
            global $status;
            $status = 'success';
        } else {
            $referer = new Referer();
            $referer->name = $request->referer;
            $referer->save();

            $u = Url::where('id' , $request->url)->first();
            $u->count++;
            $u->save();

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

    public function short_url_api(Request $request)
    {

        try{
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

        //$_url = $this->getPageTitle($request->url);
        //$url->title = $_url;

        $meta_data = $this->getPageMetaContents($request->url);
        $url->title           = $meta_data['title'];

        //facebook data
        $url->og_image        = $meta_data['og_image'];
        $url->og_description  = $meta_data['og_description'];
        $url->og_url          = $meta_data['og_url'];
        $url->og_title        = $meta_data['og_title'];

        //twitter data
        $url->twitter_image   = $meta_data['twitter_image'] == null ? $meta_data['og_image'] : $meta_data['twitter_image'];
        $url->og_description  = $meta_data['twitter_description'];
        $url->og_url          = $meta_data['twitter_url'];
        $url->og_title        = $meta_data['twitter_title'];

        //meta description
        $url->meta_description = $meta_data['meta_description'];

        $url->user_id = 0;

        if ($url->save()) {
            return json_encode([
                'status' => 'success',
                'url' => url('/').'/'.$random_string,
            ]);
        } else {
            return json_encode([
                'status' => 'error (May be this site has blocked curl services) ',
                'url'    => ''
                ]);
        }





        }
        catch(\Exception $e)
        {
            return json_encode([
                'status' => 'unrecognized url (check if you have inserted your url correctly , and give full url path with http or https)',
                'url'    => ''
                ]);
        }


    }

    public function api_test()
    {
        return view('api_test');
    }



    private function setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$urlId) {
      $urlTagMap = [];
      if($allowTags && count($searchTags) > 0) {
        foreach ($searchTags as $key => $tag) {
          $urlTag     = UrlTag::firstOrCreate(['tag'=>$tag]);
          $urlTagMap  = new UrlTagMap;
          $urlTagMap->url_id = $urlId;
          $urlTagMap->url_tag_id = $urlTag->id;
          $urlTagMap->save();
        }
      }

      if($allowDescription && strlen($searchDescription) > 0) {
        $urlSearchInfo = new UrlSearchInfo;
        $urlSearchInfo->url_id = $urlId;
        $urlSearchInfo->description = $searchDescription;
        $urlSearchInfo->save();
      }
    }



    public function postShortUrlTier5(Request $request)
    {

      try{

        //facebook pixel id
        $checkboxAddFbPixelid = isset($request->checkboxAddFbPixelid) && $request->checkboxAddFbPixelid == true ? true : false;
        $fbPixelid            = isset($request->fbPixelid) && strlen($request->fbPixelid) > 0 ? $request->fbPixelid : null;

        //google pixel id
        $checkboxAddGlPixelid = isset($request->checkboxAddGlPixelid) && $request->checkboxAddGlPixelid == true ? true : false;
        $glPixelid            = isset($request->glPixelid) && strlen($request->glPixelid) > 0 ? $request->glPixelid : null;

        //set tags and description for search for a url
        $allowTags            = isset($request->allowTag) && $request->allowTag == true ? true : false;
        $searchTags           = isset($request->tags) && count($request->tags) > 0 ? $request->tags : null;

        $allowDescription     = isset($request->allowDescription) && $request->allowDescription == true ? true : false;
        $searchDescription    = isset($request->searchDescription) && strlen($request->searchDescription) > 0 ? $request->searchDescription : null;


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

        //$_url = $this->getPageTitle($request->url);
        //$url->title = $_url;
        $meta_data = $this->getPageMetaContents($request->url);
        $url->title           = $meta_data['title'];

        //facebook data
        $url->og_image        = $meta_data['og_image'];
        $url->og_description  = $meta_data['og_description'];
        $url->og_url          = $meta_data['og_url'];
        $url->og_title        = $meta_data['og_title'];

        //twitter data
        $url->twitter_image         = $meta_data['twitter_image'] == null ? $meta_data['og_image'] : $meta_data['twitter_image'];
        $url->twitter_description   = $meta_data['twitter_description'];
        $url->twitter_url           = $meta_data['twitter_url'];
        $url->twitter_title         = $meta_data['twitter_title'];

        //meta description
        $url->meta_description = $meta_data['meta_description'];
        $url->user_id = $request->user_id;

        if ($url->save()) {
          if(($checkboxAddFbPixelid && $fbPixelid != null) || $checkboxAddGlPixelid && $glPixelid != null) {

            $urlfeature = new UrlFeature();
            $urlfeature->url_id = $url->id;
            if($checkboxAddFbPixelid && $fbPixelid != null) {
              $urlfeature->fb_pixel_id = $fbPixelid;
            }
            if($checkboxAddGlPixelid && $glPixelid != null) {
              $urlfeature->gl_pixel_id = $glPixelid;
            }

            if($urlfeature->save()) {

              $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

              return response()->json([
                    'status' => 'success',
                    'url' => url('/').'/'.$random_string,
              ]);
            } else {
              return response()->json(['status' => 'error']);
            }
          } else {

              $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

              return response()->json([
                    'status' => 'success',
                    'url' => url('/').'/'.$random_string,
              ]);
          }
        } else {
            return response()->json(['status' => 'error']);
        }
      }
      catch(\Exception $e) {
        return response()->json(['status' => 'error', 'msg' => $e->getMessage(), 'line' => $e->getLine()]);
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
      try {

        //facebook pixel id
        $checkboxAddFbPixelid = isset($request->checkboxAddFbPixelid) && $request->checkboxAddFbPixelid == true ? true : false;
        $fbPixelid            = isset($request->fbPixelid) && strlen($request->fbPixelid) > 0 ? $request->fbPixelid : null;

        //google pixel id
        $checkboxAddGlPixelid = isset($request->checkboxAddGlPixelid) && $request->checkboxAddGlPixelid == true ? true : false;
        $glPixelid            = isset($request->glPixelid) && strlen($request->glPixelid) > 0 ? $request->glPixelid : null;

        //set tags and description for search for a url
        $allowTags            = isset($request->allowTag) && $request->allowTag == true ? true : false;
        $searchTags           = isset($request->tags) && count($request->tags) > 0 ? $request->tags : null;

        $allowDescription     = isset($request->allowDescription) && $request->allowDescription == true ? true : false;
        $searchDescription    = isset($request->searchDescription) && strlen($request->searchDescription) > 0 ? $request->searchDescription : null;


        //print("<pre>");print_r($request->all());
        //die();

        if (starts_with($request->actual_url, 'https://')) {
            $actual_url = str_replace('https://', null, $request->actual_url);
        } else {
            $actual_url = str_replace('http://', null, $request->actual_url);
        }
        $url = new Url();
        $url->actual_url = $actual_url;
        $url->shorten_suffix = $request->custom_url;

        //$_url = $this->getPageTitle($request->actual_url);
        //$url->title = $_url;

        $meta_data = $this->getPageMetaContents($request->actual_url);
        $url->title           = $meta_data['title'];

        //facebook data
        $url->og_image        = $meta_data['og_image'];
        $url->og_description  = $meta_data['og_description'];
        $url->og_url          = $meta_data['og_url'];
        $url->og_title        = $meta_data['og_title'];

        //twitter data
        $url->twitter_image         = $meta_data['twitter_image'] == null ? $meta_data['og_image'] : $meta_data['twitter_image'];
        $url->twitter_description   = $meta_data['twitter_description'];
        $url->twitter_url           = $meta_data['twitter_url'];
        $url->twitter_title         = $meta_data['twitter_title'];

        //meta description
        $url->meta_description = $meta_data['meta_description'];

        $url->user_id = $request->user_id;
        $url->is_custom = 1;
        if ($url->save()) {

          if(($checkboxAddFbPixelid && $fbPixelid != null) || $checkboxAddGlPixelid && $glPixelid != null) {

            $urlfeature = new UrlFeature();
            $urlfeature->url_id = $url->id;
            if($checkboxAddFbPixelid && $fbPixelid != null) {
              $urlfeature->fb_pixel_id = $fbPixelid;
            }
            if($checkboxAddGlPixelid && $glPixelid != null) {
              $urlfeature->gl_pixel_id = $glPixelid;
            }

            if($urlfeature->save()) {

              $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

              return response()->json([
                    'status' => 'success',
                    'url' => url('/').'/'.$url->shorten_suffix,
              ]);
            } else {
              return response()->json(['status' => 'error']);
            }
          } else {

              $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

              return response()->json([
                    'status' => 'success',
                    'url' => url('/').'/'.$url->shorten_suffix,
              ]);
          }

        } else {
            return response()->json(['status' => 'error']);
        }
      } catch(\Exception $e) {
        return response()->json(['status' => 'error', 'msg'=>$e->getMessage()]);
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
     * Fetch the meta data [title, description, url, image] of an actual url.
     *
     * @param string $url
     *
     * @return array
     */
    private function getPageMetaContents($url)
    {
      //$url = 'https://www.invoicingyou.com/';
      $html = file_get_contents($url);

      //reduction of https://www.invoicingyou.com/dashboard to invoicingyou.com
      //$filtered_url = explode('/',$url);
      //$final_url = null;
      /*if(strpos($filtered_url[2],'www.') && isset($filtered_url[2]) && strpos($filtered_url[2],'.')) {
        $final_url = (substr($filtered_url[2],strpos($filtered_url[2],'.')+1,strlen($filtered_url[2])));
      } else {
        $final_url = $filtered_url[2];
      }*/


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
                      $meta['og_url'] = $url;
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
                      $meta['twitter_url'] = $url;
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
      return $meta;
    }
    // https://www.google.co.in/search?client=ubuntu&channel=fs&q=google&ie=utf-8&oe=utf-8&gfe_rd=cr&ei=Dd5XWLrMAdL08weqgq_ACw



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
            $random_string = $random_string.$character_set[rand(0, strlen($character_set)-1)];
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
            'loginemail' => 'required|email',
            'loginpassword' => 'required',
        ]);

        if(isset($request->__plan)) \Session::flash('planin' , $request->_plan);

        Session::flash('login_err' , 'Incorrect Username or Password');
        if (Auth::attempt(['email' => $request->loginemail, 'password' => $request->loginpassword], $request->remember)) {
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
       //dd($request->all());
        $v = \Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            //'g-recaptcha-response' => 'recaptcha',
        ]);

        if($v->fails())
        {
            \Session::flash('registration_err' , 'Please follow the registration rules and try again..!!');
            return redirect()->route('getIndex');
        }
        else
        {
            if(isset($request->_plan) && $request->_plan != 0) \Session::put('plan' , $request->_plan);


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

                return redirect()->action('HomeController@getDashboard' )
                        ->with('success', 'You have registered successfully!');
            } else {

                return redirect()->action('HomeController@getDashboard')
                        ->with('success', 'You have not registered successfully.. try again');
            }
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
            //dd(Auth::check());
            if(\Session::has('plan'))
            {
                //return 18745;
                return redirect()->action('HomeController@getSubscribe');
            }
            else
            {
                    $user = Auth::user();
                    //code for search based on tags and description if the params are not empty
                    $textToSearch = $request->textToSearch;
                    $tagsToSearch = $request->tagsToSearch;

                    $ret        = self::getDataOfSearchTags($textToSearch, $tagsToSearch, $user->id);
                    $urls       = $ret['urls'];
                    $count_url  = $ret['count_url'];

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
                    $dates = [];
                    if (isset($request->from) and isset($request->to)) {
                        $filter['type'] = 'date';
                        $filter['start'] = $request->from;
                        $filter['end'] = date('Y-M-d', strtotime('+1 day', strtotime($request->to)));
                        $start_date = new \DateTime($request->from);
                        $end_date = new \DateTime($request->to);
                        $date_range = new \DatePeriod($start_date, new \DateInterval('P1D'), $end_date);
                        foreach ($date_range as $key => $date) {
                            $dates[$key] = $date->format('M d');
                        }
                    }


                    return view('dashboard2', [
                        'count_url' => $count_url,// dynamic
                        'user' => $user,
                        'urls' => $urls,// dynamic
                        'subscription_status' => $subscription_status,
                        'limit' => $limit,
                        'total_links' => $total_links,
                        'filter' => $filter,
                        'dates' => $dates,
                        '_plan' => \Session::has('plan') ? \Session::get('plan') : null,
                    ]);

                    //for new
                    // return view('dashboard_new', [
                    //     'count_url' => $count_url,// dynamic
                    //     'user' => $user,
                    //     'urls' => $urls,// dynamic
                    //     'subscription_status' => $subscription_status,
                    //     'limit' => $limit,
                    //     'total_links' => $total_links,
                    //     'filter' => $filter,
                    //     'dates' => $dates,
                    //     '_plan' => \Session::has('plan') ? \Session::get('plan') : null,
                    // ]);
            }


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

        //dd($request->all());
        $this->validate($request, [
            'brandLogo' => 'image|dimensions:min_width=64px,min_height=64px,max_width:512px,max_height:512px,ratio:1:1',
            'redirectingTime' => 'numeric',
        ]);

        $url = Url::find($request->url_id);

        if ($request->hasFile('brandLogo')) {
            $upload_path ='uploads/brand_images';
            $image_name = $request->brandLogo->getClientOriginalName();
            $request->brandLogo->move($upload_path, $image_name);
            $url->uploaded_path = $upload_path.'/'.$image_name;
        }
        $url->redirecting_time = $request->redirectingTime * 1000;
        $url->redirecting_text_template = $request->redirectingTextTemplate;
        if ($url->save()) {
            //dd($url);
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
        //dd($request->all());
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
        if (Auth::check())
        {
            $user = Auth::user();
            $session_plan = null;
            if(Session::has('plan'))
            {
                $session_plan = Session::get('plan');
                Session::put('plan' , null);
            }
            if ($user->subscribed('main', 'tr5Advanced'))
            {
                return redirect()->action('HomeController@getDashboard');
            }
            elseif ($user->subscribed('main', 'tr5Basic'))
            {

                $subscription_status = 'tr5Basic';

                return view('subscription2', [
                        'user' => $user,
                        'session_plan' => $session_plan,
                        'subscription_status' => $subscription_status,
                    ]);
            }
            else
            {
                $subscription_status = null;
                return view('subscription2', [
                        'user' => $user,
                        'session_plan' => $session_plan,
                        'subscription_status' => $subscription_status,
                    ]);
            }
        }
        else
        {
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
      //return $request->all();
        $user = Auth::user();
        try {
            //return($request->plan);
            //return($user->email);
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

            $url = url('/').'/app/user/subscribe';
            Session::flash('subscription_success','Subscription is completed !');
            return ($url);

            //return redirect()->route('getDashboard')
                    //->with('success', 'Subscription is completed.');
        } catch (Exception $e) {

            $url = url('/').'/app/user/subscribe';
            Session::flash('subscription_error','Subscription is incomplete!');
            return ($url);


            //return back()->with('success ..', $e->getMessage());
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
        //dd($subdomain, $url);
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
        //dd($subdirectory, $url);
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



    // public function getRequestedSubdirectoryUrl($url)
    // {
    //   // dd(1);
    //   $search = Url::where('shorten_suffix', $url)->first();
    //   $url_features = UrlFeature::where('url_id', $search->id)->first();
    //   if ($search) {
    //       return view('loader2', ['url' => $search, 'url_features' => $url_features]);
    //   } else {
    //       abort(404);
    //   }
    // }


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
