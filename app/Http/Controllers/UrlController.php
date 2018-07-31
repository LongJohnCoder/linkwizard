<?php
    namespace App\Http\Controllers;

    use App\Browser;
    use App\Country;
    use App\IpLocation;
    use App\Limit;
    use App\LinkLimit;
    use App\Pixel;
    use App\PixelScript;
    use App\Platform;
    use App\Profile;
    use App\Referer;
    use App\RefererUrl;
    use App\Subdomain;
    use App\Url;
    use App\UrlSpecialSchedule;
    use App\UrlLinkSchedule;
    use App\User;
    use App\CircularLink;
    use Faker\Provider\File;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Session;
    use App\UrlFeature;
    use App\UrlSearchInfo;
    use App\UrlTag;
    use App\UrlTagMap;
    use App\PasswordReset;
    use App\Geolocation;
    use Mail;
    use App\Http\Requests\ForgotPasswordRequest;
    use Mockery\Exception;
    use Intervention\Image\ImageManagerStatic as Image;
    use App\Timezone;

    class UrlController extends Controller{
        /**
         * Function To Get Short URL Page
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function createLink($linktype){
            if((isset($linktype) && ($linktype=='wizard'))||(isset($linktype) && ($linktype=='rotating'))||(isset($linktype) && ($linktype=='grouplink'))){
                if (Auth::check()) {
                    if(\Session::has('plan')){
                        return redirect()->action('HomeController@getSubscribe');
                    } else {
                        if($linktype=='wizard'){
                            $type=0;
                        }else if($linktype=='rotating'){
                            $type=1;
                        }else{
                            $type=2;
                        }

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
                        $pixelsToManage = Pixel::where('user_id', Auth::user()->id)->get();
                        if(count($pixelsToManage)>0)
                        {
                            $pixels = $pixelsToManage;
                        }
                        elseif(count($pixelsToManage)==0)
                        {
                            $pixels = '';
                        }
                        $timezones = Timezone::all();
                        if(($type==0)||($type==1)){
                            return view('dashboard.shorten_url' , [
                                'urlTags'             => $urlTags,
                                'total_links'         => $total_links,
                                'limit'               => $limit,
                                'subscription_status' => $subscription_status,
                                'user'                => $user,
                                'type'                => $type,
                                'timezones'           => $timezones,
                                'pixels'              => $pixels
                            ]);
                        }else{
                            $grouplink=Url::where('link_type',2)->where('user_id',$user->id)->where('parent_id',0)->orderBy('id','DESC')->with('children')->get();
                            return view('dashboard.grouplink' , compact('user','type','subscription_status','grouplink'));
                        }
                    }
                } else {
                    return redirect()->action('HomeController@getIndex');
                }
            }else{
                abort(404);
            }
        }

        /**
         * Function To Create Short Url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function creatShortUrl(Request $request){
            try{
                if (\Auth::user())
                    $userId = \Auth::user()->id;
                else {
                    $userId = 0;
                }
                //Redirect Link
                if(isset($request->actual_url[0]) && $request->actual_url[0]!=""){
                    if (strpos($request->actual_url[0], 'https://') === 0) {
                        $actualUrl = str_replace('https://', null, $request->actual_url[0]);
                        $protocol  = 'https';
                    }elseif(strpos($request->actual_url[0], 'http://') === 0){
                        $actualUrl = str_replace('http://', null, $request->actual_url[0]);
                        $protocol  = 'http';
                    }else{
                        $actualUrl = $request->actual_url[0];
                        $protocol  = 'http';
                    }
                }else{
                    if($request->type==0){
                        if(isset($request->allowSchedule) && $request->allowSchedule != 'on'){
                            return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect Or Link Scheduler Will Be There.');
                        }
                        else{
                            $actualUrl = NULL;
                            $protocol  = 'http';
                        }
                    }else{
                        return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect');
                    }
                    $actualUrl = NULL;
                    $protocol  = 'http';
                }

                if(isset($request->custom_url_status)&& ($request->custom_url_status=='on')){
                    $checkSuffix=Url::where('shorten_suffix',$request->custom_url)->count();
                    if($checkSuffix >0){
                        return redirect()->back()->with('error', 'This Url Is Already Taken');
                    }
                }
                //Link Preview
                $linkPreview          = isset($request->link_preview_selector) && $request->link_preview_selector == true ? true : false;
                $linkPreviewCustom    = isset($request->link_preview_custom) && $request->link_preview_custom == true ? true : false;
                $linkPreviewOriginal  = isset($request->link_preview_original) && $request->link_preview_original == true ? true : false;
                
                //Facebook pixel id
                $checkboxAddFbPixelid = isset($request->checkboxAddFbPixelid) && $request->checkboxAddFbPixelid == true ? true : false;
                $fbPixelid            = isset($request->fbPixelid) && strlen($request->fbPixelid) > 0 ? $request->fbPixelid : null;

                //Google pixel id
                $checkboxAddGlPixelid = isset($request->checkboxAddGlPixelid) && $request->checkboxAddGlPixelid == true ? true : false;
                $glPixelid            = isset($request->glPixelid) && strlen($request->glPixelid) > 0 ? $request->glPixelid : null;
                
                //Tag
                $allowTags            = isset($request->allowTag) && $request->allowTag == true ? true : false;
                $searchTags           = isset($request->tags) && count($request->tags) > 0 ? $request->tags : null;

                //Description
                $allowDescription     = isset($request->allowDescription) && $request->allowDescription == true ? true : false;
                $searchDescription    = isset($request->searchDescription) && strlen($request->searchDescription) > 0 ? $request->searchDescription : null;

                //Create Short Url Suffix
                $random_string = $this->randomString();

                $url                   = new Url();
                $url->actual_url       = $actualUrl;
                $url->protocol         = $protocol;
                $url->user_id          = $userId;

                //Get Meta Data from browser if user did not provide
                if(preg_match("~^(?:f|ht)tps?://~i", $request->actual_url[0])){
                    $meta_data = $this->getPageMetaContents($request->actual_url[0]);
                    $url2 = $this->fillUrlDescriptions($url, $request, $meta_data);
                    $url_image_name_get = $url2;
                    $og_image = NULL;
                    if(count($url2)>0){
                        $og_image = $url_image_name_get->og_image;
                    }else{
                        $og_image = $meta_data['og_image'];
                    }
                }else{
                    //$url->title = NULL;
                    $og_image = NULL;
                    $meta_data['title'] = NULL;
                    $meta_data['meta_description']= NULL;
                    $meta_data['og_image']= NULL;
                    $meta_data['og_url']= NULL;
                    $meta_data['og_description']= NULL;
                    $meta_data['og_title']= NULL;
                    $meta_data['twitter_image']= NULL;
                    $meta_data['twitter_url']= NULL;
                    $meta_data['twitter_description']= NULL;
                    $meta_data['twitter_title']= NULL;
                }

                // Add Customize settings for urls
                if (isset($request->allowCustomizeUrl) && ($request->allowCustomizeUrl == "on")) {
                    $url->redirecting_time = ($request->redirecting_time*1000);
                    $request->redirecting_text_template = trim(preg_replace('/\s+/', ' ',$request->redirecting_text_template));
                    if ($request->redirecting_text_template != NULL) {
                        $url->redirecting_text_template = $request->redirecting_text_template;
                    }
                    $url->customColour = $request->pageColour;
                    $url->usedCustomised = '1';
                } else {
                   $url->redirecting_time = 5000; 
                }

                // Add favicon
                if (isset($request->allowfavicon) && $request->allowfavicon=='on')
                {
                    if ($request->hasFile('favicon_contents')) {
                        $imgFile        = $request->file('favicon_contents');
                        $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                        $actualFileExtension = $imgFile->getClientOriginalExtension();
                        $validExtensionRegex = '/(jpg|jpeg|png|svg|ico)/i';
                        $uploadPath = 'public/uploads/favicons';
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath,  777 , true);
                        }
                        $newFileName = uniqid() . "-" . date('U');
                        if (preg_match($validExtensionRegex, $actualFileExtension)) {
                            $uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);
                            $url->favicon = '/'.$uploadPath.'/'.$newFileName.'.'.$actualFileExtension;
                        } else {
                            $url->favicon = NULL;
                        }

                    } else {
                        $url->favicon = NULL;
                    }
                } else {
                    $url->favicon = NULL;
                }

                //** expiration values set in the urls table **//
                if (isset($request->allowExpiration) && $request->allowExpiration == 'on'){
                    $url->date_time = date_format(date_create($request->date_time), 'Y-m-d H:i:s');
                    $url->timezone = $request->timezone;
                    if(strlen($request->redirect_url)>0 && preg_match("~^(?:f|ht)tps?://~i", $request->redirect_url)){
                        $url->redirect_url = $request->redirect_url;
                    }else{
                        $url->redirect_url = NULL;
                    }
                }
                if($linkPreview){
                    $linkprev['usability']=1;
                    if($linkPreviewOriginal){
                        $linkprev['main']=0;
                        $linkprev['title']=0;
                        $linkprev['image']=0;
                        $linkprev['description']=0;
                    }
                    if($linkPreviewCustom){
                        $linkprev['main']=1;
                        
                        if(isset($request->org_img_chk) && $request->org_img_chk=='on'){
                            $linkprev['image']=0;
                        }elseif(isset($request->cust_img_chk) && $request->cust_img_chk =='on'){
                            $linkprev['image']=1;
                        }

                        if(isset($request->org_title_chk) && $request->org_title_chk=='on'){
                            $linkprev['title']=0;
                            $url->og_title = $meta_data['og_title'];
                        }elseif(isset($request->cust_title_chk) && $request->cust_title_chk=='on'){
                            $linkprev['title']=1;
                            $url->og_title = $request->title_inp;
                        }

                        if(isset($request->org_dsc_chk) && $request->org_dsc_chk=='on'){
                            $linkprev['description']=0;
                            $url->og_description = $meta_data['og_description'];
                        }elseif(isset($request->cust_dsc_chk) && $request->cust_dsc_chk=='on'){
                            $linkprev['description']=1;
                            $url->og_description = $request->dsc_inp;
                        }
                        if($request->hasFile('img_inp')) {
                            $imgFile        = $request->file('img_inp');
                            $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                            $actualFileExtension = $imgFile->getClientOriginalExtension();
                            $validExtensionRegex = '/(jpg|jpeg|png|svg)/i';
                            $url->og_image = $og_image;
                            if (!preg_match($validExtensionRegex, $actualFileExtension)) {
                                return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
                            }
                        }

                    }
                    $url->meta_description = $meta_data['meta_description'];
                    $url->og_url = $meta_data['og_url'];
                    $url->twitter_image = $meta_data['twitter_image'];
                    $url->twitter_url = $meta_data['twitter_url'];
                    $url->twitter_description = $meta_data['twitter_description'];
                    $url->twitter_title = $meta_data['twitter_title'];
                }else{
                    $linkprev['usability']=0;
                    $linkprev['main']=0;
                    $linkprev['title']=0;
                    $linkprev['image']=0;
                    $linkprev['description']=0;

                    // url details from method getPageMetaContents
                    $url->meta_description = $meta_data['meta_description'];
                    $url->og_image = $meta_data['og_image'];
                    $url->og_url = $meta_data['og_url'];
                    $url->og_description = $meta_data['og_description'];
                    $url->og_title = $meta_data['og_title'];
                    $url->twitter_image = $meta_data['twitter_image'];
                    $url->twitter_url = $meta_data['twitter_url'];
                    $url->twitter_description = $meta_data['twitter_description'];
                    $url->twitter_title = $meta_data['twitter_title'];
                }

                $url->link_preview_type = json_encode($linkprev);
                if(isset($request->custom_url_status)&& ($request->custom_url_status=='on')){
                    $url->is_custom         =1;
                    $url->shorten_suffix    = $request->custom_url;
                }else{
                    $url->shorten_suffix    = $random_string;
                }
                if(isset($request->allowSchedule) && $request->allowSchedule == 'on'){
                    $url->is_scheduled = 'y';
                }else
                {
                    $url->is_scheduled = 'n';
                }
                if($url->save()){
                    //If facebook pixel, Google Pixel
                    if(($checkboxAddFbPixelid && $fbPixelid != null) || ($checkboxAddGlPixelid && $glPixelid != null)) {
                        $urlfeature = new UrlFeature();
                        $urlfeature->url_id = $url->id;
                        if($checkboxAddFbPixelid && $fbPixelid != null) {
                            $urlfeature->fb_pixel_id = $fbPixelid;
                        }
                        if($checkboxAddGlPixelid && $glPixelid != null) {
                          $urlfeature->gl_pixel_id = $glPixelid;
                        }
                        if(!$urlfeature->save()) {
                            return redirect()->back()->with('error', 'Short Url Features Not Saved! Try Again!');
                        }
                    }

                    /**
                     * Manage pixel
                     */
                    if(isset($request->managePixel) && ($request->managePixel))
                    {
                        $pixels = [];
                        //$request->pixels = explode('-', $request->pixels);
                        if(count($request->pixels)>0 && !empty($request->pixels))
                        {
                            for($i=0; $i<count($request->pixels); $i++)
                            {
                                $pixels[] = $request->pixels[$i];
                            }
                            $this->addPixelsToUrlFeature($pixels, $url->id);
                        }
                    }

                    //Add Tag
                    $tag=$this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

                    //** Day wise link schedule for shorten url **//
                    $link_schedule_array = [];

                
                    //Check For Circular Url
                    if($request->type==1){
                        $noOfCircularLinks = count($request->actual_url);
                        if ($noOfCircularLinks > 1) {
                            foreach ($request->input('actual_url') as $actualLink) {
                                $circularLink = new CircularLink();
                                $circularLink->url_id = $url->id;
                                if (strpos($actualLink, 'https://') === 0) {
                                    $actualCirularUrl = str_replace('https://', null, $actualLink);
                                    $cirularProtocol  = 'https';
                                }elseif(strpos($actualLink, 'http://') === 0){
                                    $actualCirularUrl = str_replace('http://', null, $actualLink);
                                    $cirularProtocol  = 'http';
                                }else{
                                    $actualCirularUrl = $actualLink;
                                    $cirularProtocol  = 'http';
                                }
                                $circularLink->actual_link = $actualCirularUrl;
                                $circularLink->protocol = $cirularProtocol;
                                $circularLink->save();
                            }
                            /* Update urls table accordingly */
                        }
                        $url->link_type = 1;
                        $url->no_of_circular_links = $noOfCircularLinks;
                        $url->save();
                    }else if($request->type==0){
                        $link_schedule_array = [];
                        if(isset($request->allowSchedule) && $request->allowSchedule == 'on'){
                            $url->is_scheduled = 'y';
                            /* * Schedule in url_link_schedule table */
                            $link_schedule_array[0] = $request->day1;
                            $link_schedule_array[1] = $request->day2;
                            $link_schedule_array[2] = $request->day3;
                            $link_schedule_array[3] = $request->day4;
                            $link_schedule_array[4] = $request->day5;
                            $link_schedule_array[5] = $request->day6;
                            $link_schedule_array[6] = $request->day7;
                            $this->url_link_schedules($link_schedule_array, $url->id);
                        }
                        /**
                        * Schedule for special day
                        */
                        if(isset($request->allowSchedule) && $request->allowSchedule == 'on'){
                            $spl_dt = [];
                            $spl_url = [];
                            $request->special_date = array_values(array_unique($request->special_date));
                            $request->special_date_redirect_url = array_values($request->special_date_redirect_url);
                            for ($i=0; $i<count($request->special_date); $i++){
                                if($request->special_date[$i]!== "" or !empty($request->special_date[$i])){
                                    $spl_dt[] = date_format(date_create($request->special_date[$i]), 'Y-m-d');
                                }
                                else
                                {
                                    $spl_dt[] = date('0000-00-00');
                                }
                            }

                            for ($j=0; $j<count($request->special_date_redirect_url); $j++){
                                if($request->special_date_redirect_url[$j]!="" or !empty($request->special_date_redirect_url[$j])){
                                    $spl_url[] = $request->special_date_redirect_url[$j];
                                }else
                                {
                                    $spl_url[] = NULL;
                                }
                            }
                            if(count($spl_dt)>0 && count($spl_url)>0){
                                for ($j=0; $j<count($spl_dt); $j++){
                                    if($spl_dt[$j]!='0000-00-00' && preg_match("~^(?:f|ht)tps?://~i", $spl_url[$j])){
                                        $id = $url->id;
                                        $spl_date = $spl_dt[$j];
                                        $spcl_url = $spl_url[$j];
                                        $this->insert_special_schedule_add($id, $spl_date, $spcl_url);
                                    }
                                }
                            }
                        }

                        /**Geo Location**/
                        if(isset($request->addGeoLocation) && $request->addGeoLocation == 'on'){
                            if(isset($request->allow_all) && $request->allow_all == 'on'){
                                $url->geolocation=0;
                            }
                            if(isset($request->deny_all) && $request->deny_all == 'on'){
                                $url->geolocation=1;
                            }
                            $this->addGeoLocation($request, $url->id);
                        }
                        $url->save();
                    }
                    return redirect()->route('getDashboard')->with('success', 'Short Url Created!');
                }else{
                    return redirect()->back()->with('error', 'Short Url Not Created! Try Again!');
                }
            }catch (Exception $e){
                return $e->getMessage();
            }
        }

        /**
         * Add manageable pixels to url_features table
         * @param $pixel
         * @param $url_id
         * @return \Illuminate\Http\RedirectResponse
         */
        private function addPixelsToUrlFeature($pixel, $url_id)
        {
            $urlFeatureColumn = [];
            $pixel_id = [];
            $custom_pixel_script = [];
            try
            {
                if(count($pixel)>0)
                {
                    for($i=0; $i<count($pixel); $i++)
                    {
                        $pixelData = Pixel::find($pixel[$i]);
                        $urlFeatureColumn[] = $pixelData->network;
                        $pixel_id[] = $pixelData->pixel_id;
                        $custom_pixel_script[] = $pixelData->custom_pixel_script;
                    }

                    $urlFeatures = new UrlFeature();
                    $urlFeatures->url_id = $url_id;
                    for($j=0; $j<count($pixel); $j++)
                    {
                        if($urlFeatureColumn[$j] == 'fb_pixel_id')
                        {
                            $urlFeatures->fb_pixel_id = $pixel_id[$j];
                        }
                        elseif($urlFeatureColumn[$j] == 'gl_pixel_id')
                        {
                            $urlFeatures->gl_pixel_id = $pixel_id[$j];
                        }
                        elseif($urlFeatureColumn[$j] == 'twt_pixel_id')
                        {
                            $urlFeatures->twt_pixel_id = $pixel_id[$j];
                        }
                        elseif($urlFeatureColumn[$j] == 'li_pixel_id')
                        {
                            $urlFeatures->li_pixel_id = $pixel_id[$j];
                        }
                        elseif($urlFeatureColumn[$j] == 'pinterest_pixel_id')
                        {
                            $urlFeatures->pinterest_pixel_id = $pixel_id[$j];
                        }
                        elseif($urlFeatureColumn[$j] == 'quora_pixel_id')
                        {
                            $urlFeatures->quora_pixel_id = $pixel_id[$j];
                        }
                        /* DON'T DELETE */
                        elseif($urlFeatureColumn[$j] == 'custom_pixel_id')
                        {
                            $urlFeatures->custom_pixel_id = $custom_pixel_script[$j];
                        }

                    }
                    $urlFeatures->save();
                }
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('error', 'Sorry we\'re having some problem with processing your pixels!');
            }
        }

        /**
         * Function returns view for edit url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function editUrlView($id=NULL){
            if (Auth::check()) {
                try{
                    if (\Session::has('plan')) {
                          return redirect()->action('HomeController@getSubscribe');
                    } else {
                        $user = Auth::user();
                        $url = Url::find($id);
                        if(!$url) {
                            return redirect()->action('HomeController@getDashboard')->with('error','This url have been deleted!');
                        }
                        $urls = Url::where('id',$id)->where('user_id',$user->id)->with('circularLink')->with('urlSearchInfo')->with('getGeoLocation')->first();
                        $count = DB::table('urls')->selectRaw('count(user_id) AS `count`')->where('user_id', $user->id)->groupBy('user_id')->get();
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

                        //Url features
                        $urlFeatures = UrlFeature::where('url_id', $id)->first();
                        $pixel_name = [];
                        $pixel_id = [];
                        $pxId = [];
                        $features = [];
                        $networks = [];
                        $pixel = [];
                        if(count($urlFeatures)>0)
                        {
                            if(!empty($urlFeatures->fb_pixel_id))
                            {
                                $features[] = $urlFeatures->fb_pixel_id;
                                $networks[] = 'fb_pixel_id';
                            }
                            if(!empty($urlFeatures->gl_pixel_id))
                            {
                                $features[] = $urlFeatures->gl_pixel_id;
                                $networks[] = 'gl_pixel_id';
                            }
                            if(!empty($urlFeatures->twt_pixel_id))
                            {
                                $features[] = $urlFeatures->twt_pixel_id;
                                $networks[] = 'twt_pixel_id';
                            }
                            if(!empty($urlFeatures->li_pixel_id))
                            {
                                $features[] = $urlFeatures->li_pixel_id;
                                $networks[] = 'li_pixel_id';
                            }
                            if(!empty($urlFeatures->pinterest_pixel_id))
                            {
                                $features[] = $urlFeatures->pinterest_pixel_id;
                                $networks[] = 'pinterest_pixel_id';
                            }
                            if(!empty($urlFeatures->quora_pixel_id))
                            {
                                $features[] = $urlFeatures->quora_pixel_id;
                                $networks[] = 'quora_pixel_id';
                            }
                            if(!empty($urlFeatures->custom_pixel_id))
                            {
                                $features[] = $urlFeatures->custom_pixel_id;
                                $networks[] = 'custom_pixel_id';
                            }
                            for($i=0; $i<count($networks); $i++)
                            {
                                if($networks[$i]!='custom_pixel_id')
                                {
                                    $pixel = Pixel::where('network', $networks[$i])
                                        ->where('pixel_id', $features[$i])
                                        ->first();
                                    if(count($pixel)>0)
                                    {
                                        $pixel_name[] = $pixel->pixel_name;
                                        $pxId[] = $pixel->id;
                                        $pixel_id[] = $pixel->pixel_id;
                                    }
                                    else
                                    {
                                        $pixel_name[] = ucwords($networks[$i]);
                                        $pixel_id[] = $features[$i];
                                        $pxId[] = 0;
                                    }
                                }
                                else
                                {
                                    $pixel = Pixel::where('network', $networks[$i])
                                        ->where('custom_pixel_script', $features[$i])
                                        ->first();
                                $pixel_name[] = $pixel->pixel_name;
                                $pxId[] = $pixel->id;
                                $pixel_id[] = $pixel->pixel_id;
                                }
                            }
                        }
                        $pixels = Pixel:: where('user_id', $user->id)->get();
                        //dd($pxId);
                        $timezones = Timezone::all();
                        $selectedTags = UrlTagMap::where('url_id',$id)->with('urlTag')->get();
                        return view('dashboard.edit_url', [
                            'urlTags'              => $urlTags,
                            'total_links'          => $total_links,
                            'limit'                => $limit,
                            'subscription_status'  => $subscription_status,
                            'user'                 => $user,
                            'type'                 => $urls->link_type,
                            'selectedTags'         => $selectedTags,
                            'urls'                 => $urls,
                            'pixel_name'           => $pixel_name,
                            'pxId'                 => $pxId,
                            'pixel_id'             => $pixel_id,
                            'pixels'               => $pixels,
                            'timezones'            => $timezones
                        ]);

                    }
                }catch(Exception $e){
                    abort(404); 
                }
            }else{
                abort(404);
            }
        }

        /**
         * Function for edit url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function editUrl(Request $request, $id=NULL){
            if (Auth::check()) {
                try{
                    //Redirect Link
                    if(isset($request->actual_url[0]) && $request->actual_url[0]!=""){
                        if (strpos($request->actual_url[0], 'https://') === 0) {
                            $actualUrl = str_replace('https://', null, $request->actual_url[0]);
                            $protocol  = 'https';
                        }elseif(strpos($request->actual_url[0], 'http://') === 0){
                            $actualUrl = str_replace('http://', null, $request->actual_url[0]);
                            $protocol  = 'http';
                        }else{
                            $actualUrl = $request->actual_url[0];
                            $protocol  = 'http';
                        }
                    }else{
                        if($request->type==0){
                            if(isset($request->allowSchedule) && $request->allowSchedule != 'on'){
                                return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect Or Link Scheduler Will Be There.');
                            }
                            else{
                                $actualUrl = NULL;
                                $protocol  = 'http';
                            }
                        }else{
                            return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect');
                        }
                        $actualUrl = NULL;
                        $protocol  = 'http';
                    }
                    //Tag
                    $allowTags            = isset($request->allowTag) && $request->allowTag == true ? true : false;
                    $searchTags           = isset($request->tags) && count($request->tags) > 0 ? $request->tags : null;

                    //Description
                    $allowDescription     = isset($request->allowDescription) && $request->allowDescription == true ? true : false;
                    $searchDescription    = isset($request->searchDescription) && strlen($request->searchDescription) > 0 ? $request->searchDescription : null;
                    
                    $url = Url::find($id);
                    $url->protocol = $protocol;
                    $url->actual_url = $actualUrl;
                    $actual_og_image = $url->og_image;
                    if (!$request->customizeOption) {
                        $url->usedCustomised = '1';
                        /* Check if the shorten link is already exist or not */
                        if ($url->shorten_suffix != $request->custom_url) {
                            $checkSuffix=Url::where('shorten_suffix',$request->custom_url)->count();
                            if ($checkSuffix >0) {
                                return redirect()->back()->with('error', 'This Url Is Already Taken');
                            }
                            if ($request->custom_url != NULL) {
                                $url->shorten_suffix = $request->custom_url;
                            }
                        }
                        $url->customColour = $request->pageColour;
                        if ($request->redirecting_text_template != NULL) {
                            $url->redirecting_text_template = $request->redirecting_text_template;
                        }
                    } else {
                        $url->usedCustomised = '0';
                    }
                    //Get Meta Data from browser if user did not provide
                    if(preg_match("~^(?:f|ht)tps?://~i", $request->actual_url[0])){
                        $meta_data = $this->getPageMetaContents($request->actual_url[0]);
                        $url2 = $this->fillUrlDescriptions($url, $request, $meta_data);
                        $url_image_name_get = $url2;
                        $og_image = NULL;
                        if(count($url2)>0){
                            $og_image = $url_image_name_get->og_image;
                        }else{
                            $og_image = $meta_data['og_image'];
                        }
                    }else{
                        //$url->title = NULL;
                        $og_image = NULL;
                        $meta_data['title'] = NULL;
                        $meta_data['meta_description']= NULL;
                        $meta_data['og_image']= NULL;
                        $meta_data['og_url']= NULL;
                        $meta_data['og_description']= NULL;
                        $meta_data['og_title']= NULL;
                        $meta_data['twitter_image']= NULL;
                        $meta_data['twitter_url']= NULL;
                        $meta_data['twitter_description']= NULL;
                        $meta_data['twitter_title']= NULL;
                    }

                    // Edit Description
                    if(isset($request->allowDescription) && ($request->allowDescription == "on")){
                        $url->meta_description = $request->searchDescription;
                    }else{
                       $url->meta_description = ""; 
                    }
                    // Edit default redirection settings
                    if (isset($request->allowCustomizeUrl) && ($request->allowCustomizeUrl == "on")) {
                        if ($request->redirecting_time == '') {
                            $request->redirecting_time = 5;
                        }
                        $url->redirecting_time = ($request->redirecting_time*1000);
                        $request->redirecting_text_template = trim(preg_replace('/\s+/', ' ',$request->redirecting_text_template));
                        if ($request->redirecting_text_template != NULL) {
                            $url->redirecting_text_template = $request->redirecting_text_template;
                        }
                        $url->customColour = $request->pageColour;
                        $url->usedCustomised  = '1';
                    } else {
                       $url->usedCustomised = '0';
                    }
                    //Edit Favicon
                    if(isset($request->allowfavicon) && $request->allowfavicon=='on')
                    {
                        $urlInstance = Url::find($id);
                        $oldFavicon = $urlInstance->favicon;
                        if($request->hasFile('favicon_contents'))
                        {
                            $imgFile        = $request->file('favicon_contents');
                            $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                            $actualFileExtension = $imgFile->getClientOriginalExtension();
                            $validExtensionRegex = '/(jpg|jpeg|png|svg|ico)/i';
                            $uploadPath = 'public/uploads/favicons';
                            if (!file_exists($uploadPath))
                            {
                                mkdir($uploadPath,  777 , true);
                            }
                            $newFileName = uniqid() . "-" . date('U');
                            if (preg_match($validExtensionRegex, $actualFileExtension))
                            {
                                if(!empty($oldFavicon) && strlen($oldFavicon)>0)
                                {
                                    unlink(substr($oldFavicon, 1));
                                }
                                $uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);
                                $url->favicon = '/'.$uploadPath.'/'.$newFileName.'.'.$actualFileExtension;
                            }
                            else
                            {
                                if(!empty($oldFavicon) && strlen($oldFavicon)>0)
                                {
                                    $url->favicon = $oldFavicon;
                                }
                                else
                                {
                                    $url->favicon = NULL;
                                }
                            }
                        }
                        else
                        {
                            if(!empty($oldFavicon) && strlen($oldFavicon)>0)
                            {
                                $url->favicon = $oldFavicon;
                            }
                            else
                            {
                                $url->favicon = NULL;
                            }
                        }
                    }
                    else
                    {
                        $urlInstance = Url::find($id);
                        $oldFavicon = $urlInstance->favicon;
                        if(!empty($oldFavicon) && strlen($oldFavicon)>0)
                        {
                            $urlInstance = Url::find($id);
                            $oldFavicon = $urlInstance->favicon;
                            unlink(substr($oldFavicon, 1));
                            $url->favicon = NULL;
                        }
                        else
                        {
                            $url->favicon = NULL;
                        }
                    }
                    //Edit Link Preview
                    $linkPreview          = isset($request->link_preview_selector) && $request->link_preview_selector == true ? true : false;
                    $linkPreviewCustom    = isset($request->link_preview_custom) && $request->link_preview_custom == true ? true : false;
                    $linkPreviewOriginal  = isset($request->link_preview_original) && $request->link_preview_original == true ? true : false;
                    
                    if($linkPreview){
                        $linkprev['usability']=1;
                        if($linkPreviewOriginal){
                            $linkprev['main']=0;
                            $linkprev['title']=0;
                            $linkprev['image']=0;
                            $linkprev['description']=0;
                        }
                        if($linkPreviewCustom){
                            $linkprev['main']=1;
                            
                            if(isset($request->org_img_chk) && $request->org_img_chk=='on'){
                                $linkprev['image']=0;
                            }elseif(isset($request->cust_img_chk) && $request->cust_img_chk =='on'){
                                $linkprev['image']=1;
                                $url->og_image = $actual_og_image;
                            }

                            if(isset($request->org_title_chk) && $request->org_title_chk=='on'){
                                $linkprev['title']=0;
                                $url->og_title = $meta_data['og_title'];
                            }elseif(isset($request->cust_title_chk) && $request->cust_title_chk=='on'){
                                $linkprev['title']=1;
                                $url->og_title = $request->title_inp;
                            }

                            if(isset($request->org_dsc_chk) && $request->org_dsc_chk=='on'){
                                $linkprev['description']=0;
                                $url->og_description = $meta_data['og_description'];
                            }elseif(isset($request->cust_dsc_chk) && $request->cust_dsc_chk=='on'){
                                $linkprev['description']=1;
                                $url->og_description = $request->dsc_inp;
                            }



                            if($request->hasFile('img_inp')) {
                                $imgFile        = $request->file('img_inp');
                                $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                                $actualFileExtension = $imgFile->getClientOriginalExtension();
                                $url->og_image = $og_image;
                                $validExtensionRegex = '/(jpg|jpeg|png)/i';
                                if (!preg_match($validExtensionRegex, $actualFileExtension)) {
                                    return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
                                }
                            }
                        }
                        $url->meta_description = $meta_data['meta_description'];
                        $url->og_url = $meta_data['og_url'];
                        $url->twitter_image = $meta_data['twitter_image'];
                        $url->twitter_url = $meta_data['twitter_url'];
                        $url->twitter_description = $meta_data['twitter_description'];
                        $url->twitter_title = $meta_data['twitter_title'];
                    }else{

                        /*$url->link_preview_type=NULL;
                        $url->og_title=NULL;
                        $url->og_description  =NULL;
                        $url->og_url  =NULL;
                        $url->og_image  =NULL;
                        $url->twitter_title  =NULL;
                        $url->twitter_description  =NULL;
                        $url->twitter_url  =NULL;
                        $url->twitter_image  =NULL;*/

                        // url details from method getPageMetaContents
                        $url->meta_description = $meta_data['meta_description'];
                        $url->og_image = $meta_data['og_image'];
                        $url->og_url = $meta_data['og_url'];
                        $url->og_description = $meta_data['og_description'];
                        $url->og_title = $meta_data['og_title'];
                        $url->twitter_image = $meta_data['twitter_image'];
                        $url->twitter_url = $meta_data['twitter_url'];
                        $url->twitter_description = $meta_data['twitter_description'];
                        $url->twitter_title = $meta_data['twitter_title'];
                        $linkprev['usability']=0;
                        $linkprev['main']=0;
                        $linkprev['title']=0;
                        $linkprev['image']=0;
                        $linkprev['description']=0;
                    }
                    $url->link_preview_type = json_encode($linkprev);

                    /* OLD PIXEL CODES */

//                    if((isset($request->checkboxAddFbPixelid)&&($request->checkboxAddFbPixelid=='on')) || ((isset($request->checkboxAddGlPixelid)&&($request->checkboxAddGlPixelid=='on')))) {
//                        $checkFeature=UrlFeature::where('url_id',$id)->first();
//                        if($checkFeature){
//                           $urlfeature = UrlFeature::where('url_id',$id)->first();
//                        }else{
//                            $urlfeature = new UrlFeature();
//                            $urlfeature->url_id =$id;
//                        }
//                        if(isset($request->checkboxAddFbPixelid)&&($request->checkboxAddFbPixelid=='on')){
//                            $urlfeature->fb_pixel_id = $request->fbPixelid;
//                        }else{
//                            $urlfeature->fb_pixel_id="";
//                        }
//                        if(isset($request->checkboxAddGlPixelid)&&($request->checkboxAddGlPixelid=='on')){
//                            $urlfeature->gl_pixel_id = $request->glPixelid;
//                        }else{
//                            $urlfeature->gl_pixel_id ="";
//                        }
//                        if(!$urlfeature->save()) {
//                            return redirect()->back()->with('error', 'Short Url Features Not Saved! Try Again!');
//                        }
//                    }else{
//                        $deleteFeature=UrlFeature::where('url_id',$id)->delete();
//                    }

                    //Check Rotating Link 
                    if($request->type==1){
                        $noOfLink=count($request->actual_url);
                        $url->no_of_circular_links=$noOfLink;
                        if($noOfLink>1){
                            $currentRotatingLinks=CircularLink::where('url_id',$url->id)->pluck('id')->toArray();
                            $updatedRotatingLinks=$request->url_id;
                            $removableLinks=(array_diff($currentRotatingLinks,$updatedRotatingLinks));
                            $deletedLinks=CircularLink::whereIn('id', $removableLinks)->delete(); 
                            for($i=0; $i < $noOfLink; $i++){
                                if($request->url_id[$i]!=0){
                                    $circularLink = CircularLink::find($request->url_id[$i]);
                                }else{
                                    $circularLink = new CircularLink();
                                    $circularLink->url_id = $url->id;
                                }

                                if (strpos($request->actual_url[$i], 'https://') === 0) {
                                    $actualCirularUrl = str_replace('https://', null, $request->actual_url[$i]);
                                    $cirularProtocol  = 'https';
                                }elseif(strpos($request->actual_url[$i], 'http://') === 0){
                                    $actualCirularUrl = str_replace('http://', null, $request->actual_url[$i]);
                                    $cirularProtocol  = 'http';
                                }else{
                                    $actualCirularUrl = $request->actual_url[$i];
                                    $cirularProtocol  = 'http';
                                }
                                $circularLink->actual_link = $actualCirularUrl;
                                $circularLink->protocol = $cirularProtocol;
                                $circularLink->save();
                            }
                        }

                    }

                    if($request->type==0){
                        /* link expiration edit */
                        if(isset($request->allowExpiration) && $request->allowExpiration=='on'){
                            if(isset($request->date_time)){
                                $url->is_scheduled = 'n';
                                $url->date_time=date_format(date_create($request->date_time), 'Y-m-d H:i:s');
                                $url->timezone=$request->timezone;
                                //$url->redirect_url=$request->redirect_url;
                                if(strlen($request->redirect_url)>0 && preg_match("~^(?:f|ht)tps?://~i", $request->redirect_url)){
                                    $url->redirect_url = $request->redirect_url;
                                }else{
                                    $url->redirect_url = NULL;
                                }
                            }else{
                                $url->date_time=NULL;
                                $url->timezone=NULL;
                                $url->redirect_url=NULL;

                            }
                        }else{
                            $url->date_time=NULL;
                            $url->timezone=NULL;
                            $url->redirect_url=NULL;
                        }
                        /*Geo Location Edit*/
                        if(isset($request->editGeoLocation) && $request->editGeoLocation=='on') {
                            $deleteGeolocation=Geolocation::where('url_id',$url->id)->delete();
                            if(isset($request->allow_all) && $request->allow_all=='on') {
                                $url->geolocation=0;
                            }
                            if(isset($request->deny_all) && $request->deny_all=='on') {
                                $url->geolocation=1;
                            }
                            $addGeoloc=$this->addGeoLocation($request,$url->id);
                        }else{
                            $deleteGeolocation=Geolocation::where('url_id',$url->id)->delete();
                            $url->geolocation=NULL;
                        } 
                        /*link schedule edit*/

                        if(isset($request->allowSchedule) && $request->allowSchedule=='on') {
                            $url->is_scheduled = 'y';
                            /* special schedule pre existing check */

                            // special schedule already exist
                            if($url->urlSpecialSchedules->count() > 0){
                                $request->special_date = array_values(array_unique($request->special_date));
                                $request->special_date_redirect_url = array_values($request->special_date_redirect_url);
                                $this->specialScheduleInsertion($request->special_date, $request->special_date_redirect_url, $id);
                            }else{
                                $this->specialScheduleInsertion($request->special_date, $request->special_date_redirect_url, $id);
                            }

                            /* day-wise schedule pre existing check */

                            // day-wise schedule already exist
                            if($url->url_link_schedules->count() > 0){
                                $link_schedule_array[0] = $request->day1;
                                $link_schedule_array[1] = $request->day2;
                                $link_schedule_array[2] = $request->day3;
                                $link_schedule_array[3] = $request->day4;
                                $link_schedule_array[4] = $request->day5;
                                $link_schedule_array[5] = $request->day6;
                                $link_schedule_array[6] = $request->day7;
                                $this->url_link_schedules($link_schedule_array, $url->id);
                            }else{
                                $link_schedule_array[0] = $request->day1;
                                $link_schedule_array[1] = $request->day2;
                                $link_schedule_array[2] = $request->day3;
                                $link_schedule_array[3] = $request->day4;
                                $link_schedule_array[4] = $request->day5;
                                $link_schedule_array[5] = $request->day6;
                                $link_schedule_array[6] = $request->day7;
                                $this->url_link_schedules($link_schedule_array, $url->id);
                            }
                        } else{
                            $url->is_scheduled = 'n';
                            if($url->urlSpecialSchedules->count() > 0)
                            {
                                $splUrl = UrlSpecialSchedule::where('url_id', $id);
                                $splUrl->delete();
                            }

                            if($url->url_link_schedules->count() > 0) {
                                $dayUrl = UrlLinkSchedule::where('url_id', $id);
                                $dayUrl->delete();
                            }
                        }
                    }

                    //Edit pixels
                    if(isset($request->managePixel) && $request->managePixel=='on')
                    {

                        if(!empty($request->pixels))
                        {
                            $this->managePixel($id, $request->pixels);
                        }
                        else
                        {
                            $urlFeatures = UrlFeature::where('url_id', $id)->first();
                            if(count($urlFeatures)>0)
                            {
                                $urlFeatures->delete();
                            }
                        }
                    }
                    else
                    {
                        $urlFeatures = UrlFeature::where('url_id', $id)->first();
                        if(count($urlFeatures)>0)
                        {
                            $urlFeatures->delete();
                        }
                    }

                    //Edit Tags
                    $tag=$this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);
                    
                    if($url->save()){
                        return redirect()->route('getDashboard')->with('success', 'Url Updated!');
                    }else{
                        return redirect()->back()->with('error', 'Try Again');
                    }
                }catch(Exception $e){
                    return redirect()->back()->with('error', 'Try Again'); 
                }
            }else{
                abort(404);
            }
        }

        /**
         * Manage edit pixel
         * @param $id
         * @param $pixels
         * @return \Illuminate\Http\RedirectResponse
         */
        private function managePixel($id, $pixels)
        {
            try
            {
                if(count($pixels)>0)
                {
                    $urlFeatureCol = [];
                    $pixel_id = [];
                    for($i=0; $i<count($pixels); $i++)
                    {
                        if($pixels[$i]!=0)
                        {
                            $pixel = Pixel::find($pixels[$i]);
                            if($pixel->network!='custom_pixel_id')
                            {
                                $urlFeatureCol[] = $pixel->network;
                                $pixel_id[] = $pixel->pixel_id;
                            }
                            elseif($pixel->network=='custom_pixel_id')
                            {
                                $urlFeatureCol[] = $pixel->network;
                                $pixel_id[] = $pixel->custom_pixel_script;
                            }
                        }
                        elseif ($pixels[$i]==0)
                        {
                            $oldPixel = UrlFeature::where('url_id', $id)
                                            ->pluck('fb_pixel_id', 'gl_pixel_id')
                                            ->all();
                            foreach ($oldPixel as $key=>$val)
                            {
                                $oldPixelFb = $val;
                                $oldPixelGl = $key;
                            }
                            if(!empty($oldPixelFb))
                            {
                                $pixelFbCheck = Pixel::where('user_id', Auth::user()->id)
                                                    ->where('network', 'fb_pixel_id')
                                                    ->where('pixel_id', $oldPixelFb)
                                                    ->get();
                                // old fb pixel found
                                if(count($pixelFbCheck)==0)
                                {
                                    $urlFeatureCol[] = 'fb_pixel_id';
                                    $pixel_id[] = $oldPixelFb;
                                }
                            }
                            if(!empty($oldPixelGl))
                            {
                                $pixelGlCheck = Pixel::where('user_id', Auth::user()->id)
                                    ->where('network', 'gl_pixel_id')
                                    ->where('pixel_id', $oldPixelGl)
                                    ->get();

                                //old google pixel found
                                if(count($pixelGlCheck))
                                {
                                    $urlFeatureCol[] = 'gl_pixel_id';
                                    $pixel_id[] = $oldPixelGl;
                                }
                            }
                        }

                    }

                    $urlFeature = UrlFeature::where('url_id', $id)->first();
                    if(!$urlFeature)
                    {
                        $urlFeature = new UrlFeature();
                        $urlFeature->url_id = $id;
                    }
                    $urlFeature->fb_pixel_id = NULL;
                    $urlFeature->gl_pixel_id = NULL;
                    $urlFeature->twt_pixel_id = NULL;
                    $urlFeature->li_pixel_id = NULL;
                    $urlFeature->pinterest_pixel_id = NULL;
                    $urlFeature->quora_pixel_id = NULL;
                    $urlFeature->custom_pixel_id = NULL;

                    for($i=0; $i<count($urlFeatureCol); $i++)
                    {
                        if ($urlFeatureCol[$i]=='fb_pixel_id')
                        {
                            $urlFeature->fb_pixel_id = $pixel_id[$i];
                        }
                        if ($urlFeatureCol[$i]=='gl_pixel_id')
                        {
                            $urlFeature->gl_pixel_id = $pixel_id[$i];
                        }
                        if ($urlFeatureCol[$i]=='twt_pixel_id')
                        {
                            $urlFeature->twt_pixel_id = $pixel_id[$i];
                        }
                        if ($urlFeatureCol[$i]=='li_pixel_id')
                        {
                            $urlFeature->li_pixel_id = $pixel_id[$i];
                        }
                        if ($urlFeatureCol[$i]=='pinterest_pixel_id')
                        {
                            $urlFeature->pinterest_pixel_id = $pixel_id[$i];
                        }
                        if ($urlFeatureCol[$i]=='quora_pixel_id')
                        {
                            $urlFeature->quora_pixel_id = $pixel_id[$i];
                        }
                        if ($urlFeatureCol[$i]=='custom_pixel_id')
                        {
                            $urlFeature->custom_pixel_id = $pixel_id[$i];
                        }
                    }
                    $urlFeature->save();
                }
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('error' ,'Remove old pixel and add them from pixel manage');
            }
        }


        /**
         * Function Return Meta Content Of Url
         * @return Array
         */
        public function getPageMetaContents($url){
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
                    for ($i = 0; $i < $metas->length; $i++){
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

                        /*switch($m->getAttribute('name')) {
                          //meta data attributes for instagram

                          case 'description':
                                $meta['meta_description'] = $m->getAttribute('content');
                            break;

                          default:
                            # code...
                            break;
                        }*/
                    }
                }
                return $meta;
            } catch(\Exception $e) {
                return $meta;
            }
        }

        /**
         * Function To Delete URL
         * @return Json
         */
        public function deleteUrl($id=NULL){
            try{
                $url = Url::find($id);
                $url->delete();
                echo 0;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }

        /**
         * Update Link Preview.
         *
         * @return string
         */
        private function setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$urlId) {
            $urlTagMap = [];
            $deletePrevTag=UrlTagMap::where('url_id',$urlId)->delete();
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
                if(!$urlSearchInfo=UrlSearchInfo::where('url_id',$urlId)->first()){
                    $urlSearchInfo = new UrlSearchInfo;
                    $urlSearchInfo->url_id = $urlId;
                }
                $urlSearchInfo->description = trim($searchDescription);
                $urlSearchInfo->save();
            }else{
                $deleteDescription=UrlSearchInfo::where('url_id',$urlId)->delete();
            }
            return;
        }

        /**
         * URL suffix random string generator.
         *
         * @return string
         */
        private function randomString(){
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
         * Get Meta Data Of Original URL.
         *
         * @return string
         */
        public function fillUrlDescriptions(Url $url ,Request $request, $meta_data) {

            $url->title             = $meta_data['title'];
            $url->og_image          = $meta_data['og_image'];
            $url->og_description    = $meta_data['og_description'];
            $url->og_url            = $meta_data['og_url'];
            $url->og_title          = $meta_data['og_title'];
            $url->meta_description  = $meta_data['og_description'];
            //twitter data
            $url->twitter_image         = $meta_data['twitter_image'] == null ? $meta_data['og_image'] : $meta_data['twitter_image'];
            $url->twitter_description   = $meta_data['twitter_description'];
            $url->twitter_url           = $meta_data['twitter_url'];
            $url->twitter_title         = $meta_data['twitter_title'];
            
            if(isset($request->link_preview_selector) && strtolower(trim($request->link_preview_selector)) == 'on') {
                if(isset($request->link_preview_original) && strtolower(trim($request->link_preview_original)) == 'on') {
                    return $url;
                }else if(isset($request->link_preview_custom) && strtolower(trim($request->link_preview_custom)) == 'on') {
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
                        $url->og_description        =   $request->dsc_inp;
                        $url->twitter_description   =   $request->dsc_inp;
                        $url->meta_description      =   $request->dsc_inp;
                    } else {
                        $url->og_description        =   $meta_data['og_description'];
                        $url->twitter_description   =   $meta_data['twitter_description'];
                        $url->meta_description      =   $meta_data['og_description'];
                    }

                    if($request->cust_url_chk && strlen($request->url_inp) > 0) {
                        $url->og_url        =   $request->url_inp;
                        $url->twitter_url   =   $request->url_inp;
                    } else {
                        $url->og_url        =   $meta_data['og_url'];
                        $url->twitter_url   =   $meta_data['twitter_url'];
                    }

                    if($request->cust_img_chk && $request->hasFile('img_inp')) {
                        $imgFile        = $request->file('img_inp');
                        $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                        $actualFileExtension = $imgFile->getClientOriginalExtension();
                        $validExtensionRegex = '/(jpg|jpeg|png|svg)/i';
                        $uploadPath = getcwd().'/'.config('settings.UPLOAD_IMG');
                        $newFileName = rand(1000, 9999) . "-" . date('U');
                        $uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);

                        $url->og_image            =   config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/'.config('settings.UPLOAD_IMG').$newFileName.'.'.$actualFileExtension;
                        $url->twitter_image       =   config('settings.SECURE_PROTOCOL').config('settings.APP_LOGIN_HOST').'/'.config('settings.UPLOAD_IMG').$newFileName.'.'.$actualFileExtension;
                    } else {
                        if(isset($url->og_image) && ($url->og_image!=NULL)){
                            $url->og_image            =   $url->og_image;
                            $url->twitter_image       =   $url->og_image;
                        }else{
                            $url->og_image            =   $meta_data['og_image'];
                            $url->twitter_image       =   $meta_data['twitter_url'];
                        }
                        
                    }
                  return $url;
                }
                else {
                  return $url;
                }
            }
        }

        /**
         * Redirect To Main Url
         * @param $url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getRequestedUrl($url) {
            $red_time = 5000;
            $pageColour = '#005C96';
            $redirectionText = 'Redirecting ...';
            $favicon = 'https://tier5.us/images/favicon.ico';
            $imageUrl = 'public/images/Tier5.jpg';
            $search = Url::where('shorten_suffix', $url)->first();
            if(count($search )>0){
                if(!empty($search->favicon) && strlen($search->favicon)>0) {
                    $favicon = $search->favicon;
                }
                $userRedirection = Profile::where('user_id',$search->user_id)->first();
                if(count($userRedirection )>0){
                    if ((isset($userRedirection) ) &&($userRedirection->redirection_page_type==1) ) {
                        if($search->usedCustomised==1){
                            $red_time =  $search->redirecting_time;
                            $pageColour = $search->customColour;
                            $redirectionText = $search->redirecting_text_template;
                            if(isset($search->uploaded_path) && ($search->uploaded_path!="")){
                                $imageUrl = $search->uploaded_path;
                            }
                        } else {
                            $red_time = 0000;
                            $pageColour = '#ffffff';
                            $redirectionText = '';
                            $imageUrl = '';
                        }
                    } else if (isset($userRedirection->redirection_page_type) &&($userRedirection->redirection_page_type==0) ) {
                        if($search->usedCustomised==1){
                            $red_time =  $search->redirecting_time;
                            $pageColour = $search->customColour;
                            $redirectionText = $search->redirecting_text_template;
                            if((isset($userRedirection->pageColor))&&( $userRedirection->pageColor!="") ){
                                $pageColour = $userRedirection->pageColor;  
                            } 
                        } else if($search->usedCustomised==0){
                            $red_time =  $userRedirection->default_redirection_time;
                            if((isset($userRedirection->pageColor))&&( $userRedirection->pageColor!="") ){
                                $pageColour = $userRedirection->pageColor;  
                            } 
                        }
                    }
                } else {
                    if($search->usedCustomised==1){
                        $red_time =  $search->redirecting_time;
                        $pageColour = $search->customColour;
                        $redirectionText = $search->redirecting_text_template;
                        if(isset($search->uploaded_path) && ($search->uploaded_path!="")){
                             $imageUrl = $search->uploaded_path;
                        }
                    } else if($search->usedCustomised==0){
                        if(isset($userRedirection)){
                            $red_time =  $userRedirection->default_redirection_time;
                            $pageColour = $userRedirection->pageColor;
                        }
                    } 

                }
                $url_features = '';
                $pxlValue = UrlFeature::where('url_id', $search->id)->first();
                $pixelIds = [];
                $pixelColumn = [];
                $pixelScript = [];
                if (count($pxlValue)>0) {
                    if (!empty($pxlValue->fb_pixel_id) or $pxlValue->fb_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->fb_pixel_id;
                        $pixelColumn[] = 'fb_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->gl_pixel_id) or $pxlValue->gl_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->gl_pixel_id;
                        $pixelColumn[] = 'gl_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->twt_pixel_id) or $pxlValue->twt_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->twt_pixel_id;
                        $pixelColumn[] = 'twt_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->li_pixel_id) or $pxlValue->li_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->li_pixel_id;
                        $pixelColumn[] = 'li_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->pinterest_pixel_id) or $pxlValue->pinterest_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->pinterest_pixel_id;
                        $pixelColumn[] = 'pinterest_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->quora_pixel_id) or $pxlValue->quora_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->quora_pixel_id;
                        $pixelColumn[] = 'quora_pixel_id';
                        $scriptPos[] = 0;
                    } elseif (!empty($pxlValue->custom_pixel_id) or $pxlValue->custom_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->custom_pixel_id;
                        $pixelColumn[] = 'custom_pixel_id';


                        $pxl = Pixel::where('custom_pixel_script', $pxlValue->custom_pixel_id)->first();
                        if($pxl){
                            $scriptPos[] = $pxl->script_position;
                        } else{
                            $scriptPos[] = 0;
                        }
                    }
                    for ($i=0; $i< count($pixelColumn); $i++) {
                        if($pixelColumn[$i]!='custom_pixel_id'){
                            $scripts = PixelScript::where('network_type', $pixelColumn[$i])->first();
                            $upperColumn = strtoupper($pixelColumn[$i]);
                            $pixelScript[] = str_replace($upperColumn, $pixelIds[$i],$scripts->network_script);
                        } else {
                            $pixelScript[] = $pixelIds[$i];
                        }
                    }
                }
                $user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
                $referer = $_SERVER['HTTP_HOST'];
                return view('redirect', [
                    'url' => $search,
                    'url_features' => $url_features,
                    'suffix' => $url,
                    'pixelScripts' => $pixelScript,
                    'redirectionText'=>$redirectionText,
                    'pageColor' => $pageColour,
                    'favicon' =>$favicon,
                    'imageUrl'=>$imageUrl,
                    'red_time' => $red_time,
                    'referer' => $referer,
                    'user_agent' => $user_agent]
                );
            } else {
                abort(404);
            }
            /*$userRedirection = Profile::where('user_id',$search->user_id)->first();
            if ($userRedirection) {
                $profileSettings = $userRedirection;
                if (!$search->usedCustomised) {
                    $search->redirecting_time = $userRedirection->default_redirection_time;
                    $userRedirectionType = $userRedirection->redirection_page_type;
                } else {
                    $userRedirectionType = 1;
                }   
            } else {
                $profileSettings = 0;
                $userRedirectionType = 0;
            }
            if ($search) {
               
                $url_features = '';
              
                $pxlValue = UrlFeature::where('url_id', $search->id)->first();
                $pixelIds = [];
                $pixelColumn = [];
                $pixelScript = [];
                if (count($pxlValue)>0) {
                    if (!empty($pxlValue->fb_pixel_id) or $pxlValue->fb_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->fb_pixel_id;
                        $pixelColumn[] = 'fb_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->gl_pixel_id) or $pxlValue->gl_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->gl_pixel_id;
                        $pixelColumn[] = 'gl_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->twt_pixel_id) or $pxlValue->twt_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->twt_pixel_id;
                        $pixelColumn[] = 'twt_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->li_pixel_id) or $pxlValue->li_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->li_pixel_id;
                        $pixelColumn[] = 'li_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->pinterest_pixel_id) or $pxlValue->pinterest_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->pinterest_pixel_id;
                        $pixelColumn[] = 'pinterest_pixel_id';
                        $scriptPos[] = 0;
                    }
                    if (!empty($pxlValue->quora_pixel_id) or $pxlValue->quora_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->quora_pixel_id;
                        $pixelColumn[] = 'quora_pixel_id';
                        $scriptPos[] = 0;
                    }
                 
                    elseif (!empty($pxlValue->custom_pixel_id) or $pxlValue->custom_pixel_id!=NULL) {
                        $pixelIds[] = $pxlValue->custom_pixel_id;
                        $pixelColumn[] = 'custom_pixel_id';


                        $pxl = Pixel::where('custom_pixel_script', $pxlValue->custom_pixel_id)->first();
                        if($pxl)
                        {
                            $scriptPos[] = $pxl->script_position;
                        }
                        else
                        {
                            $scriptPos[] = 0;
                        }
                    }
                    for ($i=0; $i< count($pixelColumn); $i++) {
                        if($pixelColumn[$i]!='custom_pixel_id')
                        {
                            $scripts = PixelScript::where('network_type', $pixelColumn[$i])->first();
                            $upperColumn = strtoupper($pixelColumn[$i]);
                            $pixelScript[] = str_replace($upperColumn, $pixelIds[$i],$scripts->network_script);
                        } else {
                            $pixelScript[] = $pixelIds[$i];
                        }
                    }
                }
                if (($profileSettings) && ($search->usedCustomised)) {
                    if ((isset($search->redirecting_time)) && ($search->redirecting_time !== NULL)) {
                       $red_time = $search->redirecting_time;
                    }
                } elseif (($profileSettings) && (!$search->usedCustomised)) {
                    if ((isset($profileSettings->default_redirection_time)) && ($profileSettings->default_redirection_time !== NULL)) {
                        $red_time = $profileSettings->default_redirection_time;
                    } else {
                        $red_time = 5000;
                    }
                    if ((isset($profileSettings->pageColor)) && ($profileSettings->pageColor !== NULL)) {
                        $pageColour = $profileSettings->pageColor;
                    } else {
                        $pageColour = '#005C96';
                    } 
                } else {
                    if ((isset($search->customColour)) && ($search->customColour !== NULL) && ($search->usedCustomised)) {
                        $pageColour = $search->customColour;
                    }
                    if ((isset($search->redirecting_time)) && ($search->redirecting_time !== NULL) && ($search->usedCustomised)) {
                        $red_time = $search->redirecting_time;
                    }
                }
                $user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
                $referer = $_SERVER['HTTP_HOST'];
                return view('redirect', [
                    'redirectionType' => $userRedirectionType,
                    'url' => $search,
                    'url_features' => $url_features,
                    'suffix' => $url,
                    'pixelScripts' => $pixelScript,
                    'pageColor' => $pageColour,
                    'profileSettings' => $profileSettings,
                    'red_time' => $red_time,
                    'referer' => $referer,
                    'user_agent' => $user_agent]
                );

           /* } else {
                abort(404);
            }*/
        }

        /**
        * Get an User Agent and country Information on AJAX request.
        *
        * @param Request $request
        * @return \Illuminate\Http\Response
        */
       
        public function postUserInfo(Request $request) {
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
                if ($cn->save()) {
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

            $ip = IpLocation::where('url_id', $request->url)->first();
            if ($ip) {
                $ip = new IpLocation();
                $ip->url_id = $request->url;
                $ip->ip_address = $request->country['ip'];
                $ip->city = $request->country['city'];
                $ip->country =  $request->country['country_name'];
                $ip->latitude =  $request->country['latitude'];
                $ip->longitude =  $request->country['longitude'];
                $ip->platform = $request->platform;
                $ip->browser = $request->browser;
                $ip->referer = $request->referer;
                // $ip->query_string = $query_string;
                $ip->save();
            } else {
                $ip = new IpLocation();
                $ip->url_id = $request->url;
                $ip->ip_address = $request->country['ip'];
                $ip->city = $request->country['city'];
                $ip->country =  $request->country['country_name'];
                $ip->latitude =  $request->country['latitude'];
                $ip->longitude =  $request->country['longitude'];
                $ip->platform = $request->platform;
                $ip->browser = $request->browser;
                $ip->referer = $request->referer;
                // $ip->query_string = $query_string;
                $ip->save();
            }
            /* End link info stored in ip_locations table */
            $search = Url::where('shorten_suffix', $request->suffix)->with('urlSpecialSchedules','url_link_schedules')->first();
            if ($search->link_type==0) {
                /*Check Url Expire */
                if (($search->date_time!="") && ($search->timezone!="")) {
                    date_default_timezone_set($search->timezone);
                    $date1= date('Y-m-d H:i:s') ;
                    $date2 = $search->date_time;
                    if (strtotime($date1) < strtotime($date2)) {
                         /*Url Not Expired*/
                        if ($search->geolocation=="") {
                            $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                            $redirectUrl=$getUrl['url'];
                            $redirectstatus=$getUrl['status'];
                            $message=$getUrl['message'];
                        } else {
                            if ($search->geolocation==0) {
                                $getDenyed=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('deny',1)->count();

                                if ($getDenyed >0) {
                                    $redirectUrl="";
                                    $redirectstatus=1;
                                    $message="This URL is not accessable from your country";
                                } else {
                                    $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                                    $redirectUrl=$getUrl['url'];
                                    $redirectstatus=$getUrl['status'];
                                    $message=$getUrl['message'];
                                }
                            } else if ($search->geolocation==1) {
                                $getDenyed=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('allow',1)->count();
                                if ($getDenyed >0) {
                                    $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                                    $redirectUrl=$getUrl['url'];
                                    $redirectstatus=$getUrl['status'];
                                    $message=$getUrl['message'];
                                } else {
                                    $redirectUrl="";
                                    $redirectstatus=1;
                                    $message="This URL is not accessable from your country";
                                }
                            }
                        }
                    } else {
                        /* Url Expired */
                        if ($search->redirect_url!="") {
                            $redirectUrl=$search->redirect_url;
                            $redirectstatus=0;
                            $message="";
                        } else {
                            $redirectUrl=NULL;
                            $redirectstatus=1;
                            $message="The Url Is Expired";
                        }
                    }
                } else {
                    if ($search->geolocation==0) {
                        $getDenyed=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('deny',1)->count();

                        if ($getDenyed >0) {
                            $redirectUrl="";
                            $redirectstatus=1;
                            $message="This URL is not accessable from your country";
                        } else {
                            $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                            $redirectUrl=$getUrl['url'];
                            $redirectstatus=$getUrl['status'];
                            $message=$getUrl['message'];
                        }
                    } else if ($search->geolocation==1) {
                        $getDenyed=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('allow',1)->first();
                        if (count($getDenyed) >0) {
                            if ($getDenyed->redirection==0) {
                                $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                                $redirectUrl=$getUrl['url'];
                                $redirectstatus=$getUrl['status'];
                                $message=$getUrl['message'];
                            } else {
                                $redirectUrl=$getDenyed->url;
                                $redirectstatus=0;
                                $message="";
                            }
                        } else {
                            $redirectUrl="";
                            $redirectstatus=1;
                            $message="This URL is not accessable from your country";
                        }
                    } else {
                        $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                        $redirectUrl=$getUrl['url'];
                        $redirectstatus=$getUrl['status'];
                        $message=$getUrl['message'];
                    }   
                }
                /* Check Special Date */
            } else if ($search->link_type==1) {
                $redirectUrl=$search->protocol.'://'.$search->actual_url; 
                if ($search->no_of_circular_links > 1) {
                    $circularLinks = CircularLink::where('url_id', $search->id)->get();
                    $search->actual_url       = $circularLinks[($search->count) % $search->no_of_circular_links]->actual_link;
                    $search->protocol         = $circularLinks[($search->count) % $search->no_of_circular_links]->protocol;

                    /* Save og data for rotating links */
                    $fullUrl =$search->protocol.'://'.$search->actual_url;
                    $metaData = $this->getPageMetaContents($fullUrl);
                    $link_preview_type = json_decode($search->link_preview_type);
                    if ($link_preview_type->main==1) {
                        if ($link_preview_type->image==0) {
                            $search->og_image = $metaData['og_image'];
                        }
                        if ($link_preview_type->title==0) {
                            $search->title = $metaData['title'];
                        }
                        if ($link_preview_type->description==0) {
                            $search->meta_description = $metaData['og_description'];
                            $search->og_description = $metaData['og_description'];
                        }
                        $search->og_title = $metaData['og_title'];
                        $search->og_url = $metaData['og_url'];
                        $search->twitter_title = $metaData['twitter_title'];
                        $search->twitter_description = $metaData['twitter_description'];
                        $search->twitter_url = $metaData['twitter_url'];
                        $search->twitter_image = $metaData['twitter_image'];
                    } else {
                        /* Original meta data for the URL to be added for Rotating Link */
                        $search->title = $metaData['title'];
                        $search->meta_description = $metaData['og_description'];
                        $search->og_description = $metaData['og_description'];
                        $search->og_title = $metaData['og_title'];
                        $search->og_url = $metaData['og_url'];
                        $search->og_image = $metaData['og_image'];
                        $search->twitter_title = $metaData['twitter_title'];
                        $search->twitter_description = $metaData['twitter_description'];
                        $search->twitter_url = $metaData['twitter_url'];
                        $search->twitter_image = $metaData['twitter_image'];
                    }

                }
                $search->save();
                $redirectstatus=0;
                $message="";
            }

            return response()->json(['status' => $status,
                'redirecturl'=>$redirectUrl,
                'redirectstatus'=>$redirectstatus,
                'message'=>$message]);
        }

        /*Function Check  Suffix Availability*/
        public function checkSuffixAvailability(Request $request){
            $search = Url::where('shorten_suffix', $request->suffix)->count();
            if($search>0){
                return response()->json(['status' => 'error']);
            }else{
                return response()->json(['status' => 'success']);
            }
        }

        public function saveLinkSchedule($request, $urlId){
        }

        /**
         * Validating special urls & dates
         * @param $special_date
         * @param $special_date_redirect_url
         * @param $url_id
         */
        public function specialScheduleInsertion($special_date, $special_date_redirect_url, $url_id)
        {
            $spl_dt = [];
            $spl_url = [];
            $special_date = array_values(array_unique($special_date));
            $special_date_redirect_url = array_values($special_date_redirect_url);
            $special_dt = [];
            $special_url = [];
            for ($i=0; $i<count($special_date); $i++)
            {
                if($special_date[$i]!== "" or !empty($special_date[$i]))
                {
                    $spl_dt[] = date_format(date_create($special_date[$i]), 'Y-m-d');
                }
                else
                {
                    $spl_dt[] = '0000-00-00';
                }
            }

            for ($j=0; $j<count($special_date_redirect_url); $j++)
            {

                if($special_date_redirect_url[$j]!="" or !empty($special_date_redirect_url[$j]))
                {
                    $spl_url[] = $special_date_redirect_url[$j];
                }
                else
                {
                    $spl_url[] = NULL;
                }
            }

            if(count($spl_dt)>0 && count($spl_url)>0)
            {
                for ($j=0; $j<count($spl_dt); $j++)
                {
                    if($spl_dt[$j]!='0000-00-00' && preg_match("~^(?:f|ht)tps?://~i", $spl_url[$j]))
                    {
                        $splDay = UrlSpecialSchedule::where('url_id', $url_id)
                            ->where('special_day', $spl_dt[$j])
                            ->first();
                        if(count($splDay)>0)
                        {
                            if($splDay->special_day_url!==$spl_url[$j])
                            {
                                //$special_dt[] = $spl_dt[$j];
                                //$special_url [] =  $spl_url[$j];

                                $splDay->special_day_url = $spl_url[$j];
                                $splDay->save();
                            }
                        }
                        elseif(count($splDay)==0)
                        {
                            $special_dt[] = $spl_dt[$j];
                            $special_url [] =  $spl_url[$j];
                        }
                    }
                }
            }
            //dd($spl_dt);
            $deleteOldSchedule = UrlSpecialSchedule::where('url_id', $url_id)
                ->whereNotIn('special_day', $spl_dt);
            $deleteOldSchedule->delete();

            $id = $url_id;
            $spl_date = $special_dt;
            $spcl_url = $special_url;
            $this->insert_special_schedule($id, $spl_date, $spcl_url);
        }

        /**
         * Day-wise url schedule with model UrlLinkSchedule
         * @param array $schedule
         * @param int $id
         */
        public function url_link_schedules($schedule = [], $id=0)
        {
            $newScheduleArray = [];
            $oldScheduleArray = [];
            foreach ($schedule as $key=>$schUrl)
            {
                $daySchedule = UrlLinkSchedule::where('url_id', $id)
                    ->where('day', $key+1)
                    ->first();
                if(count($daySchedule)>0)
                {
                    if($daySchedule->protocol.'://'.$daySchedule->url !== $schUrl && $schUrl!=="")
                    {
                        $fullURL = explode('://', $schUrl);
                        $daySchedule->url = $fullURL[1];
                        $daySchedule->protocol = $fullURL[0];
                        $daySchedule->save();
                        $oldScheduleArray[] = ($key+1);
                    }
                    elseif($daySchedule->protocol.'://'.$daySchedule->url === $schUrl && $schUrl!=="")
                    {
                        $oldScheduleArray[] = ($key+1);
                    }
                }
                elseif(count($daySchedule)==0)
                {
                    if(!empty($schUrl) && strlen($schUrl)>0)
                    {
                        if(preg_match("~^(?:f|ht)tps?://~i", $schUrl))
                        {
                            $newScheduleArray [] = ($key+1).'|'.$schUrl;
                            $oldScheduleArray[] = ($key+1);
                        }
                    }
                }
            }
            //dd($oldScheduleArray);
            for($i=0; $i<count($newScheduleArray); $i++)
            {
                if(!empty($newScheduleArray[$i]) && strlen($newScheduleArray[$i])>0)
                {
                    $dayAndUrl = explode('|', $newScheduleArray[$i]);
                    $schedule_link = explode('://', $dayAndUrl[1]);
                    $protocol = $schedule_link[0];
                    $redirectedUrl = $schedule_link[1];
                    $urlLinkSchedule = new UrlLinkSchedule();
                    $urlLinkSchedule->url_id = $id;
                    $urlLinkSchedule->url = $redirectedUrl;
                    $urlLinkSchedule->protocol = $protocol;
                    $urlLinkSchedule->day = $dayAndUrl[0];
                    $urlLinkSchedule->save();
                }
            }
            $deleteOldSchedule = UrlLinkSchedule::where('url_id', $id)
                ->whereNotIn('day', $oldScheduleArray);
            $deleteOldSchedule->delete();
        }

        /**
         * Inserting special date & urls in edit
         * @param $id
         * @param $spl_date
         * @param $spl_url
         */
        public function insert_special_schedule($id, $spl_date, $spl_url)
        {
            try
            {
                for($i=0; $i<count($spl_date); $i++)
                {
                    if(preg_match("~^(?:f|ht)tps?://~i", $spl_url[$i]))
                    {
                        $special_schedule = new UrlSpecialSchedule();
                        $special_schedule->url_id = $id;
                        $special_schedule->special_day = $spl_date[$i];
                        $special_schedule->special_day_url = $spl_url[$i];
                        $special_schedule->save();
                    }
                }
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }

        }

        /**
        * Inserting special date & urls in create
        */
        public function insert_special_schedule_add($id=0, $spl_date='0000-00-00', $spl_url=NULL)
        {
            try
            {
                if(preg_match("~^(?:f|ht)tps?://~i", $spl_url))
                {
                    $special_schedule = new UrlSpecialSchedule();
                    $special_schedule->url_id = $id;
                    $special_schedule->special_day = $spl_date;
                    $special_schedule->special_day_url = $spl_url;
                    $special_schedule->save();
                }
            }catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }


        /**
         *  Add special schedules for links
         * @param $url
         * @param $queryString
         * @return mixed
         */
        public function schedulSpecialDay($url, $queryString){
            $urlSpecialSchedules = UrlSpecialSchedule::where('url_id', $url->id)->get();
            if(count($urlSpecialSchedules)>0){
                foreach ($urlSpecialSchedules as $key=>$urlSplUrl){
                    if($urlSplUrl->special_day==date('Y-m-d')){
                        $redirect['status']=0;
                        if($queryString!=='' && strlen($queryString)>0){
                            $redirect['url']=$urlSplUrl->special_day_url.'?'.$queryString;
                        }else{
                            $redirect['url']=$urlSplUrl->special_day_url;
                        }
                        $redirect['message']="";
                        return $redirect;
                        break;
                    }
                }
                $redirect=$this->schedularWeeklyDaywise($url, $queryString);
                return $redirect;
            }else{
                $redirect=$this->schedularWeeklyDaywise($url, $queryString);
                return $redirect;
            }
        }

        /**
         * Weekly schedule for links
         * @param $url
         * @param $queryString
         * @return mixed
         */
        public function schedularWeeklyDaywise($url, $queryString){
            $url_link_schedules = UrlLinkSchedule::where('url_id', $url->id)->get();
            if($url->is_scheduled =='y' && count($url_link_schedules)>0){
                $day = date('N');
                foreach($url_link_schedules as $schedule){
                    if ($schedule->day==$day){
                        $redirect['status']=0;
                        if($queryString!=='' && strlen($queryString)>0){
                            $redirect['url']=$schedule->protocol.'://'.$schedule->url.'?'.$queryString;
                        }else{
                            $redirect['url']=$schedule->protocol.'://'.$schedule->url;
                        }
                        $redirect['message']="";
                        break;
                    }else{
                        if(!empty($url->actual_url) or $url->actual_url!=NULL){
                            $redirect['status']=0;
                            if($queryString!=='' && strlen($queryString)>0){
                                $redirect['url']=$url->protocol.'://'.$url->actual_url.'?'.$queryString;
                            }else{
                                $redirect['url']=$url->protocol.'://'.$url->actual_url;
                            }
                            $redirect['message']="";
                        }else{
                            $redirect['status']=1;
                            $redirect['url']=NULL;
                            $redirect['message']="No Link Available To Redirect For Today";
                        }
                    }
                }
            }else{
                if(!empty($url->actual_url) or $url->actual_url!=NULL){
                    $redirect['status']=0;
                    if($queryString!=='' && strlen($queryString)>0){
                        $redirect['url']=$url->protocol.'://'.$url->actual_url.'?'.$queryString;
                    }else{
                        $redirect['url']=$url->protocol.'://'.$url->actual_url;
                    }
                    $redirect['message']="";

                }else{
                    $redirect['status']=1;
                    $redirect['url']=NULL;
                    $redirect['message']="No Link Available For Redirection";
                }
            }
            return $redirect;
        }

        /**
            *  Validating special urls & dates
            */
      /*  public function specialScheduleInsertion($special_date, $special_date_redirect_url, $url_id){
            $spl_dt = [];
            $spl_url = [];

            $special_dt = [];
            $special_url = [];
            for ($i=0; $i<count($special_date); $i++){
                if($special_date[$i]!== "" or !empty($special_date[$i])){
                    $spl_dt[] = date_format(date_create($special_date[$i]), 'Y-m-d');
                }
            }

            for ($j=0; $j<count($special_date_redirect_url); $j++){
                if($special_date_redirect_url[$j]!="" or !empty($special_date_redirect_url[$j])){
                    $spl_url[] = $special_date_redirect_url[$j];
                }
            }

            if(count($spl_dt)>0 && count($spl_url)>0){
                for ($j=0; $j<count($spl_dt); $j++){
                    $splDay = UrlSpecialSchedule::where('url_id', $url_id)
                                                ->where('special_day', $spl_dt[$j])
                                                ->first();
                    if(count($splDay)>0){
                        if($splDay->special_day_url!==$spl_url[$j]){
                            $splDay->special_day_url = $spl_url[$j];
                            $splDay->save();
                        }
                    }elseif(count($splDay)==0){
                        $special_dt[] = $spl_dt[$j];
                        $special_url [] =  $spl_url[$j];
                    }
                }
            }
            $deleteOldSchedule = UrlSpecialSchedule::where('url_id', $url_id)
                                                ->whereNotIn('special_day', $spl_dt);
            $deleteOldSchedule->delete();
            $id = $url_id;
            $spl_date = $special_dt;
            $spcl_url = $special_url;
            $this->insert_special_schedule($id, $spl_date, $spcl_url);
        }*/

        public function addGeoLocation($request,$urlId){
            try{
                if(count($request->denyCountryName)>0){
                    for($i=0; $i<count($request->denyCountryName); $i++ ){
                        $geoLocation = new Geolocation();
                        $geoLocation->url_id= $urlId;
                        $geoLocation->country_name=$request->denyCountryName[$i];
                        $geoLocation->country_code=$request->denyCountryCode[$i];
                        $geoLocation->allow=$request->allowed[$i];
                        if(!empty($request->denied[$i]) || $request->denied[$i]!=NULL){
                            $geoLocation->deny=$request->denied[$i];
                        }else{
                            $geoLocation->deny = 0;
                        }
                        if($request->redirectUrl[$i]==''){
                            $geoLocation->redirection=0;
                        }else{
                           $geoLocation->redirection=1; 
                        }
                        $geoLocation->url=$request->redirectUrl[$i];
                        $geoLocation->save();
                    }

                }
                /*return \Response::json(array(
                    'status' => true,
                    'status_code' => 200,
                   
                ));*/
            } catch (Exception $e) {
                return \Response::json(array(
                    'status' => false,
                    'status_code' => 500,
                    'message'   => $e->getMessage()
                ));
            }
        }


        // All information need to load header file

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
            // $textToSearch = $request->textToSearch;
            // $tagsToSearch = $request->tagsToSearch;
            $flag = 0;
            //echo strlen(trim($textToSearch));exit();
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
                //print_r($urls->toSql());die();
                //$urls = $urls;
                $count_url = $urls->count();
                return [
                    'urls' => $urls,
                    'count_url' => $count_url,
                    'tagsToSearch' => $tagsToSearch,

                ];
            } else {

                $urls = Url::where('user_id', $userId)
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
         * To check for duplicate Pixel Name via ajax call
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function checkPixelName(Request $request)
        {
            try
            {
                if (Auth::check())
                {
                    $userId = Auth::user()->id;
                    if (strlen($request->name) > 0 && !empty($request->name))
                    {
                        $pixel = Pixel::where('pixel_name', $request->name)
                                        ->where('user_id', $userId)
                                        ->first();
                        if(count($pixel)>0)
                        {
                            echo json_encode(['status'=>'403', 'message'=>'name already exist']);
                        }
                        elseif(count($pixel)==0)
                        {
                            echo json_encode(['status'=>'200', 'message'=>'name ok']);
                        }
                    }
                    else
                    {
                        echo json_encode(['status'=>'404', 'message'=>'no name given']);
                    }
                }
            }catch(Exception $e)
            {
                return redirect()->back()->with('msg', 'error');
            }
        }

        /**
         * To check for duplicate Pixel ID via ajax call
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function checkPixelId(Request $request)
        {
            try
            {
                if(Auth::check())
                {
                    $userId = Auth::user()->id;
                    if(strlen($request->id)>0 && !empty($request->id))
                    {
                        $pixel = Pixel::where('pixel_id', $request->id)
                                      ->where('user_id', $userId)
                                      ->first();
                        if(count($pixel)>0)
                        {
                            echo json_encode(['status'=>'403', 'message'=>'id already exist']);
                        }
                        elseif(count($pixel)==0)
                        {
                            echo json_encode(['status'=>'200', 'message'=>'id ok']);
                        }
                    }
                    else
                    {
                        echo json_encode(['status'=>'404', 'message'=>'no name given']);
                    }
                }
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('msg', 'error');
            }
        }

        /**
         * View for profile
         * @param Request $request
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function profile(Request $request)
        {
            if (Auth::check()) {
                if (Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {
                    $user=User::where('id',Auth::User()->id)->first();
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
                    $arr = $this->getAllDashboardElements($user, $request);
                    $userPixels = Pixel::where('user_id', Auth::user()->id)->get();
                    $profile = Profile::where('user_id', Auth::user()->id)->exists();
                    if (!$profile) {
                        $profile = new Profile();
                        $profile->user_id = Auth::user()->id;
                        $profile->save();
                    }
                    $profileSettings = Profile::where('user_id', Auth::user()->id)->first();
                    if ($profileSettings->redirection_page_type) {
                        $checkRedirectPageZero = '';
                        $checkRedirectPageOne = 'checked';
                    } else {
                        $checkRedirectPageZero = 'checked';
                        $checkRedirectPageOne = '';
                    }
                    $redirectionTime = $profileSettings->default_redirection_time/1000;
                    $skinColour = $profileSettings->pageColor;
                    $userPixels = Pixel::where('user_id', Auth::user()->id)->get();
                    return view('profile', compact('arr', 'userPixels', 'checkRedirectPageZero', 'checkRedirectPageOne', 'redirectionTime', 'skinColour','user','subscription_status','userPixels'));
                }
            }
        }

        public function saveProfile(Request $request)
        {
            try
            {
                if(Auth::check())
                {
                    $userId = Auth::user()->id;
                    $profile = Profile::where('user_id', $userId)->first();
                        if (isset($request->redirection_page_type_one) && $request->redirection_page_type_one=='on') {
                            $profile->redirection_page_type = 1;
                        } elseif (isset($request->redirection_page_type_zero) && $request->redirection_page_type_zero=='on') {
                            $profile->redirection_page_type = 0;
                        } else {
                            $profile->redirection_page_type = 0;
                        }

                        if (isset($request->default_redirection_time)) {
                            $profile->default_redirection_time = $request->default_redirection_time*1000;
                        } elseif (isset($request->redirection_page_type_one) && $request->redirection_page_type_one=='on') {
                            $profile->default_redirection_time = 0000;
                        } else {
                            $profile->default_redirection_time = 5000;
                        }
                        $profile->pageColor = $request->pageColor;
                        /* Checking for image */
                        if ($request->hasFile('default_image')) {
                            if (!file_exists('public/uploads/brand_images')) {
                                mkdir('public/uploads/brand_images', 777 , true);
                            }
                            $upload_path ='public/uploads/brand_images';
                            $image_name = uniqid()."-".$request->default_image->getClientOriginalName();
                            $data = getimagesize($request->default_image);
                            $width = $data[0];
                            $height = $data[1];

                            /* image resizing */
                            $temp_height = 450;
                            $abs_width = ceil(($width*$temp_height)/$height);
                            $abs_height = $temp_height;
                            $image_resize = Image::make($request->default_image->getRealPath());
                            $image_resize->resize($abs_width, $abs_height);
                            $image_resize->save($upload_path.'/'.$image_name);
                            $profile->default_image = $upload_path.'/'.$image_name;
                        }
                        $profile->save();
                    return redirect()->back()->with('msg', 'success');
                }
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('msg', 'error');
            }
        }

        public function createsingleGroupLink(Request $request){
            try{
                if (Auth::check()){
                    //Create Short Url Suffix
                    $random_string = $this->grouplinkSuffix();
                    date_default_timezone_set("UTC");
                    $url                   = new Url();
                    $url->protocol         = 'http';
                    $url->title            = $request->linktitle;
                    $url->user_id          = Auth::user()->id;
                    $url->link_type        = 2;
                    $url->parent_id        = 0;
                    $url->shorten_suffix   = $random_string;
                    $url->created_at       = date("Y-m-d H:i:s");
                    $url->updated_at       = date("Y-m-d H:i:s");
                    if($url->save()){
                        return \Response::json([
                            'status'    => true,
                            'code'      => 200,
                            'message'   => "Group Link Created!"
                        ]);

                    }else{
                        return \Response::json(array(
                            'status' => false,
                            'code' => 400,
                            'message'   => "Group Link Is Not Created!"
                        ));
                    }
                }
            }catch(Exception $e){
                return \Response::json(array(
                    'status' => false,
                    'code' => 500,
                    'message'   => "Try Again!"
                ));
            }
        }

        /**
        * URL suffix random string generator.
        *
        * @return string
        */
        private function grouplinkSuffix(){
            $character_set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_string = null;
            for ($i = 0; $i < 8; ++$i) {
                $random_string = $random_string.$character_set[rand(0, strlen($character_set)-1)];
            }
            $random_string ='grp-'.$random_string;
            if (Url::where('shorten_suffix', $random_string)->first()) {
                $this->RandomString();
            } else {
                return $random_string;
            }
        }

        public function showGroupDetails($groupId){
            try{
                $user=User::where('id',Auth::User()->id)->first();
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
                $groupId=base64_decode($groupId);
                if (is_numeric($groupId)) {
                    $getGroupDetails=Url::where('id',$groupId)->where('link_type',2)->where('user_id',Auth::User()->id)->first();
                    if(count($getGroupDetails)>0){
                        $getSubLink=Url::where('parent_id',$groupId)->where('link_type',2)->where('user_id',Auth::User()->id)->get();
                        return view('dashboard.grouplinkdetails',compact('getGroupDetails','getSubLink','user','subscription_status'));
                    }else{
                        return redirect()->back()->with('error', 'No Group Found!');
                    }
                }else{
                    return redirect()->back()->with('error', 'No Group Found!');
                }
            }catch(Exception $e){
               abort(404);
            }
        }

        public function deleteGroupLink(Request $request){
            if(Auth::check()){
                try{
                    $linkId=base64_decode($request->linkid);
                    if($linkId){
                        $deleteGroupLink=Url::where('id',$linkId)->where('user_id',Auth::User()->id)->delete();
                        if($deleteGroupLink){
                            $response = [
                                "status"    => true,
                                "message"   => "Link Deleted Successfully !",
                            ];
                            $responseCode=200;

                        }else{
                            $response = [
                                "status"    => false,
                                "message"   => "Link Not Deleted !",
                            ];
                            $responseCode=400;
                        }
                    }else{
                        $response = [
                            "status"    => false,
                            "message"   => "This Not A Link To Delete!",
                        ];
                        $responseCode=400;
                    }
                }catch(Exception $e){
                    $response = [
                        "status"    => false,
                        "message"   => $exp->getMessage(),
                    ];
                    $responseCode=500;
                }
                return \Response::json($response,$responseCode);
            }else{
                return redirect()->action('HomeController@getIndex');
            }
        }
    }



