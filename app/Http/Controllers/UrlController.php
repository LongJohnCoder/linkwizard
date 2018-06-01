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
    use App\UrlSpecialSchedule;
    use App\User;
    use App\CircularLink;
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
    use Mockery\Exception;
    use Intervention\Image\ImageManagerStatic as Image;

    class UrlController extends Controller{
        /**
         * Function To Get Short URL Page
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function createLink($linktype){
            if((isset($linktype) && ($linktype=='wizard'))||(isset($linktype) && ($linktype=='rotating'))){
                if (Auth::check()) {
                    if(\Session::has('plan')){
                        return redirect()->action('HomeController@getSubscribe');
                    } else {
                        if($linktype=='wizard'){
                            $type=0;
                        }else{
                            $type=1;
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
                    return redirect()->back()->with('error', 'There Should Be Atleast One Url To Redirect');
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
            
                if($linkPreview){
                    if($linkPreviewCustom){
                        if($request->hasFile('img_inp')) {
                            $imgFile        = $request->file('img_inp');
                            $actualFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $imgFile->getClientOriginalName());
                            $actualFileExtension = $imgFile->getClientOriginalExtension();
                            $validExtensionRegex = '/(jpg|jpeg|png)/i';
                            if (!preg_match($validExtensionRegex, $actualFileExtension)) {
                                return redirect()->back()->with('error','Image should be in jpg, jpeg or png format');
                            }
                        }
                    }
                }
            
                //Facebook pixel id
                $checkboxAddFbPixelid = isset($request->checkboxAddFbPixelid) && $request->checkboxAddFbPixelid == true ? true : false;
                $fbPixelid            = isset($request->fbPixelid) && strlen($request->fbPixelid) > 0 ? $request->fbPixelid : null;

                //Google pixel id
                $checkboxAddGlPixelid = isset($request->checkboxAddGlPixelid) && $request->checkboxAddGlPixelid == true ? true : false;
                $glPixelid            = isset($request->glPixelid) && strlen($request->glPixelid) > 0 ? $request->glPixelid : null;
                
                //Tag
                $allowTags            = isset($request->allowTag) && $request->allowTag == true ? true : false;
                $searchTags           = isset($request->tags) && count($request->tags) > 0 ? $request->tags : null;
                
                //Descriptions
                $allowDescription     = isset($request->allowDescription) && $request->allowDescription == true ? true : false;
                $searchDescription    = isset($request->searchDescription) && strlen($request->searchDescription) > 0 ? $request->searchDescription : null;

                //CountDown Time Before Redirecting
                $allowCountDown       = isset($request->allowCountDown) && $request->allowCountDown == true ? true : false;
                $getCountValue        = isset($request->redirecting_time) && strlen($request->redirecting_time) > 0 ? $request->redirecting_time : null;

                //Get Meta Data
                $meta_data = $this->getPageMetaContents($request->actual_url);
                //Create Short Url Suffix
                $random_string = $this->randomString();

                $url                  = new Url();
                $url->title           = 
                $url->actual_url      = $actualUrl;
                $url->protocol        = $protocol;
                $url->user_id         = $userId;
                
                if(isset($request->custom_url_status)&& ($request->custom_url_status=='on')){
                    $url->is_custom         =1;
                    $url->shorten_suffix    = $request->custom_url;
                }else{
                    $url->shorten_suffix    = $random_string;
                }

                if($allowCountDown){
                    $url->redirecting_time = ($request->redirecting_time)*1000;
                }else{
                    $url->redirecting_time = 5000;
                }

                $url = $this->fillUrlDescriptions($url , $request, $meta_data);

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

                    //Add Tag
                    $tag=$this->setSearchFields($allowTags,$searchTags,$allowDescription,$searchDescription,$url->id);

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
                            $url->link_type = 1;
                            $url->no_of_circular_links = $noOfCircularLinks;
                            $url->save();
                        }
                    }
                    return redirect()->back()->with('success', 'Short Url Created!');
                }else{
                    return redirect()->back()->with('error', 'Short Url Not Created! Try Again!');
                }
            }catch (Exception $e){
                return $e->getMessage();
            }
        }

        /**
         * Function returns view for edit url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function editUrlView($id=NULL){
            $urls = Url::findOrFail($id);
            if (Auth::check()) {
                if (\Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {
                    $user = Auth::user();
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
         * Function returns view for edit url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function editUrl(Request $request, $id=NULL){
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
            

            if(isset($request->allowExpiration) && $request->allowExpiration=='on')
            {
                if(isset($request->date_time)){

                    $date = date_create($request->date_time);
                    $new_date = $date;
                    $url->date_time=$new_date;
                    $url->timezone=$request->timezone;
                    $url->redirect_url=$request->redirect_url;
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
            if(isset($request->link_preview_selector) && $request->link_preview_selector=='on')
            {
                if(isset($request->link_preview_original) && $request->link_preview_original=='on')
                {
                    $url->is_custom = 0;
                    $url->og_title = $meta_Data['og_title'];
                    $url->og_description = $meta_Data['og_description'];
                    $url->og_url = $meta_Data['og_url'];
                    $url->og_image = $meta_Data['og_image'];
                    $url->twitter_title = $meta_Data['twitter_title'];
                    $url->twitter_description = $meta_Data['twitter_description'];
                    $url->twitter_url = $meta_Data['twitter_url'];
                    $url->twitter_image = $meta_Data['twitter_image'];
                }

                if(isset($request->link_preview_custom) && $request->link_preview_custom=='on'){
                    $url->is_custom = 1;

                    if(isset($request->org_img_chk) && $request->org_img_chk=='on')
                    {
                        $url->og_image = $meta_Data['og_image'];
                    }elseif(isset($request->cust_img_chk) && $request->cust_img_chk =='on'){

                        if($request->hasFile('img_inp'))
                        {
                            $image = $request->file('img_inp');
                            $upload_path ='public/uploads/images';
                            $imagename = uniqid() .'.'. $image->getClientOriginalExtension();
                            $request->img_inp->move($upload_path, $imagename);
                            $url->og_image = '/public/uploads/images/'.$imagename;
                        }
                        else
                        {
                            $url->og_image = NULL;
                        }

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
            $url->title           = $meta_data['title'];
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

        /*Redirect To Main Url*/
        public function getRequestedUrl($url){
            $search = Url::where('shorten_suffix', $url)->first();
            if ($search) {
                $url_features = UrlFeature::where('url_id', $search->id)->first();
                return view('redirect', ['url' => $search, 'url_features' => $url_features,'suffix'=>$url]);
            } else {
                abort(404);
            }
        }

        /**
            * Get an User Agent and country Information on AJAX request.
            *
            * @param Request $request
            *
            * @return \Illuminate\Http\Response
        */
        public function postUserInfo(Request $request){
            $status = 'error';

            $country = Country::where('code', $request->country['country_code'])->first();
            if ($country) {
                $country->urls()->attach($request->url);
                global $status;
                $status = 'success';
            }else {
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

            $search = Url::where('shorten_suffix', $request->suffix)->first();
            $redirectUrl=$search->protocol.'://'.$search->actual_url; 
            if ($search->no_of_circular_links > 1) {
                $circularLinks= CircularLink::where('url_id', $search->id)->get();
                $search->actual_url       = $circularLinks[($search->count) % $search->no_of_circular_links]->actual_link;
                $search->protocol         = $circularLinks[($search->count) % $search->no_of_circular_links]->protocol;
            }
            $search->save();
            $redirectstatus=0;
            $message="";
            return response()->json(['status' => $status,'redirecturl'=>$redirectUrl,'redirectstatus'=>$redirectstatus,'message'=>$message]);
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
    }



