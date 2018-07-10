<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Url;
    use App\UrlSpecialSchedule;
    use App\User;
    use App\Country;
    use App\Limit;
    use App\LinkLimit;
    use App\Pixel;
    use App\UrlFeature;
    use App\UrlSearchInfo;
    use App\UrlTag;
    use App\UrlTagMap;
    use App\PasswordReset;

    class SettingsController extends Controller{
        /*Method To Get Settings Page View
        *@return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
        *
        */
        public function getSettingsPage(Request $request){
            if(\Auth::check()) {
                $user = \Auth::user();
                $arr = $this->getAllDashboardElements($user, $request);
                
                $subscription_status=$arr['subscription_status'];
                $userPixels = Pixel::where('user_id', Auth::user()->id)->get();
                return view('dashboard-settings.settings',compact('user','arr','subscription_status'));
            } else {
                return redirect()->action('HomeController@getIndex')->with('error','Your Session has expired.. Please log in again!');
            }
        }

        /*Method To Save Redirect Time For User
        * @return Json Response
        *
        */
        public function modifyDefaultRedirectTime(Request $request){
          if(\Auth::check()) {
                try{
                    $user = \Auth::user();
                    $user = User::findOrFail($user->id);
                    $user->default_redirect_time=($request->redirection_time*1000);
                    if($user->save()){
                        return \Response::json(array(
                            'status'               => true,
                            'code'                 => 200,
                            'redirection_time'     => $request->redirection_time,
                            'message'              => "Default Redirection Time Saved"
                        ));
                    }else{
                        return \Response::json(array(
                            'status'   => false,
                            'code'     => 400,
                            'message'  => "Try Again !"
                        ));
                    }
                }catch(\Exception $e){
                    return \Response::json(array(
                        'status'   => false,
                        'code'     => 500,
                        'message'  => $e->getMessage()
                    ));
                }
            }else{

            }
        }

        /*Method To Get Dashboard Element
        * @return Array
        *
        */
        private function getAllDashboardElements($user , $request) {
            //code for search based on tags and description if the params are not empty
            $textToSearch = $request->textToSearch;
            $tagsToSearch = $request->tagsToSearch;
            $pageLimit        = ( $request->limit ) ? $request->limit: 4;

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

        private function getDataOfSearchTags($textToSearch = '', $tagsToSearch = [], $userId) {
            $flag = 0;
            if(strlen(trim($textToSearch)) > 0 || !empty($tagsToSearch)){
                $urls = Url::where('user_id', $userId);
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
                    'tagsToSearch' => $tagsToSearch,
                ];
            } else {
                $urls = Url::where('user_id', $userId)->orderBy('id', 'DESC');
                $count_url = $urls->count();
                return [
                    'urls' => $urls,
                    'count_url' => $count_url,
                    'tagsToSearch' =>[]
                ];
            }
        }
    }