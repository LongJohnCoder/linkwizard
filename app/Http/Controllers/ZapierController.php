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

    /** Controller To Manage Zapier Api**/
    class ZapierController extends Controller{

        /*Method To Create And Save Zapier Api Key
        * @return Json Response
        */
        public function createZapierKey(Request $request){
            if(\Auth::check()) {
                try{
                    $user = \Auth::user();
                    $token = $this->generateRandomString();
                    $user = User::findOrFail($user->id);
                    $user->zapier_key=$token;
                    if($user->save()){
                        return \Response::json(array(
                            'status'      => true,
                            'code'        => 200,
                            'api_key'     => $token,
                            'message'     => "Api Key Generated"
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

        /*
        * Method To Generate Random String For Zapier Key
        *
        * @return string
        */
        function generateRandomString() {
            $length = 61;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $count=User::where('zapier_key',$randomString)->count();
            if($count>0){
                $this->generateRandomString();
            }else{
                return $randomString;
            }
        }

        /**
         * Webhook to verify ZAPIER api key and if it is verified create short link.
         * All response code will be 200 as Jon Wants
         * 
         * @param Request $request
         * @param $apikey
         * @return Illuminate\Http\JSONResponse
         */
        public function authenticateZapierKey($apikey){
            try {
                $getUser=User::where('zapier_key',$apikey)->first();
                if(count($getUser)>0){
                    $response = [
                        "status"    => true,
                        "message"   => "Authenticated User",
                    ];
                    $responseCode=200;
                }else{
                    $response = [
                        "status"    => false,
                        "message"   => "You Are Not Authenticated!",
                    ];
                    $responseCode=200;
                }
            } catch (Exception $e) {
                DB::rollBack();
                $response = [
                    "status"    => false,
                    'message'   => $exp->getMessage(),
                ];
                $responseCode=200;
            }
            return \Response::json($response,$responseCode);
        }
        /**
         * Webhook to verify ZAPIER api key and if it is verified create short link.
         * All response code will be 200 as Jon Wants
         * 
         * @param Request $request
         * @param $apikey
         * @return Illuminate\Http\JSONResponse
         */
        public function createUntrackedLink(Request $request, $apikey){
            try {
                $getUser=User::where('zapier_key',$apikey)->first();
                if(count($getUser)>0){
                    $pattern='/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
                    $url=$request->url;
                    if (preg_match($pattern,$url)) {
                        if (strpos($request->url, 'https://') === 0) {
                            $actualUrl = str_replace('https://', null, $request->url);
                            $protocol  = 'https';
                        }elseif(strpos($request->url, 'http://') === 0){
                            $actualUrl = str_replace('http://', null, $request->url);
                            $protocol  = 'http';
                        }else{
                            $actualUrl = $request->url;
                            $protocol  = 'http';
                        }
                        //Create Short Url Suffix
                        $random_string = $this->randomString();
                        $url                   = new Url();
                        $url->actual_url       = $actualUrl;
                        $url->protocol         = $protocol;
                        $url->user_id          = 0;
                        $url->link_type        = 0;
                        $url->shorten_suffix   = $random_string;
                        if($url->save()){
                            if(isset($url->subdomain)) {
                                if($url->subdomain->type == 'subdomain')
                                    $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                                else if($url->subdomain->type == 'subdirectory')
                                    $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                            } else {
                                $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                            }
                            $response = [
                              "status"   => true,
                              "link"     => $shrt_url,
                              "message"  => "Successfully Created Short Link",
                            ];
                            $responseCode=200;
                        }else{
                            $response = [
                                "status"  => false,
                                "message" => "Cannot Save Url",
                            ];
                            $responseCode=200;
                        }
                    }else{
                        $response = [
                            "status"    => false,
                            'message'   => "Url Is Not Valid!",
                        ];
                        $responseCode=200;
                    }
                }else{
                    $response = [
                        "status"    => false,
                        "message"   => "You Are Not Authenticated!",
                    ];
                    $responseCode=200;
                }
            } catch (Exception $e) {
                DB::rollBack();
                $response = [
                    "status"    => false,
                    'message'   => $exp->getMessage(),
                ];
                $responseCode=200;
            } finally {
                DB::commit();
            }

            return \Response::json($response,$responseCode);
        }

        /**
        * URL suffix random string generator.
        *
        * @return string
        */
        private function randomString(){
            $character_set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_string = null;
            for ($i = 0; $i < 8; ++$i) {
                $random_string = $random_string.$character_set[rand(0, strlen($character_set)-1)];
            }
            if (Url::where('shorten_suffix', $random_string)->first()) {
                $this->RandomString();
            } else {
                return $random_string;
            }
        }

        /**
         * Webhook to verify ZAPIER api key and if it is verified create short link.
         * All response code will be 200 as Jon Wants
         * 
         * @param Request $request
         * @param $apikey
         * @return Illuminate\Http\JSONResponse
        */

        public function createGroupLinkFromZapier(Request $request, $apikey){
            $getUser=User::where('zapier_key',$apikey)->first();
            if(count($getUser)>0){
                
            }else{
                $response = [
                    "status"    => false,
                    "message"   => "You Are Not Authenticated!",
                ];
                $responseCode=200;
            }
            return \Response::json($response,$responseCode);
        }

        public function getGrouplink($apikey){
            $getUser=User::where('zapier_key',$apikey)->first();
            if(count($getUser)>0){
                $getAllGroupUrl=Url::where('link_type',2)->where('parent_id',0)->where('user_id',$getUser->id)->get();
                if(count($getAllGroupUrl)>0){
                    if(isset($url->subdomain)) {
                        if($url->subdomain->type == 'subdomain')
                            $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST');
                        else if($url->subdomain->type == 'subdirectory')
                            $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name;
                    } else {
                        $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST');
                    }
                                    
                    foreach ($getAllGroupUrl as $key=>$eachGroupUrl) {
                        $groupUrlList[$key]['id']            =$eachGroupUrl->id;
                        $groupUrlList[$key]['group_url']     =$shrt_url."/".$eachGroupUrl->shorten_suffix;
                        $groupUrlList[$key]['title']         =$eachGroupUrl->title;      
                    }
                     $response = [
                        "status"    => true,
                        "grouplinks" => $groupUrlList,
                        "message"   => "Group Link List",
                    ];
                    $responseCode=200;
                }else{
                    $response = [
                        "status"    => false,
                        "message"   => "No Group Link Available",
                    ];
                    $responseCode=200;
                }   
            }else{
                $response = [
                    "status"    => false,
                    "message"   => "You Are Not Authenticated!",
                ];
                $responseCode=200;
            }
            return \Response::json($response,$responseCode);
        }
    

        public function groupMultipleLink(Request $request, $apikey){
            $getUser=User::where('zapier_key',$apikey)->first();
            if(count($getUser)>0){
                $checkParentGroup=Url::where('id',$request->parent_group)->where('user_id',$getUser->id)->where('link_type',2)->first();
                if(count($checkParentGroup)>0){
                  
                    if((!isset($request->selectedurl)) || ($request->selectedurl=="")){
                        $response = [
                            "status"    => false,
                            "message"   => "No Destination Url Is Available",
                        ];
                        $responseCode=200; 
                    }else{
                        $subGroupUrl=$request->selectedurl;
                        try{
                            foreach ($subGroupUrl as $key=>$individualUrl) {
                                $pattern='/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
                                if (preg_match($pattern,$individualUrl)) {
                                    if (strpos($individualUrl, 'https://') === 0) {
                                        $actualUrl = str_replace('https://', null, $individualUrl);
                                        $protocol  = 'https';
                                    }elseif(strpos($individualUrl, 'http://') === 0){
                                        $actualUrl = str_replace('http://', null, $individualUrl);
                                        $protocol  = 'http';
                                    }else{
                                        $actualUrl = $individualUrl;
                                        $protocol  = 'http';
                                    }
                                
                                    $random_string = $this->groupRandomString($checkParentGroup->shorten_suffix);
                                    $url                   = new Url();
                                    $url->actual_url       = $actualUrl;
                                    $url->title            = $checkParentGroup->title;
                                    $url->protocol         = $protocol;
                                    $url->user_id          = $getUser->id;
                                    $url->link_type        = 2;
                                    $url->parent_id        = $checkParentGroup->id;
                                    $url->shorten_suffix   = $random_string;
                                    if($url->save()){
                                        if(isset($url->subdomain)) {
                                            if($url->subdomain->type == 'subdomain')
                                                $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                                            else if($url->subdomain->type == 'subdirectory')
                                                $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                                        } else {
                                            $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                                        }
                                    }
                                    $shortGroupUrl[$key]=$shrt_url;
                                }  
                            }
                            $response = [
                                "status"      => true,
                                "groupurl"    => $shortGroupUrl,
                                "message"     => "Group Url Created!",
                            ];
                            $responseCode=200;
                        }catch(\Exception $e){
                            $response = [
                                "status"    => false,
                                "message"   => "No Group Url Created",
                            ];
                            $responseCode=200; 
                        }
                    }
                }else{
                    $response = [
                        "status"    => false,
                        "message"   => "No Such Group Created!",
                    ];
                    $responseCode=200;
                }
            }else{
                $response = [
                    "status"    => false,
                    "message"   => "You Are Not Authenticated!",
                ];
                $responseCode=200;
            }
            return \Response::json($response,$responseCode);
        }

        private function groupRandomString($parenSuffix){
            $character_set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_string = null;
            for ($i = 0; $i < 8; ++$i) {
                $random_string = $random_string.$character_set[rand(0, strlen($character_set)-1)];
            }
            $groupUrlSuffix=$parenSuffix."/".$random_string;
            if (Url::where('shorten_suffix', $groupUrlSuffix)->first()) {
                $this->RandomString($parenSuffix);
            } else {
                return $groupUrlSuffix;
            }
        }
    }

       
