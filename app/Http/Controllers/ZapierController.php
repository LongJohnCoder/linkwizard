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

        /*Method To Generate Random String For Zapier Key
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
          * Webhook to create shortlink
          * Request token, url
          * Response json
        */
        public function createUntrackedLink(Request $request){
            try {
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
                    if($url){//$url->save()){
                        if(isset($url->subdomain)) {
                            if($url->subdomain->type == 'subdomain')
                                $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                            else if($url->subdomain->type == 'subdirectory')
                                $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                        } else {
                            $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                        }
                        $response = [
                          "code"     => 200,
                          "status"   => true,
                          "link"     => $shrt_url,
                          "message"  => "Successfully Created Short Link",
                        ];
                    }else{
                        $response = [
                            "code"    => 200,
                            "status"  => false,
                            "message" => "Cannot Save Url",
                        ];
                    }
                }else{
                    $response = [
                        "code" => 200,
                        "status"    => "false",
                        'message' => "Url Is Not Valid!",
                    ];
                }
            } catch (Exception $e) {
                DB::rollBack();
                $response = [
                    "code" => 200,
                    "status"    => "false",
                    'message' => $exp->getMessage(),
                ];
            } finally {
                DB::commit();
            }
            return response()->json($response);
        }
        /**
        * URL suffix random string generator.
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
    }

       