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
    use App\DefaultSettings;
    use App\PixelProviders;
    use App\UserPixels;
    use App\PixelUrl;

    class UrlController extends Controller{
        /**
         * Function To Get Short URL Page
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function createLink($linktype){
            if( (isset($linktype)) && ( $linktype=='wizard' ||$linktype=='rotating' || $linktype=='grouplink' || $linktype=='filelink' ) ){
                if (Auth::check()) {
                    if(\Session::has('plan')){
                        return redirect()->action('HomeController@getSubscribe');
                    } else {
                        if($linktype=='wizard'){
                            $type=0;
                        }else if($linktype=='rotating'){
                            $type=1;
                        }else if($linktype=='filelink'){
                            $type=3;
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
                        /* Geting the user profiles */
                        $pixelsToManage = UserPixels::where('user_id', Auth::user()->id)->get();
                        /* Getting all the available pixel provider which is active*/
                        $pixelProviders = PixelProviders::where('is_active','1')->get();
                        if(count($pixelsToManage)>0) {
                            $pixels = $pixelsToManage;
                        } elseif(count($pixelsToManage)==0) {
                            $pixels = '';
                        }
                        $timezones = Timezone::all();
                        /* Getting the default settings */
                        $defaultSettings = DefaultSettings::all();
                        $red_time = $defaultSettings[0]->default_redirection_time;
                        $pageColour = $defaultSettings[0]->page_color;
                        $redirecting_text = $defaultSettings[0]->default_redirecting_text;
                        $default_image = $defaultSettings[0]->default_image;
                        /* Getting the profile settings if exist */
                        $profileSettings = Profile::where('user_id',Auth::user()->id)->first();
                        if (count($profileSettings)>0) {
                            $red_time = $profileSettings->default_redirection_time;
                            $pageColour = $profileSettings->pageColor;
                            $redirecting_text = $profileSettings->default_redirecting_text;
                            $default_image = $profileSettings->default_image;
                        }
                        return view('dashboard.shorten_url' , [
                            'urlTags'             => $urlTags,
                            'total_links'         => $total_links,
                            'limit'               => $limit,
                            'subscription_status' => $subscription_status,
                            'user'                => $user,
                            'type'                => $type,
                            'timezones'           => $timezones,
                            'pixels'              => $pixels,
                            'pixelProviders'      => $pixelProviders,
                            'red_time'            => $red_time,
                            'pageColor'           => $pageColour,
                            'redirecting_text'    => $redirecting_text,
                            'default_image'       => $default_image
                        ]);
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
            try {
                if (\Auth::user())
                    $userId = \Auth::user()->id;
                else {
                    $userId = 0;
                }
                //Redirect Link
                if ($request->hasFile('inputfile') && $request->type==3) {
                  $inputFile = $request->file('inputfile');
                  $fileName = $userId.'LW'.time().'.'.$inputFile->getClientOriginalExtension();
                  \Storage::disk('local')->put('upload/'.$fileName, (string) file_get_contents($inputFile), 'public');
                  $fileUrl = \Storage::disk('local')->url('upload/'.$fileName);
                  $downloadUrl = url('/api/downloadfile/'.$fileName);
                  if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)) {
                    $actualUrl = str_replace('https://', null, $downloadUrl);
                    $protocol  = 'https';
                  } else {
                    $actualUrl = str_replace('http://', null, $downloadUrl);
                    $protocol  = 'http';
                  }
                }else if(isset($request->actual_url[0]) && $request->actual_url[0]!=""){
                    if (strpos($request->actual_url[0], 'https://') === 0) {
                        $actualUrl = str_replace('https://', null, $request->actual_url[0]);
                        $protocol  = 'https';
                    } elseif(strpos($request->actual_url[0], 'http://') === 0) {
                        $actualUrl = str_replace('http://', null, $request->actual_url[0]);
                        $protocol  = 'http';
                    } else {
                        $actualUrl = $request->actual_url[0];
                        $protocol  = 'http';
                    }
                } else {
                    if ($request->type==0) {
                        if (isset($request->allowSchedule) && $request->allowSchedule != 'on') {
                            return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect Or Link Scheduler Will Be There.');
                        } else {
                            $actualUrl = NULL;
                            $protocol  = 'http';
                        }
                    } else if ($request->type==2){
                        $protocol  = 'http';
                        $actualUrl = NULL;
                        $urltitle  = $request->group_url_title;
                    } else {
                        return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect');
                    }
                    $actualUrl = NULL;
                    $protocol  = 'http';
                }

                if (isset($request->custom_url_status)&& ($request->custom_url_status=='on')) {
                    $checkSuffix=Url::where('shorten_suffix',$request->custom_url)->count();
                    if ($checkSuffix >0) {
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
                if (preg_match("~^(?:f|ht)tps?://~i", $request->actual_url[0])) {
                    $meta_data = $this->getPageMetaContents($request->actual_url[0]);
                    $url2 = $this->fillUrlDescriptions($url, $request, $meta_data);
                    $url_image_name_get = $url2;
                    $og_image = NULL;
                    if (count($url2)>0) {
                        $og_image = $url_image_name_get->og_image;
                    } else {
                        $og_image = $meta_data['og_image'];
                    }
                }elseif($request->type==3){
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
                  $url2 = $this->fillUrlDescriptions($url, $request, $meta_data);
                  $url_image_name_get = $url2;
                  $og_image = NULL;
                  if (count($url2)>0) {
                      $og_image = $url_image_name_get->og_image;
                  } else {
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
                /* Getting the default settings */
                $defaultSettings = DefaultSettings::all();
                /* Getting the profile settings if exist */
                $profileSettings = Profile::where('user_id',Auth::user()->id)->first();
                /* Add Customize settings for urls */
                if (isset($request->allowCustomizeUrl) && ($request->allowCustomizeUrl == "on")) {
                    $url->redirecting_time = ($request->redirecting_time*1000);
                    $request->redirecting_text_template = trim(preg_replace('/\s+/', ' ',$request->redirecting_text_template));
                    if ($request->redirecting_text_template != NULL) {
                        $url->redirecting_text_template = $request->redirecting_text_template;
                    } else {
                        $url->redirecting_text_template = $defaultSettings[0]->default_redirecting_text;
                    }
                    /* Checking for image */
                    if ($request->hasFile('custom_brand_logo')) {
                        /* checking file type */
                        $allowedExt = array('jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF');
                        $imageExt = $request->custom_brand_logo->getClientOriginalExtension();
                        if (!in_array($imageExt, $allowedExt)) {
                            return redirect()->back()->with('imgErr', 'error');
                        }
                        if (!file_exists('public/uploads/brand_images')) {
                            mkdir('public/uploads/brand_images', 0777 , true);
                        }
                        try {
                            $upload_path ='public/uploads/brand_images';
                            $image_name = uniqid()."-".$request->custom_brand_logo->getClientOriginalName();
                            $data = getimagesize($request->custom_brand_logo);
                            $width = $data[0];
                            $height = $data[1];

                            /* image resizing */
                            $temp_height = 450;
                            $abs_width = ceil(($width*$temp_height)/$height);
                            $abs_height = $temp_height;
                            $image_resize = Image::make($request->custom_brand_logo->getRealPath());
                            $image_resize->resize($abs_width, $abs_height);
                            $image_resize->save($upload_path.'/'.$image_name);
                            $url->uploaded_path = $upload_path.'/'.$image_name;
                        } catch (\Exception $e) {
                            return redirect()->back()->with('imgErr', 'error');
                        }
                    } else if (isset($profileSettings) && ($profileSettings->default_image != '')) {
                            $url->uploaded_path = $profileSettings->default_image;
                    }
                    $url->customColour = $request->pageColour;
                    $url->usedCustomised = '1';
                } else {
                    if (count($profileSettings)>0) {
                        if (isset($profileSettings->default_redirection_time)) {
                            $url->redirecting_time = $profileSettings->default_redirection_time;
                        }
                    } else {
                        if (isset($defaultSettings)) {
                            $url->redirecting_time = $defaultSettings[0]->default_redirection_time;
                        }
                    }
                }

                // Add favicon
                if (isset($request->allowfavicon) && $request->allowfavicon=='on') {
                    if ($request->hasFile('favicon_contents')) {
                        $imgFile        = $request->file('favicon_contents');
                        $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                        $actualFileExtension = $imgFile->getClientOriginalExtension();
                        $validExtensionRegex = '/(jpg|jpeg|png|svg|ico)/i';
                        $uploadPath = 'public/uploads/favicons';
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath,  0777 , true);
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
                    if (strlen($request->redirect_url)>0 && preg_match("~^(?:f|ht)tps?://~i", $request->redirect_url)) {
                        $url->redirect_url = $request->redirect_url;
                    } else {
                        $url->redirect_url = NULL;
                    }
                }
                if ($linkPreview) {
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
                            // $url->og_title = $meta_data['og_title'];
                        }elseif(isset($request->cust_title_chk) && $request->cust_title_chk=='on'){
                            $linkprev['title']=1;
                            // $url->og_title = $request->title_inp;
                        }

                        if(isset($request->org_dsc_chk) && $request->org_dsc_chk=='on'){
                            $linkprev['description']=0;
                            // $url->og_description = $meta_data['og_description'];
                        }elseif(isset($request->cust_dsc_chk) && $request->cust_dsc_chk=='on'){
                            $linkprev['description']=1;
                            // $url->og_description = $request->dsc_inp;
                        }
                        if($request->hasFile('img_inp')) {
                            $imgFile        = $request->file('img_inp');
                        //     $actualFileName = $userId.'MT'.time().'.'.$imgFile->getClientOriginalExtension();
                            $actualFileExtension = $imgFile->getClientOriginalExtension();
                            $validExtensionRegex = '/(jpg|jpeg|png|svg)/i';
                        //     $url->og_image = $og_image;
                            if (!preg_match($validExtensionRegex, $actualFileExtension)) {
                                return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
                            }
                        }

                    }
                    // $url->meta_description = $meta_data['meta_description'];
                    // $url->og_url = $meta_data['og_url'];
                    // $url->twitter_image = $meta_data['twitter_image'];
                    // $url->twitter_url = $meta_data['twitter_url'];
                    // $url->twitter_description = $meta_data['twitter_description'];
                    // $url->twitter_title = $meta_data['twitter_title'];
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
                if (isset($request->custom_url_status)&& ($request->custom_url_status=='on')) {
                    $url->is_custom         =1;
                    $url->shorten_suffix    = $request->custom_url;
                } else {
                    $url->shorten_suffix    = $random_string;
                }
                if (isset($request->allowSchedule) && $request->allowSchedule == 'on') {
                    $url->is_scheduled = 'y';
                } else {
                    $url->is_scheduled = 'n';
                }
                if($url->save()){
                    /* Manage pixel */
                    if(isset($request->managePixel) && ($request->managePixel)) {
                        if (count($request->pixels)>0 && !empty($request->pixels)) {
                            for ($i=0; $i<count($request->pixels); $i++) {
                                $pixel_url = new PixelUrl();
                                $pixel_url->url_id = $url->id;
                                $pixel_url->pixel_id = $request->pixels[$i];
                                $pixel_url->save();
                            }
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
                    }else if($request->type==0|| $request->type==2 || $request->type==3){
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
                        if($request->type==2){
                            $url->link_type = 2;
                            $url->title=$urltitle;
                        } else if ($request->type==3) {
                          $url->link_type = 3;
                          $url->title=$fileName;
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
        * Function for download files
        * @param $path
        */
        public function downloadFile($file='')
        {
          try {
            $exists = \Storage::disk('local')->exists('upload/'.$file);
            if ($exists) {
              $path = storage_path('app/upload/'.$file);
              return response()->download($path);
            } else {
              return response()->json([
                'status' => false,
                'message' => 'File not exists'
              ], 400);
            }
          } catch (\Exception $e) {
            return response()->json([
              'status' => false,
              'message' => $e->getMessage()
            ], 500);
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

                        /* Prevent other user to access of a user data */
                        if ($url->user_id != $user->id) {
                          return view('errors.403');
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

                        /* Getting the pixels that current user had created */
                        $pixels = UserPixels:: where('user_id', $user->id)->get();
                        /* Getting all the available pixel provider which is active*/
                        $pixelProviders = PixelProviders::where('is_active','1')->get();
                        /* Getting the pixels related to this url */
                        $pixel_url = PixelUrl::where('url_id',$id)->get();
                        $timezones = Timezone::all();
                        $selectedTags = UrlTagMap::where('url_id',$id)->with('urlTag')->get();
                        /* Getting the default settings */
                        $defaultSettings = DefaultSettings::all();
                        /* Getting the profile settings if exist */
                        $profileSettings = Profile::where('user_id',Auth::user()->id)->first();
                        $red_time = $defaultSettings[0]->default_redirection_time;
                        $pageColour = $defaultSettings[0]->page_color;
                        $redirecting_text = $defaultSettings[0]->default_redirecting_text;
                        $default_image = $defaultSettings[0]->default_image;
                        $current_image = $defaultSettings[0]->default_image;
                        /* Check if the url is customized atleast once if profile settings is not exists */
                        if ($url->redirecting_time != $defaultSettings[0]->default_redirection_time) {
                            $red_time = $url->redirecting_time;
                        }
                        if ($url->customColour != $defaultSettings[0]->page_color) {
                            $pageColour = $url->customColour;
                        }
                        if ($url->redirecting_text_template != $defaultSettings[0]->default_redirecting_text) {
                            $redirecting_text = $url->redirecting_text_template;
                        }
                        if ($url->usedCustomised == 1) {
                            $red_time = $url->redirecting_time;
                            $pageColour = $url->customColour;
                            $redirecting_text = $url->redirecting_text_template;
                        } else if (($url->usedCustomised == 0) && (count($profileSettings)>0)){
                            /* Checking if the url is customized atleast once if profile settings exists */
                            if (($url->redirecting_time != $profileSettings->default_redirection_time) && ($url->redirecting_time != $defaultSettings[0]->default_redirection_time)) {
                                $red_time = $url->redirecting_time;
                            } else {
                                $red_time = $profileSettings->default_redirection_time;
                            }
                            if (($url->customColour != $profileSettings->pageColor) && ($url->customColour != $defaultSettings[0]->page_color)) {
                                $pageColour = $url->customColour;
                            } else {
                                $pageColour = $profileSettings->pageColor;
                            }
                            if (($url->redirecting_text_template != $profileSettings->default_redirecting_text) && ($url->redirecting_text_template != $defaultSettings[0]->default_redirecting_text)) {
                                $redirecting_text = $url->redirecting_text_template;
                            } else {
                                $redirecting_text = $profileSettings->default_redirecting_text;
                            }
                        }
                        if ((isset($profileSettings)) && ($profileSettings->pageColor != '')) {
                            $default_colour = $profileSettings->pageColor;
                        } else {
                            $default_colour = $defaultSettings[0]->page_color;
                        }
                        /* getting the current and default redirecting image */
                        if ((isset($profileSettings)) && ($profileSettings->pageColor != '')) {
                            if ($profileSettings->default_image != $defaultSettings[0]->default_image) {
                               $current_image = $profileSettings->default_image;
                               $default_image = $profileSettings->default_image;
                            }
                        } else {
                            $current_image = $defaultSettings[0]->default_image;
                            $default_image = $defaultSettings[0]->default_image;
                        }
                        if ($url->uploaded_path != '') {
                            $current_image = $url->uploaded_path;
                        }
                        return view('dashboard.edit_url', [
                            'urlTags'              => $urlTags,
                            'total_links'          => $total_links,
                            'limit'                => $limit,
                            'subscription_status'  => $subscription_status,
                            'user'                 => $user,
                            'type'                 => $urls->link_type,
                            'selectedTags'         => $selectedTags,
                            'urls'                 => $urls,
                            'pixels'               => $pixels,
                            'pixelProviders'       => $pixelProviders,
                            'pixel_url'            => $pixel_url,
                            'timezones'            => $timezones,
                            'red_time'             => $red_time,
                            'pageColor'            => $pageColour,
                            'redirecting_text'     => $redirecting_text,
                            'default_colour'       => $default_colour,
                            'current_image'        => $current_image,
                            'default_image'        => $default_image
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
          dd($request->all());
            if (Auth::check()) {
                try {
                    //Redirect Link
                    if ($request->type==3) {
                      $url = Url::find($id);
                      $userId = \Auth::user()->id;
                      if ($request->hasFile('inputfile')) {
                        $inputFile = $request->file('inputfile');
                        $fileName = $userId.'LW'.time().'.'.$inputFile->getClientOriginalExtension();
                        \Storage::disk('local')->put('upload/'.$fileName, (string) file_get_contents($inputFile), 'public');
                        \Storage::disk('local')->delete('upload/'.$url->title);
                        $fileUrl = \Storage::disk('local')->url('upload/'.$fileName);
                        $downloadUrl = url('/api/downloadfile/'.$fileName);
                        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)) {
                          $actualUrl = str_replace('https://', null, $downloadUrl);
                          $protocol  = 'https';
                        } else {
                          $actualUrl = str_replace('http://', null, $downloadUrl);
                          $protocol  = 'http';
                        }
                      } else {
                        $actualUrl = $url->actual_url;
                        $protocol  = $url->protocol;
                        $fileName = $url->title;
                      }
                    }else if(isset($request->actual_url[0]) && $request->actual_url[0]!=""){
                        if (strpos($request->actual_url[0], 'https://') === 0) {
                            $actualUrl = str_replace('https://', null, $request->actual_url[0]);
                            $protocol  = 'https';
                        } elseif(strpos($request->actual_url[0], 'http://') === 0) {
                            $actualUrl = str_replace('http://', null, $request->actual_url[0]);
                            $protocol  = 'http';
                        } else {
                            $actualUrl = $request->actual_url[0];
                            $protocol  = 'http';
                        }
                    } else {
                        if ($request->type==0) {
                            if (isset($request->allowSchedule) && $request->allowSchedule != 'on') {
                                return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect Or Link Scheduler Will Be There.');
                            } else {
                                $actualUrl = NULL;
                                $protocol  = 'http';
                            }
                        } else if ($request->type==2) {
                            $protocol  = 'http';
                            $actualUrl = NULL;
                            $urltitle  = $request->group_url_title;
                        } else {
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
                    }elseif($request->type==3){
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
                      $url2 = $this->fillUrlDescriptions($url, $request, $meta_data);
                      $url_image_name_get = $url2;
                      $og_image = NULL;
                      if (count($url2)>0) {
                          $og_image = $url_image_name_get->og_image;
                      } else {
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
                    /* Edit default redirection settings */
                    /* Getting the default settings */
                    $defaultSettings = DefaultSettings::all();
                    /* Getting the profile settings if exist */
                    $profileSettings = Profile::where('user_id',Auth::user()->id)->first();
                    if (isset($request->allowCustomizeUrl) && ($request->allowCustomizeUrl == "on")) {
                        $url->customColour = $request->pageColour;
                        if ($request->redirecting_text_template != NULL) {
                            $url->redirecting_text_template = $request->redirecting_text_template;
                        } else if (isset($profileSettings) && ($profileSettings->default_redirecting_text != '')) {
                            $url->redirecting_text_template = $profileSettings->default_redirecting_text;
                        } else {
                            $url->redirecting_text_template = $defaultSettings[0]->default_redirecting_text;
                        }
                        /* Checking for image */
                        if ($request->hasFile('custom_brand_logo')) {
                            /* checking file type */
                            $allowedExt = array('jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF');
                            $imageExt = $request->custom_brand_logo->getClientOriginalExtension();
                            if (!in_array($imageExt, $allowedExt)) {
                                return redirect()->back()->with('imgErr', 'error');
                            }
                            if (!file_exists('public/uploads/brand_images')) {
                                mkdir('public/uploads/brand_images', 0777 , true);
                            }
                            try {
                                $upload_path ='public/uploads/brand_images';
                                $image_name = uniqid()."-".$request->custom_brand_logo->getClientOriginalName();
                                $data = getimagesize($request->custom_brand_logo);
                                $width = $data[0];
                                $height = $data[1];

                                /* image resizing */
                                $temp_height = 450;
                                $abs_width = ceil(($width*$temp_height)/$height);
                                $abs_height = $temp_height;
                                $image_resize = Image::make($request->custom_brand_logo->getRealPath());
                                $image_resize->resize($abs_width, $abs_height);
                                $image_resize->save($upload_path.'/'.$image_name);
                                $url->uploaded_path = $upload_path.'/'.$image_name;
                            } catch (\Exception $e) {
                                return redirect()->back()->with('imgErr', 'error');
                            }
                        }
                        else if($url->uploaded_path != "") {
                          $url->uploaded_path = $url->uploaded_path;
                        }
                        else if (isset($profileSettings) && ($profileSettings->default_image != '')) {
                            $url->uploaded_path = $profileSettings->default_image;
                        }
                        if ($request->redirecting_time == '') {
                            if ((isset($profileSettings)) && ($profileSettings->default_redirection_time != '')) {
                                $url->redirecting_time = $profileSettings->default_redirection_time;
                            } else {
                                $url->redirecting_time = $defaultSettings[0]->default_redirection_time;
                            }
                        } else {
                            $url->redirecting_time = ($request->redirecting_time*1000);
                        }
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
                            if (!file_exists($uploadPath)) {
                                mkdir($uploadPath,  0777 , true);
                            }
                            $newFileName = uniqid() . "-" . date('U');
                            if (preg_match($validExtensionRegex, $actualFileExtension)) {
                                if(!empty($oldFavicon) && strlen($oldFavicon)>0) {
                                    unlink(substr($oldFavicon, 1));
                                }
                                $uploadSuccess = $imgFile->move($uploadPath, $newFileName.'.'.$actualFileExtension);
                                $url->favicon = '/'.$uploadPath.'/'.$newFileName.'.'.$actualFileExtension;
                            } else {
                                if (!empty($oldFavicon) && strlen($oldFavicon)>0) {
                                    $url->favicon = $oldFavicon;
                                } else {
                                    $url->favicon = NULL;
                                }
                            }
                        } else {
                            if (!empty($oldFavicon) && strlen($oldFavicon)>0) {
                                $url->favicon = $oldFavicon;
                            } else {
                                $url->favicon = NULL;
                            }
                        }
                    } else {
                        $urlInstance = Url::find($id);
                        $oldFavicon = $urlInstance->favicon;
                        if (!empty($oldFavicon) && strlen($oldFavicon)>0) {
                            $urlInstance = Url::find($id);
                            $oldFavicon = $urlInstance->favicon;
                            unlink(substr($oldFavicon, 1));
                            $url->favicon = NULL;
                        } else {
                            $url->favicon = NULL;
                        }
                    }
                    //Edit Link Preview
                    $linkPreview          = isset($request->link_preview_selector) && $request->link_preview_selector == true ? true : false;
                    $linkPreviewCustom    = isset($request->link_preview_custom) && $request->link_preview_custom == true ? true : false;
                    $linkPreviewOriginal  = isset($request->link_preview_original) && $request->link_preview_original == true ? true : false;


                    if ($linkPreview) {
                        $linkprev['usability']=1;
                        if ($linkPreviewOriginal) {
                            $linkprev['main']=0;
                            $linkprev['title']=0;
                            $linkprev['image']=0;
                            $linkprev['description']=0;
                        }
                        if ($linkPreviewCustom) {
                            $linkprev['main']=1;
                            if (isset($request->org_img_chk) && $request->org_img_chk=='on') {
                                $linkprev['image']=0;
                            } elseif (isset($request->cust_img_chk) && $request->cust_img_chk =='on') {
                                $linkprev['image']=1;
                                // $url->og_image = $actual_og_image;
                            }

                            if (isset($request->org_title_chk) && $request->org_title_chk=='on') {
                                $linkprev['title']=0;
                                // $url->og_title = $meta_data['og_title'];
                            } elseif (isset($request->cust_title_chk) && $request->cust_title_chk=='on') {
                                $linkprev['title']=1;
                                // $url->og_title = $request->title_inp;
                            }

                            if (isset($request->org_dsc_chk) && $request->org_dsc_chk=='on') {
                                $linkprev['description']=0;
                                // $url->og_description = $meta_data['og_description'];
                            } elseif (isset($request->cust_dsc_chk) && $request->cust_dsc_chk=='on') {
                                $linkprev['description']=1;
                                // $url->og_description = $request->dsc_inp;
                            }



                            if ($request->hasFile('img_inp')) {
                                $imgFile        = $request->file('img_inp');
                                // $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                                $actualFileExtension = $imgFile->getClientOriginalExtension();
                                // $url->og_image = $og_image;
                                $validExtensionRegex = '/(jpg|jpeg|png)/i';
                                if (!preg_match($validExtensionRegex, $actualFileExtension)) {
                                    return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
                                }
                            }
                        }
                        // $url->meta_description = $meta_data['meta_description'];
                        // $url->og_url = $meta_data['og_url'];
                        // $url->twitter_image = $meta_data['twitter_image'];
                        // $url->twitter_url = $meta_data['twitter_url'];
                        // $url->twitter_description = $meta_data['twitter_description'];
                        // $url->twitter_title = $meta_data['twitter_title'];
                    } else {

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

                    //Check Rotating Link
                    if ($request->type==1) {
                        $noOfLink=count($request->actual_url);
                        $url->no_of_circular_links=$noOfLink;
                        if ($noOfLink>1) {
                            $currentRotatingLinks=CircularLink::where('url_id',$url->id)->pluck('id')->toArray();
                            $updatedRotatingLinks=$request->url_id;
                            $removableLinks=(array_diff($currentRotatingLinks,$updatedRotatingLinks));
                            $deletedLinks=CircularLink::whereIn('id', $removableLinks)->delete();
                            for ($i=0; $i < $noOfLink; $i++) {
                                if ($request->url_id[$i]!=0) {
                                    $circularLink = CircularLink::find($request->url_id[$i]);
                                } else {
                                    $circularLink = new CircularLink();
                                    $circularLink->url_id = $url->id;
                                }

                                if (strpos($request->actual_url[$i], 'https://') === 0) {
                                    $actualCirularUrl = str_replace('https://', null, $request->actual_url[$i]);
                                    $cirularProtocol  = 'https';
                                } elseif (strpos($request->actual_url[$i], 'http://') === 0) {
                                    $actualCirularUrl = str_replace('http://', null, $request->actual_url[$i]);
                                    $cirularProtocol  = 'http';
                                } else {
                                    $actualCirularUrl = $request->actual_url[$i];
                                    $cirularProtocol  = 'http';
                                }
                                $circularLink->actual_link = $actualCirularUrl;
                                $circularLink->protocol = $cirularProtocol;
                                $circularLink->save();
                            }
                        }

                    }

                    if($request->type==0 || $request->type==2 || $request->type==3){
                        /* link expiration edit */
                        if (isset($request->allowExpiration) && $request->allowExpiration=='on') {
                            if (isset($request->date_time)) {
                                $url->is_scheduled = 'n';
                                $url->date_time=date_format(date_create($request->date_time), 'Y-m-d H:i:s');
                                $url->timezone=$request->timezone;
                                //$url->redirect_url=$request->redirect_url;
                                if (strlen($request->redirect_url)>0 && preg_match("~^(?:f|ht)tps?://~i", $request->redirect_url)) {
                                    $url->redirect_url = $request->redirect_url;
                                } else {
                                    $url->redirect_url = NULL;
                                }
                            } else {
                                $url->date_time=NULL;
                                $url->timezone=NULL;
                                $url->redirect_url=NULL;

                            }
                        } else {
                            $url->date_time=NULL;
                            $url->timezone=NULL;
                            $url->redirect_url=NULL;
                        }
                        /*Geo Location Edit*/
                        if (isset($request->editGeoLocation) && $request->editGeoLocation=='on') {
                            $deleteGeolocation=Geolocation::where('url_id',$url->id)->delete();
                            if (isset($request->allow_all) && $request->allow_all=='on') {
                                $url->geolocation=0;
                            }
                            if (isset($request->deny_all) && $request->deny_all=='on') {
                                $url->geolocation=1;
                            }
                            $addGeoloc=$this->addGeoLocation($request,$url->id);
                        } else {
                            $deleteGeolocation=Geolocation::where('url_id',$url->id)->delete();
                            $url->geolocation=NULL;
                        }
                        /*link schedule edit*/

                        if (isset($request->allowSchedule) && $request->allowSchedule=='on') {
                            $url->is_scheduled = 'y';
                            /* special schedule pre existing check */

                            // special schedule already exist
                            if ($url->urlSpecialSchedules->count() > 0) {
                                $request->special_date = array_values(array_unique($request->special_date));
                                $request->special_date_redirect_url = array_values($request->special_date_redirect_url);
                                $this->specialScheduleInsertion($request->special_date, $request->special_date_redirect_url, $id);
                            } else {
                                $this->specialScheduleInsertion($request->special_date, $request->special_date_redirect_url, $id);
                            }

                            /* day-wise schedule pre existing check */

                            // day-wise schedule already exist
                            if ($url->url_link_schedules->count() > 0) {
                                $link_schedule_array[0] = $request->day1;
                                $link_schedule_array[1] = $request->day2;
                                $link_schedule_array[2] = $request->day3;
                                $link_schedule_array[3] = $request->day4;
                                $link_schedule_array[4] = $request->day5;
                                $link_schedule_array[5] = $request->day6;
                                $link_schedule_array[6] = $request->day7;
                                $this->url_link_schedules($link_schedule_array, $url->id);
                            } else {
                                $link_schedule_array[0] = $request->day1;
                                $link_schedule_array[1] = $request->day2;
                                $link_schedule_array[2] = $request->day3;
                                $link_schedule_array[3] = $request->day4;
                                $link_schedule_array[4] = $request->day5;
                                $link_schedule_array[5] = $request->day6;
                                $link_schedule_array[6] = $request->day7;
                                $this->url_link_schedules($link_schedule_array, $url->id);
                            }
                        } else {
                            $url->is_scheduled = 'n';
                            if ($url->urlSpecialSchedules->count() > 0) {
                                $splUrl = UrlSpecialSchedule::where('url_id', $id);
                                $splUrl->delete();
                            }

                            if ($url->url_link_schedules->count() > 0) {
                                $dayUrl = UrlLinkSchedule::where('url_id', $id);
                                $dayUrl->delete();
                            }
                        }
                    }
                    //Edit pixels
                    if (isset($request->managePixel) && $request->managePixel=='on') {
                        if (!empty($request->pixels)) {
                            /* Deleting the pixel from url */
                            $pixelUrls = PixelUrl::where('url_id',$id)->get();
                            foreach ($pixelUrls as $pixelUrl) {
                                if (!in_array($pixelUrl->pixel_id, $request->pixels)) {
                                    $pixelUrl->delete();
                                }
                            }
                            /* Adding new pixel to the url */
                            $pixelUrls = PixelUrl::where('url_id',$id)->pluck('pixel_id')->toArray();
                            foreach ($request->pixels as $pixel) {
                                if (!in_array($pixel,$pixelUrls)) {
                                    $pixel_url = new PixelUrl();
                                    $pixel_url->url_id = $url->id;
                                    $pixel_url->pixel_id = $pixel;
                                    $pixel_url->save();
                                }
                            }
                        } else {
                            $pixelUrl = PixelUrl::where('url_id', $id)->delete();
                        }
                    } else {
                        $pixelUrl = PixelUrl::where('url_id', $id)->delete();
                    }

                    //Edit Tags
                    $tag=$this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);
                    if($request->type==2){
                        $url->title = $request->group_url_title;
                    } elseif ($request->type==3) {
                      $url->title = $fileName;
                    }
                    if ($url->save()) {
                        return redirect()->route('getDashboard')->with('success', 'Url Updated!');
                    } else {
                        return redirect()->back()->with('error', 'Try Again');
                    }
                } catch (Exception $e) {
                    return redirect()->back()->with('error', 'Try Again');
                }
            } else {
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

                $url = Url::where('parent_id',$id)->delete();

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
            $twtImage = $url->twitter_image;
            $ogImage  = $url->og_image;

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
                        $url->og_image            =   $meta_data['og_image'];
                        $url->twitter_image       =   $meta_data['twitter_image'];
                        if(isset($ogImage) && ($ogImage!=NULL) && $request->cust_img_chk){
                            $url->og_image =   $ogImage;
                        }
                        if (isset($twtImage) && ($twtImage!=NULL && $request->cust_img_chk)) {
                          $url->twitter_image =  $twtImage;
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

                $redirectUrl = Url::where('shorten_suffix', $subdirectory."/".$url)->first();
                if($redirectUrl){
                    echo self::getRequestedUrl($subdirectory."/".$url);
                }else{
                    abort(404);
                }
            }
        }

        /**
         * Redirect To Main Url
         * @param $url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getRequestedUrl($url) {
            try {
                $defaultSettings = DefaultSettings::all();
                $red_time = $defaultSettings[0]->default_redirection_time;
                $pageColour = $defaultSettings[0]->page_color;
                $redirectionText = $defaultSettings[0]->default_redirecting_text;
                $favicon = $defaultSettings[0]->default_fav_icon;
                $imageUrl = $defaultSettings[0]->default_image;
                $sublink=0;
                $search = Url::where('shorten_suffix', $url)->first();
                if (count($search )>0) {
                    if(($search->link_type==2) && ($search->parent_id==0)){
                        abort(404);
                    }

                    if(($search->link_type==2) && ($search->parent_id!=0)){
                        $sublink =$search->id;
                        $search = Url::where('id', $search->parent_id)->first();
                    }
                    if (!empty($search->favicon) && strlen($search->favicon)>0) {
                        $favicon = $search->favicon;
                    }
                    $userRedirection = Profile::where('user_id',$search->user_id)->first();
                    if (count($userRedirection )>0) {
                        if ((isset($userRedirection) ) &&($userRedirection->redirection_page_type==1) ) {
                            if ($search->usedCustomised==1) {
                                $red_time =  $search->redirecting_time;
                                $pageColour = $search->customColour;
                                $redirectionText = $search->redirecting_text_template;
                                if (isset($search->uploaded_path) && ($search->uploaded_path!="")) {
                                    $imageUrl = $search->uploaded_path;
                                }
                            } else {
                                $red_time = 0000;
                                $pageColour = '#ffffff';
                                $redirectionText = '';
                                $imageUrl = '';
                            }
                        } else if (isset($userRedirection->redirection_page_type) &&($userRedirection->redirection_page_type==0) ) {
                            if ($search->usedCustomised==1) {
                                $red_time =  $search->redirecting_time;
                                $pageColour = $search->customColour;
                                if($search->redirecting_text_template == $defaultSettings[0]->default_redirection_time ){
                                    if($userRedirection->default_redirecting_text != $defaultSettings[0]->default_redirection_time){
                                        $redirectionText = $userRedirection->default_redirecting_text;
                                    }else{
                                        $redirectionText = $defaultSettings[0]->default_redirection_time;
                                    }
                                }else{
                                    $redirectionText = $search->redirecting_text_template;
                                }

                                if ($search->uploaded_path == "") {
                                    if ((isset($userRedirection->default_image))&&( $userRedirection->default_image!="")) {
                                        $imageUrl = $userRedirection->default_image;
                                    }
                                }
                                if (isset($search->uploaded_path) && ($search->uploaded_path!="")) {
                                    $imageUrl = $search->uploaded_path;
                                }
                            } else if ($search->usedCustomised==0) {
                                if ((isset($userRedirection->default_image))&&( $userRedirection->default_image!="")) {
                                    $imageUrl   = $userRedirection->default_image;
                                    $red_time   = $userRedirection->default_redirection_time;
                                    $pageColour = $userRedirection->pageColor;
                                    $redirectionText = $userRedirection->default_redirecting_text;
                                }
                            }
                        }
                    } else {
                        if ($search->usedCustomised==1) {
                            $red_time =  $search->redirecting_time;
                            $pageColour = $search->customColour;
                            $redirectionText = $search->redirecting_text_template;
                            if (isset($search->uploaded_path) && ($search->uploaded_path!="")) {
                                $imageUrl = $search->uploaded_path;
                            }
                        } else if ($search->usedCustomised==0) {
                            if (isset($userRedirection)) {
                                $red_time =  $userRedirection->default_redirection_time;
                                $pageColour = $userRedirection->pageColor;
                                $redirectionText = $userRedirection->default_redirecting_text;
                            }
                        }
                    }
                    /* Getting the associative pixel to that url */
                    $assignedPixels = [];
                    $urlPixel = PixelUrl::where('url_id',$search->id)->pluck('pixel_id')->toArray();
                    if (count($urlPixel) > 0) {
                        foreach ($urlPixel as $key => $pixel) {
                            $getPixelDetails = UserPixels::where('id',$pixel)->first();
                            if (count($getPixelDetails) > 0) {
                                $assignedPixels[$key] = $getPixelDetails->toArray();
                               if ($getPixelDetails->is_custom == 0) {
                                    $getScripts = PixelProviders::where('id',$getPixelDetails->pixel_provider_id)->first();
                                    if (count($getScripts) > 0) {
                                        $scriptInfo=$getScripts->toArray();
                                        $scriptDetails=$scriptInfo['script'];
                                        $scriptInfo['script']=str_replace(["FB_PIXEL_ID","GL_PIXEL_ID","LI_PIXEL_ID","TWT_PIXEL_ID","YOUR_TAG_ID"],$getPixelDetails['pixel_id'],$scriptDetails);
                                        $assignedPixels[$key]=array_merge($assignedPixels[$key],$scriptInfo);
                                    }
                                }
                            }
                        }
                    }
                    $user_agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
                    $referer = $_SERVER['HTTP_HOST'];
                    $clientIP = \Request::ip() == '127.0.0.1' ? '223.31.41.147' : \Request::ip();
                    $access_key = env('GEO_LOCATION_API_KEY');
                    /* Initialize CURL: */
                    $ch = curl_init(env('GEO_LOCATION_API_URL').$clientIP.'?access_key='.env('GEO_LOCATION_API_KEY'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    /* Store the data */
                    $jsonData = json_decode(curl_exec($ch),true);
                    curl_close($ch);
                    $location = [
                        'ip' => $clientIP,
                        'country_code' => $jsonData['country_code'],
                        'country_name' => $jsonData['country_name'],
                        'region_code' => $jsonData['region_code'],
                        'region_name' => $jsonData['region_name'],
                        'city' => $jsonData['city'],
                        'zip_code' => $jsonData['zip'],
                        'time_zone' => $jsonData['time_zone']['id'],
                        'latitude' => $jsonData['latitude'],
                        'longitude' => $jsonData['longitude'],
                        'metro_code' => ""
                    ];
                    if ($jsonData['city'] == NULL) {
                        $location['city'] = $jsonData['location']['capital'];
                    }
                    if ($search->link_type==2) {
                        $urlData = $sublink;
                    } else {
                        $urlData = $search->id;
                    }
                    $userData['country'] =  $location;
                    $userData['urlData'] = $urlData;
                    $userData['querystring'] = $_SERVER['QUERY_STRING'];
                    $userData['platform'] = $user_agent['platform'];
                    $userData['browser'] = $user_agent['browser'];
                    $userData['referer'] = $referer;
                    $userData['suffix'] = $url;
                    $userData = new Request($userData);
                    $responseData = self::postUserInfo($userData);
                    $responseData = json_decode($responseData->getContent());
                    return view('redirect', [
                        'url' => $search,
                        'suffix' => $url,
                        'redirectionText'=>$redirectionText,
                        'pageColor' => $pageColour,
                        'favicon' =>$favicon,
                        'imageUrl'=>$imageUrl,
                        'red_time' => $red_time,
                        'responseData' => $responseData,
                        'assignedPixels' => $assignedPixels,
                        'redirectionText'=>$redirectionText,
                        'responseData' => $responseData
                        ]
                    );
                } else {
                    abort(404);
                }
            } catch (\Exception $e) {
                abort(503);
            }
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
                $country->urls()->attach($request->urlData);
                global $status;
                $status = 'success';
            } else {
                $cn = new Country();
                $cn->name = $request->country['country_name'];
                $cn->code = $request->country['country_code'];
                if ($cn->save()) {
                    $cn->urls()->attach($request->urlData);
                    global $status;
                    $status = 'success';
                } else {
                    global $status;
                    $status = 'error';
                }
            }

            $platform = Platform::where('name', $request->platform)->first();
            if ($platform) {
                $platform->urls()->attach($request->urlData);
                global $status;
                $status = 'success';
            } else {
                $platform = new Platform();
                $platform->name = $request->platform;
                $platform->save();
                $platform->urls()->attach($request->urlData);

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
                $browser->urls()->attach($request->urlData);
                global $status;
                $status = 'success';
            } else {
                $browser = new Browser();
                $browser->name = $request->browser;
                $browser->save();
                $browser->urls()->attach($request->urlData);

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
                $find = Url::find($request->urlData);
                $find->count = $find->count + 1;
                $find->save();

                $referer->urls()->attach($request->urlData);
                global $status;
                $status = 'success';
            } else {
                $referer = new Referer();
                $referer->name = $request->referer;
                $referer->save();
                $u = Url::where('id' , $request->urlData)->first();
                $u->count++;
                $u->save();
                $referer->urls()->attach($request->urlData);
                if ($referer) {
                    global $status;
                    $status = 'success';
                } else {
                    global $status;
                    $status = 'error';
                }
            }

            $ip = IpLocation::where('url_id', $request->urlData)->first();
            if ($ip) {
                $ip = new IpLocation();
                $ip->url_id = $request->urlData;
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
                $ip->url_id = $request->urlData;
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
            if ($search->link_type==0 || $search->link_type==3) {
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
                                $getRedirect=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();

                                if ($getDenyed >0) {
                                    $redirectUrl="";
                                    $redirectstatus=1;
                                    $message="This URL is not accessable from your country";
                                } else if (count($getRedirect)>0){
                                    $redirectUrl=$getRedirect->url;
                                    $redirectstatus=0;
                                    $message="";
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
                        if ($search->link_type==3 && $redirectstatus != 0) {
                          $message="This file download is not accessable from your country";
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
                        if ($search->link_type==3 && $redirectstatus != 0) {
                          $message="This file download link is expired";
                        }
                    }
                } else {
                    if ($search->geolocation==0) {
                        $getDenyed=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('deny',1)->count();
                        $getRedirect=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();
                        if ($getDenyed >0) {
                            $redirectUrl="";
                            $redirectstatus=1;
                            $message="This URL is not accessable from your country";
                         } else if (count($getRedirect)>0){
                            $redirectUrl=$getRedirect->url;
                            $redirectstatus=0;
                            $message="";
                        } else {
                            $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                            $redirectUrl=$getUrl['url'];
                            $redirectstatus=$getUrl['status'];
                            $message=$getUrl['message'];
                        }
                    } else if ($search->geolocation==1) {
                        $getDenyed=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('allow',1)->first();
                        $getRedirect=Geolocation::where('url_id',$search->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();
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
                        } else if (count($getRedirect)>0){
                            $redirectUrl=$getRedirect->url;
                            $redirectstatus=0;
                            $message="";
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
                    if ($search->link_type==3 && $redirectstatus != 0) {
                      $message="This file download is not accessable from your country";
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
            }else if($search->link_type==2){
                $parentUrl = Url::where('id', $search->parent_id)->with('urlSpecialSchedules','url_link_schedules')->first();
                /*Check Url Expire */
                if (($parentUrl->date_time!="") && ($parentUrl->timezone!="")) {
                    date_default_timezone_set($parentUrl->timezone);
                    $date1= date('Y-m-d H:i:s') ;
                    $date2 = $parentUrl->date_time;
                    if (strtotime($date1) < strtotime($date2)) {
                         /*Url Not Expired*/
                        if ($parentUrl->geolocation=="") {
                            $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                            $redirectUrl=$getUrl['url'];
                            $redirectstatus=$getUrl['status'];
                            $message=$getUrl['message'];
                        } else {
                            if ($parentUrl->geolocation==0) {
                                $getDenyed=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('deny',1)->count();
                                $getRedirect=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();
                                if ($getDenyed >0) {
                                    $redirectUrl="";
                                    $redirectstatus=1;
                                    $message="This URL is not accessable from your country";
                                } else if (count($getRedirect)>0){
                                    $redirectUrl=$getRedirect->url;
                                    $redirectstatus=0;
                                    $message="";
                                } else {
                                    $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                                    $redirectUrl=$getUrl['url'];
                                    $redirectstatus=$getUrl['status'];
                                    $message=$getUrl['message'];
                                }
                            } else if ($search->geolocation==1) {
                                $getDenyed=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('allow',1)->count();
                                $getRedirect=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();
                                if ($getDenyed >0) {
                                    $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                                    $redirectUrl=$getUrl['url'];
                                    $redirectstatus=$getUrl['status'];
                                    $message=$getUrl['message'];
                                } else if (count($getRedirect)>0){
                                    $redirectUrl=$getRedirect->url;
                                    $redirectstatus=0;
                                    $message="";
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
                            $redirectUrl=$parentUrl->redirect_url;
                            $redirectstatus=0;
                            $message="";
                        } else {
                            $redirectUrl=NULL;
                            $redirectstatus=1;
                            $message="The Url Is Expired";
                        }
                    }
                } else {
                    if ($parentUrl->geolocation==0) {
                        $getDenyed=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('deny',1)->count();
                        $getRedirect=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();

                        if ($getDenyed >0) {
                            $redirectUrl="";
                            $redirectstatus=1;
                            $message="This URL is not accessable from your country";
                        } else if (count($getRedirect)>0){
                                    $redirectUrl=$getRedirect->url;
                                    $redirectstatus=0;
                                    $message="";
                        } else {
                            $getUrl=$this->schedulSpecialDay($search, $request->querystring);
                            $redirectUrl=$getUrl['url'];
                            $redirectstatus=$getUrl['status'];
                            $message=$getUrl['message'];
                        }
                    } else if ($parentUrl->geolocation==1) {
                        $getDenyed=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('allow',1)->first();
                        $getRedirect=Geolocation::where('url_id',$parentUrl->id)->where('country_code',$request->country['country_code'])->where('redirection',1)->first();
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
                        } else if (count($getRedirect) > 0) {
                            $redirectUrl=$getRedirect->url;
                            $redirectstatus=0;
                            $message="";
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
            }else{
                abort(404);
            }

            if ($redirectstatus == 0 && $search->link_type==3) {
              $message="Your download should start automatically in a few seconds";
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
            if($url->link_type==2 && $url->parent_id!=0){
                $urlSpecialSchedules = UrlSpecialSchedule::where('url_id', $url->parent_id)->get();
            }else{
                $urlSpecialSchedules = UrlSpecialSchedule::where('url_id', $url->id)->get();
            }
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
            if($url->link_type==2 && $url->parent_id!=0){
                $url_link_schedules = UrlLinkSchedule::where('url_id', $url->parent_id)->get();
            }else{
                $url_link_schedules = UrlLinkSchedule::where('url_id', $url->id)->get();
            }

            if($url->is_scheduled =='y' && count($url_link_schedules)>0 && $url->link_type!=2){
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
            }else if( $url->link_type==2 &&  $url->parent_id!=0 ){
                $getParentGroup=Url::where('id',$url->parent_id)->first();
                if($getParentGroup->is_scheduled =='y' && count($url_link_schedules)>0){
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
                        $geoLocation->deny=$request->denied[$i];
                        $geoLocation->redirection=$request->redirect[$i];
                        $geoLocation->url=$request->redirectUrl[$i];
                        $geoLocation->save();
                    }

                }
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
            try {
                if (Auth::check()) {
                    $userId = Auth::user()->id;
                    if (strlen($request->name) > 0 && !empty($request->name)) {
                        $pixel = UserPixels::where('pixel_name', $request->name)
                                        ->where('user_id', $userId)
                                        ->first();
                        if (($request->type == 'Edit') && (count($pixel)>0)) {
                            $checkName = UserPixels::where('id',$request->id)->first();
                            if ($checkName->pixel_name == $request->name) {
                                echo json_encode(['status'=>'200', 'message'=>'name ok']);
                            } else {
                                echo json_encode(['status'=>'403', 'message'=>'name already exist']);
                            }
                        } else {
                            if (count($pixel)>0) {
                                echo json_encode(['status'=>'403', 'message'=>'name already exist']);
                            } elseif (count($pixel)==0) {
                                echo json_encode(['status'=>'200', 'message'=>'name ok']);
                            }
                        }
                    } else {
                        echo json_encode(['status'=>'404', 'message'=>'no name given']);
                    }
                }
            } catch (Exception $e) {
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
            try {
                if(Auth::check()) {
                    $userId = Auth::user()->id;
                    if(strlen($request->id)>0 && !empty($request->id)) {
                        $pixel = Pixel::where('pixel_id', $request->id)
                                      ->where('user_id', $userId)
                                      ->first();
                        if (($request->type == 'Edit') && (count($pixel)>0)) {
                            echo json_encode(['status'=>'200', 'message'=>'name ok']);
                        } else {
                            if (count($pixel)>0) {
                                echo json_encode(['status'=>'403', 'message'=>'id already exist']);
                            } elseif (count($pixel)==0) {
                                echo json_encode(['status'=>'200', 'message'=>'id ok']);
                            }
                        }
                    } else {
                        echo json_encode(['status'=>'404', 'message'=>'no name given']);
                    }
                }
            } catch (Exception $e) {
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
                    $profile = Profile::where('user_id', Auth::user()->id)->exists();
                    if (!$profile) {
                        $profile = new Profile();
                        $profile->user_id = Auth::user()->id;
                        $profile->save();
                    }
                    /* Getting the global settings */
                    $defaultSettings = DefaultSettings::all();
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
                    if ((isset($profileSettings->default_image) && ($profileSettings->default_image != 'public/images/Tier5.jpg'))) {
                        $default_brand_logo = 1;
                    } else {
                        $default_brand_logo = 0;
                    }
                    if ((isset($profileSettings->default_redirecting_text)) && ($profileSettings->default_redirecting_text != '')) {
                        $redirecting_text = $profileSettings->default_redirecting_text;
                    } else {
                       $redirecting_text = $defaultSettings[0]->default_redirecting_text;
                    }

                    $userPixels = UserPixels::where('user_id',Auth::user()->id)->get();
                    $defaultPixels = PixelProviders::pluck('provider_name','provider_code');
                    return view('profile', compact('arr', 'userPixels', 'checkRedirectPageZero', 'checkRedirectPageOne', 'redirectionTime', 'skinColour','user','subscription_status','userPixels','default_brand_logo','redirecting_text','defaultPixels'));
                }
            }
        }
        /**
         * Save profile settings
         * @param Request $request
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function saveProfile(Request $request)
        {
            try
            {
                if(Auth::check())
                {
                    $userId = Auth::user()->id;
                    /* Get the default settings */
                    $defaultSettings = DefaultSettings::all();
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
                            $profile->default_redirection_time = $defaultSettings[0]->default_redirection_time;
                        }
                        $profile->pageColor = $request->pageColor;
                        if (isset($request->default_redirection_text) && $request->default_redirection_text !='') {
                            $profile->default_redirecting_text = $request->default_redirection_text;
                        } else {
                            $profile->default_redirecting_text = $defaultSettings[0]->default_redirecting_text;
                        }
                        /* Checking for image */
                        if ($request->hasFile('default_image')) {
                            /* checking file type */
                            $allowedExt = array('jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF');
                            $imageExt = $request->default_image->getClientOriginalExtension();
                            if (!in_array($imageExt, $allowedExt)) {
                                return redirect()->back()->with('msg', 'imgErr');
                            }
                            if (!file_exists('public/uploads/brand_images')) {
                                mkdir('public/uploads/brand_images', 0777 , true);
                            }
                            try {
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
                            } catch (\Exception $e) {
                                return redirect()->back()->with('msg', 'imgErr');
                            }
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
            $random_string =$random_string;
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
