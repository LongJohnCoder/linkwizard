<?php
    namespace App\Http\Controllers;

    use App\Browser;
    use App\CircularLink;
    use App\Country;
    use App\Limit;
    use App\LinkLimit;
    use App\Pixel;
    use App\Platform;
    use App\Referer;
    use App\Profile;
    use App\RefererUrl;
    use App\Subdomain;
    use App\Url;
    use App\IpLocation;
    use App\UrlSpecialSchedule;
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
    use Mail;
    use App\Http\Requests\ForgotPasswordRequest;
    use Intervention\Image\ImageManagerStatic as Image;
    use Mockery\Exception;
    use App\DefaultSettings;
    use App\PixelProviders;
    use App\UserPixels;

    class HomeController extends Controller{
        /**
         * Get Application index page.
         *
         * @return \Illuminate\Http\Response
         */
        public function check_custom(Request $request){
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
                    $url = route('reset-password',['email' => base64_encode($user->email) , 'token' => $token]);

                    //$url = config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/reset-password/'.base64_encode($user->email).'/'.$token;
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
          //dd($request->all());
            $email = base64_decode($request->email);
            return view('settings.reset_password')->with(['email'=>$email,'token'=>$request->token]);
        }

        private function getAllDashboardElements($user , $request) {
            //code for search based on tags and description if the params are not empty
            $textToSearch = $request->textToSearch;
            $tagsToSearch = $request->tagsToSearch;
            $pageLimit        = ( $request->limit ) ? $request->limit: 10;

            $ret        = self::getDataOfSearchTags($textToSearch, $tagsToSearch, $user->id);
            $urls       = $ret['urls']->paginate($pageLimit);
            $count_url  = $ret['count_url'];
            $tagsToSearch = $ret['tagsToSearch'];

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

            $userId = \Auth::user()->id;
            $urlTags = UrlTag::whereHas('urlTagMap.url',function($q) use($userId) {
                $q->where('user_id',$userId);
            })->pluck('tag')->toArray();
            return [
               'tagsToSearch' => $tagsToSearch,
               'count_url' => $count_url,// dynamic
               'urlTags' => $urlTags,
               'user' => $user,
               'urls' => $urls,// dynamic
               'subscription_status' => $subscription_status,
               'limit' => $limit,
               'total_links' => $total_links,
               'filter' => $filter,
               'dates' => $dates,
               '_plan' => \Session::has('plan') ? \Session::get('plan') : null
            ];
        }

        /**
        * reset password from dashboard settings
        */
        public function resetPasswordSettings(Request $request) {
            if(\Auth::check()) {
                $user = \Auth::user();
                $arr = $this->getAllDashboardElements($user, $request);
                return view('dashboard-settings.reset-password', $arr);
            } else {
                return redirect()->action('HomeController@getIndex')->with('error','Your Session has expired.. Please log in again!');
            }
        }

        public function testnow($url) {
            $url = 'https://www.invoicingyou.com/';
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
                  if ($user != null && $reset) {
                      $user->password = bcrypt($request->password);
                      $user->save();
                      $password = PasswordReset::where('email', $user->email)->delete();
                      Auth::attempt(['email' => $request->email, 'password' => $request->password]);
                      return redirect()->action('HomeController@getDashboard' )
                              ->with('success', 'Password Reset Completed Successfully!');
                  } else {
                      $err_mesg = (!$reset) ? 'Token is Invalid' : 'This email address does not exists';
                      \Session::flash('errs',$err_mesg);
                      return \Redirect::back();
                  }
                } catch (\Exception $e) {
                    \Session::flash('errs',$e->getMessage());
                    //\Session::flash('errs','It seems like the mail server is busy! Try again after a few minutes');
                    return redirect()->back();
                }
            }
        }

        public function setPasswordSettings(Request $request) {
            //dd($request->all());
            if(\Auth::check()) {
                $user = \Auth::user();
                $old_password = $request->old_password;
                $new_password = $request->new_password;
                $confirm_password = $request->password_confirmation;

                //if old password does not match return error
                if(!\Hash::check($old_password, $user->password, [])) {
                  return redirect()->back()->with('errs','OOPS! Old password entered dosen\'t match with our records.. Try again!');
                }
                if(strlen(trim($new_password)) == 0 || strlen(trim($confirm_password)) == 0) {
                  return redirect()->back()->with('errs','OOPS! New Password or Confirm password cannot be blank.. Try again!');
                }
                if(strlen($new_password) < 6) {
                  return redirect()->back()->with('errs','OOPS! New Password entered should be minimum of 6 characters.. Try again!');
                }
                if($new_password !== $confirm_password) {
                  return redirect()->back()->with('errs','OOPS! New Password and Confirm password are not matching.. Try again!');
                }

                //update users with new password
                $user = \Auth::user();
                $user->password = bcrypt($new_password);

                if($user->save()) {
                  //Auth::logout();
                  //Session::flush();
                  //dd('here');
                  Auth::attempt(['email' => $user->email, 'password' => $user->password]);
                  return redirect()->action('HomeController@getDashboard' )
                            ->with('success', 'Password is updated successfully!');
                } else {
                  return redirect()->action('HomeController@getDashboard' )
                            ->with('error', 'Please try after some time!');
                }
            } else {
                return redirect()->action('HomeController@getIndex' )
                        ->with('error', 'Your session seems to be expired.. PLease log in!');
            }
        }


        public function getIndex(Request $request){
            //dd(Auth::check());
            if (Auth::check()) {
              // return view('index1');
                //return app('App\Http\Controllers\HomeController')->getDashboard($request);
              return redirect()->action('HomeController@getDashboard');
            } else {
                Session::put('login_error' , 'incorect username or password');
                // return view('index1');
                return redirect()->route('login');
            }
        }

        public function blog(){
            return view('top_menu.blog');
        }

        public function pricing(){
            if (Auth::check()){
                return redirect()->action('HomeController@getSubscribe');
            }else{
                return view('top_menu.pricing' , [
                    'user' => null,
                    'subscription_status' => -1,
                ]);
            }
        }

        public function features(){
            return view('top_menu.features');
        }

        public function about(){
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
        public function getRequestedUrl($url){
            $search = Url::where('shorten_suffix', $url)->first();
            if ($search) {
                $url_features = UrlFeature::where('url_id', $search->id)->first();
                if ($search->no_of_circular_links > 1) {
                    $circularLinks = CircularLink::where('url_id', $search->id)->get();
                    $search->actual_url = $circularLinks[$search->link_hits_count % $search->no_of_circular_links]->actual_link;
                    $search->link_hits_count += 1;
                    $search->save();
                }
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

        private function getDataOfSearchTags($textToSearch = '', $tagsToSearch = [], $userId) {
            // $textToSearch = $request->textToSearch;
            // $tagsToSearch = $request->tagsToSearch;
            $flag = 0;
            //echo strlen(trim($textToSearch));exit();
            if(strlen(trim($textToSearch)) > 0 || !empty($tagsToSearch)){
                $urls = Url::where('user_id', $userId)->where("parent_id",0);
                if(strlen($textToSearch) > 0) {
                    $urls = $urls->whereHas('urlSearchInfo', function($q) use($textToSearch) {
                      $q->whereRaw("MATCH (description) AGAINST ('".$textToSearch."' IN BOOLEAN MODE)");
                    });
                    $flag = 1;
                }
                if(!empty($tagsToSearch)) {
                    $allTags = implode(",",$tagsToSearch);
                    $condition = $flag == 0 ? 'whereHas' : 'orWhereHas';
                        $urls = $urls->$condition('urlTagMap', function($q) use($allTags) {
                        $q->whereHas('urlTag', function($q2) use($allTags) {
                          $refinedTags = str_replace($allTags,',',' ');
                          $q2->whereRaw("MATCH (tag) AGAINST ('".$allTags."' IN BOOLEAN MODE)");
                        });
                    });
                }
                $count_url = $urls->count();
                return [
                    'urls' => $urls,
                    'count_url' => $count_url,
                    'tagsToSearch' => $tagsToSearch ? $tagsToSearch : [],
                ];
            } else {
                $urls = Url::where('user_id', $userId)->where("parent_id",0)
                        ->orderBy('id', 'DESC');
                $count_url = $urls->count();
                return [
                    'urls' => $urls,
                    'count_url' => $count_url,
                    'tagsToSearch' =>[]
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
        public function postFetchChartData(Request $request){
            $textToSearch = $request->textToSearch;
            $tagsToSearch = $request->tagsToSearch;
            $pageLimit    = ( $request->pageLimit ) ? $request->pageLimit : 4;
            $currentPage  =  isset($request->currentPage) && $request->currentPage > 0 ? $request->currentPage : 1;
            $skip   = $pageLimit * ( $currentPage - 1 );
            $ret        = self::getDataOfSearchTags($textToSearch, $tagsToSearch, $request->user_id);
            $urls       = $ret['urls']->skip($skip)->limit($pageLimit)->get();
            $count_url  = $ret['count_url'];
            $URLs = [];
            $URLstat = [];
            foreach ($urls as $key => $url) {
                if(isset($url->subdomain)) {
                    if($url->subdomain->type == 'subdomain') {
                        //$URLs[$key]['name']       = 'https://'.$url->subdomain->name.'.'.env('APP_HOST').'/'.$url->shorten_suffix;
                        $URLs[$key]['name']       = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                        $URLs[$key]['drilldown']  = $URLs[$key]['name'];
                    }else if($url->subdomain->type == 'subdirectory') {
                        //$URLs[$key]['name'] = route('getIndex').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                        $URLs[$key]['name']       = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                        $URLs[$key]['drilldown']  = $URLs[$key]['name'];
                    }
                }else {
                    //$URLs[$key]['name'] = route('getIndex').'/'.$url->shorten_suffix;
                    $URLs[$key]['name'] = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
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
        public function postChartDataFilterDateRange(Request $request){
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
        public function postFetchChartDataByDate(Request $request){
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
        public function postFetchChartDataByCountry(Request $request){
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
        public function getAnalyticsByDate($url,$date){
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

        public function getAnalyticsBySubdirectoryDate($url,$subdirectory,$date){
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
        public function getAnalyticsByCountry($url, $country_code){
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
            $urlInfo=Url::where('id',$request->url_id)->first();
            if($urlInfo){
                if(($urlInfo->link_type==2)&& ($urlInfo->parent_id==0)){
                    $getSubUrl=Url::where('parent_id',$urlInfo->id)->pluck('id');
                    $noOfSublinks=count($getSubUrl);
                }
            }

            $location[0][0] = 'Country';
            $location[0][1] = 'Clicks';

            if(($urlInfo->link_type==2)&& ($urlInfo->parent_id==0) && (count($noOfSublinks)>0)){
                $countries = DB::table('country_url')
                    ->join('countries', 'countries.id', '=', 'country_url.country_id')
                    ->selectRaw('countries.code AS `code`, count(country_url.country_id) AS `count`')
                    ->whereIn('country_url.url_id', $getSubUrl)
                    ->groupBy('country_url.country_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }else{
                $countries = DB::table('country_url')
                    ->join('countries', 'countries.id', '=', 'country_url.country_id')
                    ->selectRaw('countries.code AS `code`, count(country_url.country_id) AS `count`')
                    ->where('country_url.url_id', $request->url_id)
                    ->groupBy('country_url.country_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }


            foreach ($countries as $key => $country) {
                $location[++$key][0] = $country->code;
                $location[$key][1] = (int) $country->count;
            }

            $operating_system[0][0] = 'Platform';
            $operating_system[0][1] = 'Clicks';

           /* $platforms = DB::table('platform_url')
                    ->join('platforms', 'platforms.id', '=', 'platform_url.platform_id')
                    ->selectRaw('platforms.name, count(platform_url.platform_id) AS `count`')
                    ->where('platform_url.url_id', $request->url_id)
                    ->groupBy('platform_url.platform_id')
                    ->orderBy('count', 'DESC')
                    ->get();
*/
                    if(($urlInfo->link_type==2)&& ($urlInfo->parent_id==0) && (count($noOfSublinks)>0)){
                $platforms = DB::table('platform_url')
                    ->join('platforms', 'platforms.id', '=', 'platform_url.platform_id')
                    ->selectRaw('platforms.name, count(platform_url.platform_id) AS `count`')
                    ->whereIn('platform_url.url_id', $getSubUrl)
                    ->groupBy('platform_url.platform_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }else{
                $platforms = DB::table('platform_url')
                    ->join('platforms', 'platforms.id', '=', 'platform_url.platform_id')
                    ->selectRaw('platforms.name, count(platform_url.platform_id) AS `count`')
                    ->where('platform_url.url_id', $request->url_id)
                    ->groupBy('platform_url.platform_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }


            foreach ($platforms as $key => $platform) {
                $operating_system[++$key][0] = $platform->name;
                $operating_system[$key][1] = (int) $platform->count;
            }

            $web_browser[0][0] = 'Browser';
            $web_browser[0][1] = 'Clicks';

            /*$browsers = DB::table('browser_url')
                    ->join('browsers', 'browsers.id', '=', 'browser_url.browser_id')
                    ->selectRaw('browsers.name, count(browser_url.browser_id) AS `count`')
                    ->where('browser_url.url_id', $request->url_id)
                    ->groupBy('browser_url.browser_id')
                    ->orderBy('count', 'DESC')
                    ->get();*/
                    if(($urlInfo->link_type==2)&& ($urlInfo->parent_id==0) && (count($noOfSublinks)>0)){
                $browsers = DB::table('browser_url')
                    ->join('browsers', 'browsers.id', '=', 'browser_url.browser_id')
                    ->selectRaw('browsers.name, count(browser_url.browser_id) AS `count`')
                    ->whereIn('browser_url.url_id', $getSubUrl)
                    ->groupBy('browser_url.browser_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }else{
                $browsers = DB::table('browser_url')
                    ->join('browsers', 'browsers.id', '=', 'browser_url.browser_id')
                    ->selectRaw('browsers.name, count(browser_url.browser_id) AS `count`')
                    ->where('browser_url.url_id', $request->url_id)
                    ->groupBy('browser_url.browser_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }

            foreach ($browsers as $key => $browser) {
                $web_browser[++$key][0] = $browser->name;
                $web_browser[$key][1] = (int) $browser->count;
            }

            $referring_channel[0][0] = 'Referer';
            $referring_channel[0][1] = 'Clicks';

           /* $referers = DB::table('referer_url')
                    ->join('referers', 'referers.id', '=', 'referer_url.referer_id')
                    ->selectRaw('referers.name, count(referer_url.referer_id) AS `count`')
                    ->where('referer_url.url_id', $request->url_id)
                    ->groupBy('referer_url.referer_id')
                    ->orderBy('count', 'DESC')
                    ->get();*/
                    if(($urlInfo->link_type==2)&& ($urlInfo->parent_id==0) && (count($noOfSublinks)>0)){
                $referers = DB::table('referer_url')
                    ->join('referers', 'referers.id', '=', 'referer_url.referer_id')
                    ->selectRaw('referers.name, count(referer_url.referer_id) AS `count`')
                    ->whereIn('referer_url.url_id', $getSubUrl)
                    ->groupBy('referer_url.referer_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }else{
                $referers = DB::table('referer_url')
                    ->join('referers', 'referers.id', '=', 'referer_url.referer_id')
                    ->selectRaw('referers.name, count(referer_url.referer_id) AS `count`')
                    ->where('referer_url.url_id', $request->url_id)
                    ->groupBy('referer_url.referer_id')
                    ->orderBy('count', 'DESC')
                    ->get();

            }

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

                $cn = new Country();
                $cn->name = $request->country['country_name'];
                $cn->code = $request->country['country_code'];
                if($cn->save()){

                  $cn->urls()->attach($request->url);
                  global $status;
                  $status = 'success';

                } else {
                  global $status;
                  $status = 'error';
                }
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

            if(!isset($request->url) || strlen(trim($request->url)) == 0) {
              return json_encode([
                  'status' => 'url cannot be empty!',
                  'url'    => ''
                  ]);
            }

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
          //dd($allowTags,$searchTags,$allowDescription,$searchDescription,$urlId);
          $urlTagMap = [];
          if($allowTags && count($searchTags) > 0) {
            foreach ($searchTags as $key => $tag) {

              if(strlen(trim($tag)) == 0) continue;

              $urlTag     = UrlTag::firstOrCreate(['tag'=>$tag]);
              $urlTagMap  = new UrlTagMap;
              $urlTagMap->url_id = $urlId;
              $urlTagMap->url_tag_id = $urlTag->id;
              $urlTagMap->save();
            }
          }

          if($allowDescription && strlen(trim($searchDescription)) > 0) {
            $urlSearchInfo = new UrlSearchInfo;
            $urlSearchInfo->url_id = $urlId;
            $urlSearchInfo->description = trim($searchDescription);
            $urlSearchInfo->save();
          }
          return;
        }

        public function fillUrlDescriptions(Url $url ,Request $request, $meta_data) {
          //print_r("<pre>");print_r($request->all());die();

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

          if(isset($request->link_preview_selector) && strtolower(trim($request->link_preview_selector)) == 'on') {

            //if($request->link_preview_original) {

              //return $url;
            //}
            if(isset($request->link_preview_custom) && strtolower(trim($request->link_preview_custom)) == 'on') {

              if($request->cust_title_chk && strlen($request->title_inp) > 0) {
                $url->title         =   $request->title_inp;
                $url->og_title      =   $request->title_inp;
                $url->twitter_title =   $request->title_inp;
              } else {
                $url->title         =   $meta_data['title'];
                $url->og_title      =   $meta_data['og_title'];
                $url->twitter_title =   $meta_data['twitter_title'];
              }

              if($request->cust_dsc_chk && strlen($request->dsc_inp) > 0) {
                $url->meta_description      =   $request->dsc_inp;
                $url->og_description        =   $request->dsc_inp;
                $url->twitter_description   =   $request->dsc_inp;
              } else {
                $url->meta_description      =   $meta_data['title'];
                $url->og_description        =   $meta_data['og_description'];
                $url->twitter_description   =   $meta_data['twitter_description'];
              }

              if($request->cust_url_chk && strlen($request->url_inp) > 0) {
                $url->og_url        =   $request->url_inp;
                $url->twitter_url   =   $request->url_inp;
              } else {
                $url->og_url        =   $meta_data['og_url'];
                $url->twitter_url   =   $meta_data['twitter_url'];
              }

              // if($request->hasFile('img_inp')) {
              //   $imgFile        = $request->file('img_inp');
              //   $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
              //   $actualFileExtension = $imgFile->getClientOriginalExtension();
              //   $validExtensionRegex = '/(jpg|jpeg)/i';
              //   if (preg_match($validExtensionRegex, $actualFileExtension)) {
              //     $uploadPath = getcwd().'/'.config('settings.UPLOAD_IMG');
              //     $newFileName = rand(1000, 9999) . "-" . date('U');
              //     $uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);
              //   } else {
              //     return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
              //   }
              // } else dd('o');
              // dd('done');

              if($request->cust_img_chk && $request->hasFile('img_inp')) {

                $imgFile        = $request->file('img_inp');
                $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                $actualFileExtension = $imgFile->getClientOriginalExtension();
                $validExtensionRegex = '/(jpg|jpeg|png)/i';
                $uploadPath = getcwd().'/'.config('settings.UPLOAD_IMG');
                $newFileName = rand(1000, 9999) . "-" . date('U');
                $uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);

                $url->og_image            =   config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/'.config('settings.UPLOAD_IMG').$newFileName.'.'.$actualFileExtension;
                $url->twitter_image       =   config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/'.config('settings.UPLOAD_IMG').$newFileName.'.'.$actualFileExtension;
              } else {
                $url->og_image            =   $meta_data['og_image'];;
                $url->twitter_image       =   $meta_data['twitter_url'];
              }
              return $url;
            }
            else {
              return $url;
            }
          }
          return $url;
        }

        public function imgUploader(Request $request) {
          print_r($request->all());die();
        }

        public function postShortUrlNoLogin(Request $request){
          try
          {
            if($request->hasFile('img_inp')) {
              $imgFile        = $request->file('img_inp');
              $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
              $actualFileExtension = $imgFile->getClientOriginalExtension();
              $validExtensionRegex = '/(jpg|jpeg|png)/i';
              if (!preg_match($validExtensionRegex, $actualFileExtension)) {
                $displayHtml = 'Image should be in jpg, jpeg or png format';
                return redirect()->back()->with(['url_shorten_no_session_displayHTML' => $displayHtml , 'url_shorten_no_session_type' => 'error']);
              }
            }

            if(\Auth::check()) {
              $userId = \Auth::user()->id;
            } else {
              $userId = 0;
            }

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


            if (strpos($request->actual_url[0], 'https://') == 0) {
                $actual_url = str_replace('https://','', $request->url);
                $protocol = 'https';
            } else {
                $actual_url = str_replace('http://','', $request->url);
                $protocol = 'http';
            }
            //print_r($actual_url);die();

            if(!isset($request->url) || strlen(trim($request->url)) == 0) {
              // return json_encode([
              //     'status' => 'error',
              //     'msg'    => 'url cannot be empty!'
              // ]);

              $displayHtml = 'URl cannot be empty!';
              //\Session::flash('url_shorten_no_session_displayHTML', $displayHtml);
              //\Session::flash('url_shorten_no_session_type', 'error');
              return redirect()->back()->with(['url_shorten_no_session_displayHTML' => $displayHtml , 'url_shorten_no_session_type' => 'error']);
            }

            $random_string = $this->randomString();

            $url = new Url();
            $url->actual_url = $actual_url;
            $url->protocol = $protocol;
            $url->shorten_suffix = $random_string;

            //$_url = $this->getPageTitle($request->url);
            //$url->title = $_url;
            $meta_data = $this->getPageMetaContents($request->url);

            $url = $this->fillUrlDescriptions($url , $request, $meta_data);

            $url->user_id = $userId;

            if ($url->save()) {
              if(($checkboxAddFbPixelid && $fbPixelid != null) || ($checkboxAddGlPixelid && $glPixelid != null)) {

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

                  // return response()->json([
                  //       'status'        => 'success',
                  //       'url'           => config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string,
                  //       'redirect_url'  => config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/app/url/'.$url->id.'/link_preview'
                  // ]);

                  $shortenUrl   = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string;
                  $displayHtml  = "<a href=" . $shortenUrl . " target='_blank' id='newshortlink'>" . $shortenUrl . "</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink'><i class='fa fa-clipboard'></i> Copy</button>";
                  return redirect()->back()->with(['url_shorten_no_session_SURL' => $shortenUrl , 'url_shorten_no_session_type' => 'success']);

                } else {
                  //return response()->json(['status' => 'error']);

                  $displayHtml = 'Database connection error. Please try again after some time!';
                  return redirect()->back()->with(['url_shorten_no_session_type' => 'error' , 'url_shorten_no_session_msg' => $displayHtml]);
                }
              } else {

                  $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

                  // return response()->json([
                  //       'status'        => 'success',
                  //       'url'           => config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string,
                  //       'redirect_url'  => config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/app/url/'.$url->id.'/link_preview'
                  // ]);

                  $shortenUrl   = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string;
                  $displayHtml  = "<a href=" . $shortenUrl . " target='_blank' id='newshortlink'>" . $shortenUrl . "</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink'><i class='fa fa-clipboard'></i> Copy</button>";
                  return redirect()->back()->with(['url_shorten_no_session_SURL' => $shortenUrl , 'url_shorten_no_session_type' => 'success']);
              }
            } else {
                  $displayHtml = 'Database connection error. Please try again after some time!';
                  return redirect()->back()->with(['url_shorten_no_session_type' => 'error' , 'url_shorten_no_session_msg' => $displayHtml]);
                //return response()->json(['status' => 'error', 'msg' => 'Database connection error. Please try again after some time!']);
            }
          }
          catch(\Exception $e) {
            $displayHtml = 'Error : '.$e->getMessage().' line : '.$e->getLine();
            return redirect()->back()->with(['url_shorten_no_session_type' => 'error' , 'url_shorten_no_session_msg' => $displayHtml]);
            //return response()->json(['status' => 'error', 'msg' => 'Some error occoured please try again later!']);
          }
        }

        public function postShortUrlNoSession(Request $request){
          try
          {

            $userId = 0;

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


            if (strpos($request->actual_url, 'https://') == 0) {
                $actual_url = str_replace('https://','', $request->url);
                $protocol = 'https';
            } else {
                $actual_url = str_replace('http://','', $request->url);
                $protocol = 'http';
            }
            //print_r($actual_url);die();

            if(!isset($request->url) || strlen(trim($request->url)) == 0) {
              return json_encode([
                  'status' => 'error',
                  'msg'    => 'url cannot be empty!'
              ]);
            }

            $random_string = $this->randomString();

            $url = new Url();
            $url->actual_url = $actual_url;
            $url->protocol = $protocol;
            $url->shorten_suffix = $random_string;

            //$_url = $this->getPageTitle($request->url);
            //$url->title = $_url;
            $meta_data = $this->getPageMetaContents($request->url);

            $url = $this->fillUrlDescriptions($url , $request, $meta_data);

            $url->user_id = $userId;

            if ($url->save()) {
              if(($checkboxAddFbPixelid && $fbPixelid != null) || ($checkboxAddGlPixelid && $glPixelid != null)) {

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
                        'status'        => 'success',
                        'url'           => config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string,
                        'redirect_url'  => config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/app/url/'.$url->id.'/link_preview'
                  ]);
                } else {
                  return response()->json(['status' => 'error']);
                }
              } else {

                  $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

                  return response()->json([
                        'status'        => 'success',
                        'url'           => config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string,
                        'redirect_url'  => config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/app/url/'.$url->id.'/link_preview'
                  ]);
              }
            } else {
                return response()->json(['status' => 'error', 'msg' => 'Database connection error. Please try again after some time!']);
            }
          }
          catch(\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Some error occoured please try again later!']);
          }
        }

        public function postShortUrlTier5(Request $request)
        {
          //print_r("<pre>");print_r($request->all());exit();
          try{

            if (\Auth::user())
          			$userId = \Auth::user()->id;
          	else {
                $userId = 0;
            }


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
            //dd($checkboxAddFbPixelid, $fbPixelid , $checkboxAddGlPixelid, $glPixelid, $allowTags, $searchTags, $allowDescription, $searchDescription);
            //print_r("<pre>");print_r($request->all());exit();
            if(isset($request->allowSchedule) && $request->allowSchedule == 'on')
            {
                if (strpos($request->actual_url[0], 'https://') === 0) {
                    $actual_url = str_replace('https://', null, $request->actual_url[0]);
                    $protocol = 'https';
                }elseif(strpos($request->actual_url[0], 'http://') === 0)
                {
                    $actual_url = str_replace('http://', null, $request->actual_url[0]);
                    $protocol = 'http';
                }
                else
                {
                    $actual_url = NULL;
                    $protocol = 'http';
                }
            }
            else
            {
                if (strpos($request->actual_url[0], 'https://') === 0) {
                    $actual_url = str_replace('https://', null, $request->actual_url[0]);
                    $protocol = 'https';
                }elseif(strpos($request->actual_url[0], 'http://') === 0)
                {
                    $actual_url = str_replace('http://', null, $request->actual_url[0]);
                    $protocol = 'http';
                }
            }

            //        if(!isset($request->actual_url[0]) || strlen(trim($request->actual_url[0])) == 0) {
            //          return redirect()->back()->with('error', 'url cannot be empty!');
            //        }

            $random_string = $this->randomString();

            $url = new Url();
            $url->actual_url = $actual_url;
            $url->protocol = $protocol;
            $url->shorten_suffix = $random_string;
            $meta_data = $this->getPageMetaContents($request->actual_url);
            $url = $this->fillUrlDescriptions($url , $request, $meta_data);
            $url->user_id = $userId;

            /* Custom redirecting time for short url */

              if(isset($request->allowCountDown) && $request->allowCountDown=='on')
              {
                  if(!empty($request->redirecting_time) && $request->redirecting_time >= 1 && $request->redirecting_time <= 30)
                  {
                      $url->redirecting_time = ($request->redirecting_time)*1000;
                  }
                  else
                  {
                      $url->redirecting_time = 5000;
                  }
              }
              else
              {
                  $url->redirecting_time = 5000;
              }

            /* End of Custom redirecting time for short url */

            //****** expiration values set in the `urls` table ******//

            if (isset($request->allowExpiration) && $request->allowExpiration == 'on')
            {
                $date = strtotime($request->date_time);
                $date_time = date_create($request->date_time);
                $url->date_time = $date_time;
                $url->timezone = $request->timezone;
                if(strlen($request->redirect_url)>0)
                {
                    $url->redirect_url = $request->redirect_url;
                }
                else
                {
                    $url->redirect_url = NULL;
                }
            }
            //******  Day wise link schedule for shorten url  ******//


            if(isset($request->allowSchedule) && $request->allowSchedule == 'on')
            {
                $url->is_scheduled = 'y';
                if(!empty($request->day1) or strlen($request->day1)>0)
                {
                    $url->day_one = $request->day1;
                }else
                {
                    $url->day_one = NULL;
                }

                if(!empty($request->day2) or strlen($request->day2)>0)
                {
                    $url->day_two = $request->day2;
                }else
                {
                    $url->day_two = NULL;
                }

                if(!empty($request->day3) or strlen($request->day3)>0)
                {
                    $url->day_three = $request->day3;
                }else
                {
                    $url->day_three = NULL;
                }

                if(!empty($request->day4) or strlen($request->day4)>0)
                {
                    $url->day_four = $request->day4;
                }else
                {
                    $url->day_four = NULL;
                }

                if(!empty($request->day5) or strlen($request->day5)>0)
                {
                    $url->day_five = $request->day5;
                }else
                {
                    $url->day_five = NULL;
                }

                if(!empty($request->day6) or strlen($request->day6)>0)
                {
                    $url->day_six = $request->day6;
                }else
                {
                    $url->day_six = NULL;
                }

                if(!empty($request->day7) or strlen($request->day7)>0)
                {
                    $url->day_seven = $request->day7;
                }else
                {
                    $url->day_seven = NULL;
                }
            }
            if ($url->save())
            {

                /**
                * Schedule for special day
                */

               /* if(!in_array('', $request->special_date) && !in_array('',$request->special_date_redirect_url)>0)
                {
                    $spl_dt = [];
                    $spl_url = [];
                    for ($i=0; $i<count($request->special_date); $i++)
                    {
                        if($request->special_date[$i]!== '' or !empty($request->special_date))
                        {
                            $spl_dt[$i] = $request->special_date[$i];
                        }

                        if($request->special_date_redirect_url[$i]!='' or !empty($request->special_date_redirect_url[$i]))
                        {
                            $spl_url[$i] = $request->special_date_redirect_url[$i];
                        }
                    }


                    if(count($spl_dt)>0)
                    {
                        for ($j=0; $j<count($spl_dt); $j++)
                        {
                            $id = $url->id;
                            $spl_date = $spl_dt[$j];
                            $spcl_url = $spl_url[$j];
                            $this->insert_special_schedule($id, $spl_date, $spcl_url);
                        }
                    }

                }*/

                /* Circular URLs support */
                $noOfCircularLinks = count($request->input('actual_url'));
                if ($noOfCircularLinks > 1) {
                    foreach ($request->input('actual_url') as $actualLink) {
                        $circularLink = new CircularLink();
                        $circularLink->url_id = $url->id;
                        $circularLink->actual_link = $actualLink;
                        $circularLink->save();
                    }
                    /* Update urls table accordingly */
                    $url->no_of_circular_links = $noOfCircularLinks;
                    $url->save();
                }

              if(($checkboxAddFbPixelid && $fbPixelid != null) || ($checkboxAddGlPixelid && $glPixelid != null)) {
                //dd('here');
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

                  $status           = 'success';
                  $url_shortened    = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string;
                  $url_to_redirect  = route('getLinkPreview',$url->id);
                  return redirect($url_to_redirect)->with('success', 'Url Shortened Successfully');

                } else {
                  return redirect()->back()->with('error', 'Database connection error. Please try again after some time!');
                }
              } else {
                  $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

                  $status           = 'success';
                  $url_shortened    = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$random_string;
                  $url_to_redirect  = route('getLinkPreview',$url->id);

                  return redirect(route('getLinkPreview',$url->id))->with('success', 'Url Shortened Successfully');
              }

            } else {
              //dd('here3');
                return redirect()->back()->with('error', 'Database connection error. Please try again after some time!');
                //return response()->json(['status' => 'error', 'msg' => 'Database connection error. Please try again after some time!']);
            }
          }
          catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage().' line :'.$e->getLine());
          }
        }


        /**
         *  Special day schedule links insertion into table `url_special_schedules`
         */
        public function insert_special_schedule($id, $spl_date, $spl_url)
        {
            try
            {
                $special_schedule = new UrlSpecialSchedule();
                $special_schedule->url_id = $id;
                $special_schedule->special_day = $spl_date;
                $special_schedule->special_day_url = $spl_url;
                $special_schedule->save();
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }

        }

        public function zf(Request $request)
        {
          try {

            foreach ($request->all() as $key => $val) {
              $z_array[$key] = $val;
            }

            return \Response::json(array(
                          'status' => true,
                          'response' => $z_array,
                          'message' => 'Your Lists'
                        ), 200);
          } catch (\Exception $e) {

            return \Response::json(array(
                          'status' => false,
                          'message' => 'List Not Found'
                        ), 403);
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
          //print_r("<pre>");print_r($request->all());die();
          try {

            if (\Auth::user())
          			$userId = \Auth::user()->id;
          	else {
              return response()->json(['status' => 'error', 'msg'=>'Database connection error. Please try again later!']);
            }


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

            if(!isset($request->actual_url[0]) || strlen(trim($request->actual_url[0])) == 0) {
              return redirect()->back()->with('error', 'url cannot be empty!');
              // return json_encode([
              //     'status' => 'url cannot be empty!',
              //     'url'    => ''
              //     ]);
            }

            if (strpos($request->actual_url[0], 'https://') == 0) {
                $actual_url = str_replace('https://', null, $request->actual_url[0]);
                $protocol = 'https';
            } else {
                $actual_url = str_replace('http://', null, $request->actual_url[0]);
                $protocol = 'http';
            }
            $url = new Url();
            $url->actual_url      = $actual_url;
            $url->shorten_suffix  = $request->custom_url;
            $url->protocol        = $protocol;
            //$_url = $this->getPageTitle($request->actual_url[0]);
            //$url->title = $_url;

            $meta_data  = $this->getPageMetaContents($request->actual_url[0]);
            $url        = $this->fillUrlDescriptions($url , $request, $meta_data);

            $url->user_id = $userId;
            $url->is_custom = 1;
            if ($url->save()) {
                /* Circular URLs support */
                $noOfCircularLinks = count($request->input('actual_url'));
                if ($noOfCircularLinks > 1) {
                    foreach ($request->input('actual_url') as $actualLink) {
                        $circularLink = new CircularLink();
                        $circularLink->url_id = $url->id;
                        $circularLink->actual_link = $actualLink;
                        $circularLink->save();
                    }
                    /* Update urls table accordingly */
                    $url->no_of_circular_links = $noOfCircularLinks;
                    $url->save();
                }

              if(($checkboxAddFbPixelid && $fbPixelid != null) || ($checkboxAddGlPixelid && $glPixelid != null)) {

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

                  $status           = 'success';
                  $url_shortened    = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                  $url_to_redirect  = route('getLinkPreview',$url->id);

                  // return response()->json([
                  //       'status'        =>  'success',
                  //       'url'           =>  config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix,
                  //       'redirect_url'  =>  config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/app/url/'.$url->id.'/link_preview'
                  // ]);

                  return redirect($url_to_redirect)->with($status, 'Url Shortened Successfully');

                } else {
                  return redirect()->back()->with('error','Database Connectivity Error. Try again later!');
                  //return response()->json(['status' => 'error']);
                }
              } else {

                  $this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

                  $status           = 'success';
                  $url_shortened    = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                  $url_to_redirect  = route('getLinkPreview',$url->id);

                  // return response()->json([
                  //       'status'        => 'success',
                  //       'url'           => config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix,
                  //       'redirect_url'  =>  config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/app/url/'.$url->id.'/link_preview'
                  // ]);

                  return redirect($url_to_redirect)->with($status, 'Url Shortened Successfully');
              }

            } else {
              return redirect()->back()->with('error','Database Connectivity Error. Try again later!');
                //return response()->json(['status' => 'error', 'msg'=>'Database connection error. Please try again later!']);
            }
          } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage().' line :'.$e->getLine());
            //return response()->json(['status' => 'error', 'msg'=>'Some error occoured. Please try again later!']);
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
        public function getPageMetaContents($url)
        {
          $meta = array();
          $meta['title'] = $meta['meta_description'] = null;
          $meta['og_title'] = $meta['og_description'] = $meta['og_url'] = $meta['og_image'] = null;
          $meta['twitter_title'] = $meta['twitter_description'] = $meta['twitter_url'] = $meta['twitter_image'] = null;

          try {
            $html = file_get_contents($url);

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
          } catch(\Exception $e) {
            return $meta;
          }

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
            ],[
              'loginemail.required' => 'Email ID is required',
              'loginemail.email' => 'Please enter valid Email ID',
              'loginpassword.required' => 'Password is required',
            ]);

            if(isset($request->__plan)) \Session::flash('planin' , $request->_plan);

            Session::flash('login_err' , 'Incorrect Username or Password');
            if (Auth::attempt(['email' => $request->loginemail, 'password' => $request->loginpassword], $request->remember)) {
                return redirect()->action('HomeController@getDashboard');
            } else {
                return redirect()->back()
                        ->with('error', 'Invalid Credentials!');
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
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
                //'g-recaptcha-response' => 'recaptcha',
            ]);

            if($request->password !== $request->password_confirmation) {
              \Session::flash('registration_err' , 'Password and confirm password must be same for registration process.. Please try again!');
              return redirect()->route('getIndex');
            }

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

        private function createLink($type) {
          if (Auth::check()) {
              if(\Session::has('plan'))
              {
                  return redirect()->action('HomeController@getSubscribe');
              } else {

                $user = Auth::user();
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

                $urlTags = UrlTag::whereHas('urlTagMap.url',function($q) use($user) {
                           $q->where('user_id',$user->id);
                         })->pluck('tag')->toArray();


                return view('dashboard.shorten_url' , [
                  'urlTags'             => $urlTags,
                  'total_links'         => $total_links,
                  'limit'               => $limit,
                  'subscription_status' => $subscription_status,
                  'user'                => $user,
                  'type'                => $type
                ]);
              }

          } else {
            return redirect()->action('HomeController@getIndex');
          }
        }

        public function createShortenedLink() {
            return $this->createlink('short');
        }

        public function createCustomLink() {
            return $this->createlink('custom');
        }

        public function shortenUrl(Request $request) {
          //dd($request->all());
          //dd($request->file('img_inp'));
          if($request->hasFile('img_inp')) {
            $imgFile        = $request->file('img_inp');
            $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
            $actualFileExtension = $imgFile->getClientOriginalExtension();
            $validExtensionRegex = '/(jpg|jpeg|png)/i';
            if (!preg_match($validExtensionRegex, $actualFileExtension)) {
              //$uploadPath = getcwd().'/'.config('settings.UPLOAD_IMG');
              //$newFileName = rand(1000, 9999) . "-" . date('U');
              //$uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);
              return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
            }
          }


          //print_r("<pre>");print_r($request->all());exit();
          //return redirect()->back()->with('error','Invalid form submission');
          if (Auth::check())
          {
                if(isset($request->type) && $request->type == 'short') {
                  return $this->postShortUrlTier5($request);
                }
                else if(isset($request->type) && $request->type == 'custom') {
                  return $this->postCustomUrlTier5($request);
                }
                //all codes are here
                return redirect()->back()->with('error', 'form data inappropriate');
                //return response()->json(['status'=>'error', 'msg'=>'form data inappropriate']);
          } else {
            return redirect()->action('HomeController@getIndex');
          }
        }

        /**
         * Method To Get Dashboard access for resgistered user.
         *
         * @return \Illuminate\Http\Response
         */
        public function getDashboard(Request $request){
            if (Auth::check()){
                if(\Session::has('plan')){
                    return redirect()->action('HomeController@getSubscribe');
                }else{
                    $user = Auth::user();
                    $arr = $this->getAllDashboardElements($user, $request);
                   // return view('dashboard2', $arr);
                    return view('dashboard.dashboard', $arr);
                }
            } else {
                Auth::logout();
                Session::flush();
                return redirect()->action('HomeController@getIndex');
            }
        }

        public function getLinkPreview($id) {
            if (Auth::check()) {
                //dd(Auth::check());
                if(\Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                }else{
                    $user = Auth::user();
                    $url = Url::find($id);

                    if(!$url) {
                        return redirect()->action('HomeController@getDashboard')->with('error','This url have been deleted!');
                    }
                    /* Prevent other user to access of a user data */
                    if ($url->user_id != $user->id) {
                      return view('errors.403');
                    }

                    /* Getting the global settings */
                    $defaultSettings = DefaultSettings::all();
                    $redirecting_time = $defaultSettings[0]->default_redirection_time;
                    $redirecting_text = $defaultSettings[0]->default_redirecting_text;
                    $profile = Profile::where('user_id',$url->user_id)->first();
                    if (count($profile)>0) {
                        $redirecting_time = $profile->default_redirection_time;
                        if ($url->usedCustomised==1) {
                            $redirecting_time = $url->redirecting_time;
                            $redirecting_text = $url->redirecting_text_template;
                        } else {
                            $redirecting_time = $profile->default_redirection_time;
                        }
                    }
                    if(!$url) {
                        return redirect()->action('HomeController@getDashboard')->with('error','This url have been deleted!');
                    }

                    $total_links = null;
                    if ($url) {
                        $total_links = $url->count;
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

                    $urlTags = $url->urlTagMap;
                    $tags = '';
                    /* Tags for url */
                    if(count($urlTags)>0){
                        $tags = array();
                        foreach($urlTags as $urlTag){
                            $tagName = UrlTag::find($urlTag->url_tag_id);
                            $tags[] = $tagName->tag;
                        }
                    }else{
                        $tags = 'No tag available';
                    }
                    $getSubLinks=0;
                    if(($url->link_type==2) && ($url->parent_id==0)){
                        $getSubLinks=Url::where('parent_id',$url->id)->where('link_type',2)->where('user_id',$user->id)->get();
                        $alliplocation=[];
                        if(count($getSubLinks)>0){
                            $key=0;
                            foreach($getSubLinks as $sublinks){

                                if(count($sublinks->ipLocations)>0){
                                    foreach($sublinks->ipLocations as $ipLocation){
                                        $ipLocation['sublink_suffix']=$sublinks['shorten_suffix'];
                                        $ipLocation['destination_suffix']=$sublinks['protocol']."://".$sublinks['actual_url'];
                                        $alliplocation[$key]=$ipLocation;
                                        $key=$key+1;
                                    }
                                }
                            }
                            usort($alliplocation, array($this, "date_sort"));
                        }
                    }

                    if(isset($url->subdomain)) {
                      if($url->subdomain->type == 'subdomain')
                          $redirectDomain = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST');
                      else if($url->subdomain->type == 'subdirectory')
                          $redirectDomain = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name;
                    } else {
                            $redirectDomain = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST');
                    }

                    if($url->link_type==2 && $url->parent_id==0){
                        return view('dashboard.grouppreview' , [
                        'url'                 => $url,
                        'total_links'         => $total_links,
                        //'limit'               => $limit,
                        'subscription_status' => $subscription_status,
                        'user'                => $user,
                        'tags'                => $tags,
                        'redirecting_text'    => $redirecting_text,
                        'redirecting_time'    => $redirecting_time,
                        'sublink'             => $getSubLinks,
                        'redirectDomain'      => $redirectDomain,
                        'iplocations'         => $alliplocation
                      ]);

                    }else{
                        return view('dashboard.link_preview' , [
                        'url'                 => $url,
                        'total_links'         => $total_links,
                        //'limit'               => $limit,
                        'subscription_status' => $subscription_status,
                        'user'                => $user,
                        'tags'                => $tags,
                        'redirecting_text'    => $redirecting_text,
                        'redirecting_time'    => $redirecting_time,
                        'sublink'             => $getSubLinks
                      ]);
                    }
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
                if (!file_exists('public/uploads/brand_images'))
                {
                    mkdir('public/uploads/brand_images', 777 , true);
                }
                $upload_path ='public/uploads/brand_images';
                $image_name = uniqid()."-".$request->brandLogo->getClientOriginalName();
                $data = getimagesize($request->brandLogo);
                $width = $data[0];
                $height = $data[1];

                /* image resizing */
                $temp_height = 450;
                $abs_width = ceil(($width*$temp_height)/$height);
                $abs_height = $temp_height;
                $image_resize = Image::make($request->brandLogo->getRealPath());
                $image_resize->resize($abs_width, $abs_height);
                $image_resize->save($upload_path.'/'.$image_name);
                $url->uploaded_path = $upload_path.'/'.$image_name;
            }
            $url->redirecting_time = $request->redirectingTime * 1000;
            $url->redirecting_text_template = $request->redirectingTextTemplate;
            $url->usedCustomised = 1;
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
        // public function getRequestedSubdirectoryUrl($subdirectory, $url)
        // {

        //     $redirectUrl = Url::where('shorten_suffix', $url)->first();
        //     if ($redirectUrl) {
        //         $subDirectory = Subdomain::where('name', $subdirectory)
        //                         ->where('type', 'subdirectory')
        //                         ->where('url_id', $redirectUrl->id)
        //                         ->first();
        //         if ($subDirectory) {
        //             echo $this->getRequestedUrl($url);
        //         } else {
        //             abort(404);
        //         }
        //     } else {

        //         $redirectUrl = Url::where('shorten_suffix', $subdirectory."/".$url)->first();
        //         if($redirectUrl){
        //             echo UrlController::getRequestedUrl($subdirectory."/".$url);
        //         }else{
        //             abort(404);
        //         }
        //     }
        // }



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

        public function requestForPrice(Request $request) {
            $emailcontent = array (
                'userName' => $request->input('userName'),
                'userEmail' => $request->input('userEmail'),
                'userPhone' => $request->input('userPhone'),
                'userMsg' => $request->input('userMsg')
                );
                Mail::send('mail.priceRequest', $emailcontent, function($message)
                {
                $message->to(env('TO_PRICING_EMAIL'),'Pricing Request for LinkWizard')
                        ->from($request->input('userEmail'))
                        ->subject('Price request for LinkWizard');
                });

                return 'MessageSent';
        }

        /**
         * Get an URL id on AJAX request and delete from db.
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function deleteShortenUrl(Request $request)
        {
          try {
            $url_tag          = UrlTagMap::where('url_id', $request->id)->delete();
            $url_feature      = UrlFeature::where('url_id', $request->id)->delete();
            $url_search_info  = UrlSearchInfo::where('url_id', $request->id)->delete();
            $url              = Url::where('id', $request->id)->delete();
              return response()->json([
                      'status' => 'success',
              ]);
            }catch (Exception $e) {
              return response()->json(['status' => 'error']);
          }
        }

        /**
         *  Method for viewing edit_url
         */
        public function editUrlView($id=NULL)
        {
            $urls = Url::findOrFail($id);
            if (Auth::check()) {
                if (\Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {

                    $user = Auth::user();
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

                    $urlTags = UrlTag::whereHas('urlTagMap.url', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->pluck('tag')->toArray();

                    return view('dashboard.edit_url', [
                        'urlTags' => $urlTags,
                        'total_links' => $total_links,
                        'limit' => $limit,
                        'subscription_status' => $subscription_status,
                        'user' => $user,
                        'type' => 'short',
                        'urls' => $urls
                    ]);
                }
            }
        }

        /**
         * Method for editing short url
         * @param Request $request
         * @param null $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function editUrl(Request $request, $id=NULL)
        {
            $this->validate($request, [
                "actual_url" => 'required|url'
            ]);

            $meta_Data = $this->getPageMetaContents($request->actual_url);
            $explode_url = explode("://", $request->actual_url);
            $protocol = $explode_url[0];
            $page_url = $explode_url[1];

            $url = Url::find($id);

            $url->protocol = $protocol;
            $url->actual_url = $page_url;
            $url->title = $meta_Data['title'];
            if(isset($request->allowDescription) && $request->allowDescription=='on')
            {
                $url->meta_description = $request->searchDescription;
            }
            else
            {
                $url->meta_description = $meta_Data['meta_description'];
            }

            if(isset($request->link_preview_selector) && $request->link_preview_selector=='on')
            {
                if(isset($request->link_preview_original) && $request->link_preview_original=='on')
                {
                    $url->og_title = $meta_Data['og_title'];
                    $url->og_description = $meta_Data['og_description'];
                    $url->og_url = $meta_Data['og_url'];
                    $url->og_image = $meta_Data['og_image'];
                    $url->twitter_title = $meta_Data['twitter_title'];
                    $url->twitter_description = $meta_Data['twitter_description'];
                    $url->twitter_url = $meta_Data['twitter_url'];
                    $url->twitter_image = $meta_Data['twitter_image'];
                }
                elseif(isset($request->link_preview_custom) && $request->link_preview_custom=='on')
                {
                    $url->is_custom = 1;

                    if(isset($request->org_img_chk) && $request->org_img_chk=='on')
                    {
                        $url->og_image = $meta_Data['og_image'];
                    }
                    elseif(isset($request->cust_img_chk) && $request->cust_img_chk =='on')
                    {
                        $image = $request->file('img_inp');

                        $upload_path ='public/uploads/images';
                        $imagename = uniqid() .'.'. $image->getClientOriginalExtension();
                        $request->img_inp->move($upload_path, $imagename);
                        $url->og_image = $imagename;

                    }

                    if(isset($request->org_title_chk) && $request->org_title_chk=='on')
                    {
                        $url->og_title = $meta_Data['og_title'];
                    }
                    elseif(isset($request->cust_title_chk) && $request->cust_title_chk=='on')
                    {
                        $url->og_title = $request->title_inp;
                    }

                    if(isset($request->org_dsc_chk) && $request->org_dsc_chk=='on')
                    {
                        $url->og_description = $meta_Data['og_description'];
                    }
                    elseif(isset($request->cust_dsc_chk) && $request->cust_dsc_chk=='on')
                    {
                        $url->og_description = trim($request->dsc_inp);
                    }
                }
            }else
            {
                $url->og_title = $meta_Data['og_title'];
                $url->og_description = $meta_Data['og_description'];
                $url->og_url = $meta_Data['og_url'];
                $url->og_image = $meta_Data['og_image'];
                $url->twitter_title = $meta_Data['twitter_title'];
                $url->twitter_description = $meta_Data['twitter_description'];
                $url->twitter_url = $meta_Data['twitter_url'];
                $url->twitter_image = $meta_Data['twitter_image'];
            }

            if($url->save())
            {

            if(isset($request->tags) && count($request->tags)>0)
            {
                DB::table('url_tag_maps')->where('url_id', $id)->delete();

                for($i=0; $i<count($request->tags); $i++)
                {
                    $url_tag_map = new UrlTagMap();

                    $url_tag_id = UrlTag::where('tag', $request->tags[$i])->first();
                    if(count($url_tag_id)>0)
                    {
                        $url_tag_map->url_tag_id = $url_tag_id->id;
                        $url_tag_map->url_id = $id;
                        $url_tag_map->save();
                    }else
                    {
                        $url_tag = new UrlTag();
                        $url_tag->tag = $request->tags[$i];
                        $url_tag->save();

                        $url_tag_map->url_tag_id = $url_tag->id;
                        $url_tag_map->url_id = $id;
                        $url_tag_map->save();
                    }
                }
            }

            if(isset($request->checkboxAddFbPixelid) && $request->checkboxAddFbPixelid == 'on')
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'fb_pixel_id' => $request->fbPixelid,
                    ));
                }
                else
                {
                    $url_feature = new UrlFeature();
                    $url_feature->fb_pixel_id = $request->fbPixelid;
                    $url_feature->url_id = $id;
                    $url_feature->save();
                }
            }else
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                //dd($url->id);
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'fb_pixel_id' => NULL,
                    ));
                }
            }

            if(isset($request->checkboxAddGlPixelid) && $request->checkboxAddGlPixelid == 'on')
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'gl_pixel_id' => $request->glPixelid,

                    ));
                }else
                {
                    $url_feature = new UrlFeature();
                    $url_feature->gl_pixel_id = $request->glPixelid;
                    $url_feature->url_id = $id;
                    $url_feature->save();
                }
            }else
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'gl_pixel_id' => NULL,

                    ));
                }
            }


                return redirect()->route('getDashboard')->with('edit_msg', '0');
            }
            return redirect()->route('getDashboard')->with('edit_msg', '1');
        }

        /**
        * Add tab for special link schedule AJAX
        */

        public function add_schedule_tab(){
            return view('add_special_schedule');
        }


        /**
        * Redirect APP_REDIRECT_HOST to APP_HOST
        */
        public function redirectUrl(){
            return redirect()->route('getIndex');
        }

        /**
         * Load pixel view
         * @param Request $request
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function loadPixels(Request $request)
        {
            if(Auth::check())
            {
                if(Session::has('plan'))
                {
                    return redirect()->action('HomeController@getSubscribe');
                }else
                {
                    $user = Auth::user();
                    $arr = $this->getAllDashboardElements($user, $request);
                    $userPixels = Pixel::where('user_id', Auth::user()->id)->get();
                    return view('pixels.pixel_preview', compact('arr', 'userPixels'));
                }
            }
        }

        /**
         * Store pixels
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function savePixels(Request $request)
        {
            if(Auth::check()) {
                if(Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {
                    if($request->provider_code=='CS') {
                        $this->validate($request,[
                            'provider_code' => 'required',
                            'pixel_name' => 'required|max:150',
                            'custom_pixel_script' => 'required'
                        ]);
                    } elseif($request->provider_code!='CS') {
                        $this->validate($request,[
                            'provider_code' => 'required',
                            'pixel_name' => 'required|max:150',
                            'pixel_id' => 'required|max:150'
                        ]);
                    }
                    try {
                            $pixel = new UserPixels();
                            $pixel->user_id = Auth::user()->id;
                            $pixel->pixel_provider_id = PixelProviders::where('provider_code',$request->provider_code)->value('id');
                            if ($request->provider_code=='CS') {
                                $pixel->is_custom = '1';
                                $pixel->pixel_script = $request->custom_pixel_script;
                            } elseif ($request->provider_code!='CS') {
                                $pixel->pixel_id = $request->pixel_id;
                            }
                            $pixel->pixel_name = $request->pixel_name;
                            $pixel->script_position = $request->script_position;
                            $pixel->save();
                            return redirect()->back()->with('msg', 'success');
                    } catch(Exception $e) {
                        return redirect()->back()->with('msg', 'error');
                    }
                }
            } else {
                return redirect()->action('HomeController@getDashboard');
            }
        }

        /**
         * Edit pixels
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function editPixels(Request $request)
        {
            if (Auth::check()) {
                if(Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {
                    $provider_code = PixelProviders::where('provider_name',$request->provider_name)->pluck('provider_code')->first();
                    if ($provider_code=='CS') {
                        $this->validate($request,[
                            'pixel_name' => 'required|max:150',
                            'custom_pixel_script' => 'required'
                        ]);
                    } elseif ($provider_code!='CS') {
                        $this->validate($request,[
                            'pixel_name' => 'required|max:150',
                            'pixel_id' => 'required|max:150'
                        ]);
                    }
                    try {
                            $pixel = UserPixels::where('id',$request->edit_id)->first();
                            if ($provider_code=='CS') {
                                $pixel->is_custom = '1';
                                $pixel->pixel_script = $request->custom_pixel_script;
                            } elseif ($provider_code!='CS') {
                                $pixel->pixel_id = $request->pixel_id;
                            }
                            $pixel->pixel_name = $request->pixel_name;
                            $pixel->script_position = $request->script_position;
                            $pixel->update();
                            return redirect()->back()->with('msg', 'success');
                    } catch(Exception $e) {
                        return redirect()->back()->with('msg', 'editerror');
                    }
                }
            } else {
                return redirect()->action('HomeController@getDashboard');
            }
        }

        /**
         * Delete pixels
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function deletePixels(Request $request)
        {
            if (Auth::check()) {
                if (Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {
                    try {
                        $id = $request->id;
                        $pixel = UserPixels::find($id);
                        $pixel->delete();
                        echo json_encode(['status'=>200, 'message'=>'success', 'row'=>$id]);
                    } catch(Exception $e) {
                        echo json_encode(['status'=>400, 'message'=>$e->getMessage(), 'row'=>0]);
                    }
                }
            } else {
                return redirect()->action('HomeController@getDashboard');
            }
        }
        public function date_sort($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        }
        private static function cmp($a, $b) {
            return $a['created_at'] - $b['created_at'];
        }
       public function groupLinkDetails ($id) {
            $ipLocationsArray = [];
            $url = Url::where('parent_id',$id)->with('ipLocations')->get();
            if (count($url) > 0) {
                foreach ($url as $key => $value) {
                     $ipLocationsArray[$value->id] = [
                        'actul_url' => $value->actual_url,
                        'ipLocationsData' => $value->ipLocations->toArray()
                     ];
                }
                $data = [];
                $ipdetail = [];
                $ipdetail['datadetail']=array();
                foreach ($ipLocationsArray as $iploc) {
                    foreach ($iploc['ipLocationsData'] as $value1) {
                        $ipdetail['datadetail'][strtotime($value1['created_at'])] =  [date("D M d, Y H:i:s A", strtotime($value1['created_at'])), $value1['ip_address'] , $value1['city'] , $value1['country'] , $value1['browser'] ,$value1['platform'] , $value1['referer'] , "<a href=\"//". $iploc['actul_url'] . "\" target=\"_blank\">" . $iploc['actul_url'] . "</a>"];
                    }
                }
                krsort($ipdetail['datadetail']);
                $data['data']=array_values($ipdetail['datadetail']);
            } else {
                $data['data']=array();
            }
            return response()->json($data);
        }
        public function login(){
            if (Auth::check()) {
                return redirect()->action('HomeController@getDashboard');
            } else  {
            return view('registration.login');}
        }

        public function index()
        {
          if (Auth::check()) {
            return redirect()->action('HomeController@getDashboard');
          } else {
            return view('index1');
          }
        }
    }
