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
        /**
          * Webhook to create shortlink
          * Request token, url
          * Response json
        */
        public function createShortLink(Request $request){
            try {
                DB::beginTransaction();
                if(isset($request->url) && $request->url!=""){
                    if ($request->url) {
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
                              "http_code" => 200,
                              "status"    => "Success",
                              "link"      => $shrt_url,
                              "message"   => "successfully Created Short Link",
                            ];
                            $responseCode = 200;
                        }else{
                            $response = [
                                "http_code" => 500,
                                "status"    => "error",
                                "message"   => "Cannot Save Url",
                            ];
                            $responseCode = 500;
                        }
                    } else {
                        $response = [
                            "http_code" => 400,
                            "status"    => "error",
                            "message"   => "Url is not valid",
                        ];
                        $responseCode = 400;
                    }
                }else{
                    $response = [
                        "http_code" => 400,
                        "status"    => "error",
                        "message"   => "Need Url",
                    ];
                    $responseCode = 400;
                }
            } catch (Exception $e) {
                DB::rollBack();
                $response = [
                    "http_code" => 500,
                    "status"    => "error",
                    'message' => $exp->getMessage(),
                ];
                $responseCode = 500;
            } finally {
                DB::commit();
            }
            return response()->json($response, $responseCode);
        }
       
    }

       
