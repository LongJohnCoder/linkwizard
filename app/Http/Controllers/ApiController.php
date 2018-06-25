<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use DB;
    use App\Url;
    use App\Http\Requests;
    use App\User;
    use App\Subscription;
    use Validator;

    class ApiController extends Controller{
        /*
        * Webhook call for create a user with highest membership
        * Request token, email
        * Response json
        */
        public function createUserByEmail(Request $request){
            $token = $request->token;
            $email = $request->email;
            try {
                $v = \Validator::make($request->all(), [
                    'email' => 'required|email|unique:users',
                ]);
                if($v->fails()) {
                    return \Response::json([
                      "http_code" => 200,
                      "status"    => "Success",
                      "message"   => "email address format is incorrect or is already present!"
                    ],200);
                }
                if ($token != config('api.token')) {
                    return \Response::json([
                      "http_code" => 200,
                      "status"    => "Success",
                      "message"   => "Authentication token incorrect"
                    ],200);
                } else {
                    $name   = explode('@',$email);
                    $name   = $name[0];
                    $user                 = new User();
                    $user->name           = $name;
                    $user->email          = $email;
                    $user->password       = bcrypt(config('api.default_password'));
                    $user->remember_token = '';
                    if($user->save()) {
                        $sb = new Subscription();
                        $sb->user_id      = $user->id;
                        $sb->name         = config('api.subscription.name');
                        $sb->stripe_id    = '';
                        $sb->stripe_plan  = 'tr5Advanced';
                        $sb->quantity     = 1;
                        $sb->save();

                        return \Response::json([
                          "http_code" => 200,
                          "status"    => "Success",
                          "message"   => "User created successfully with default password!"
                        ],200);
                    } else {
                      return \Response::json([
                          "http_code" => 200,
                          "status"    => "Success",
                          "message"   => "Database connectivity error.. Please try after sometime!"
                      ],200);
                    }
                }
            } catch (Exception $e) {
                return \Response::json([
                    "http_code" => 200,
                    "status"    => "Success",
                    "message"   => $e->getMessage()
                ],200);
            }
        }

        /*
        * Webhook call for delete a user
        * Request token, email
        * Response json
        */
        public function deleteUserByEmail(Request $request){
            $token = $request->token;
            $email = $request->email;
            try {
                if ($token != config('api.token')) {
                    return \Response::json([
                      "http_code" => 200,
                      "status"    => "Success",
                      "message"   => "Authentication token incorrect"
                    ],200);
                } else {
                    $user = User::where('email', $email)->first();
                    if ($user) {
                        if ($user->delete()) {
                            return \Response::json([
                              "http_code" => 200,
                              "status"    => "Success",
                              "message"   => "User delete successfully."
                            ],200);
                        } else {
                            return \Response::json([
                              "http_code" => 200,
                              "status"    => "Success",
                              "message"   => "Database error"
                            ],200);
                        }
                    } else {
                        return \Response::json([
                            "http_code" => 200,
                            "status"    => "Success",
                            "message"   => "User not found"
                        ],200);
                    }
                }
            } catch (Exception $e) {
                return \Response::json([
                  "http_code" => 200,
                  "status"    => "Success",
                  "message"   => $e->getMessage()
                ],200);
            }
        }

        /**
         * Webhook to create new subscriber
         * Request @params Company Name, Email,
         * Response json
         */
        public function createNewSubscriber(Request $request){
            $cardName = array();
            $token = ($request->token!='')?$request->token:'';
            $email = ($request->email!='')?$request->email:'';
            $userFullName = ($request->userFullName!='')?$request->userFullName:'';
            $password = ($request->password!='')?$request->password:123456;
            $choosePlan = ($request->choosePlan!='')?$request->choosePlan:'';
            try{
                DB::beginTransaction();
                $v = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users',
                ]);
                if($v->fails()) {
                    $response = [
                        "http_code" => 200,
                        "status"    => "Success",
                        'message' => "Please enter correct email format or email already present!",
                    ];
                    $responseCode = 200;
                    return response()->json($response, $responseCode);
                }
                if ($token != config('api.token')) {
                    $response = [
                        "http_code" => 200,
                        "status"    => "Success",
                        'message' => "Authentication token incorrect!",
                    ];
                    $responseCode = 200;
                } else {
                    $user               = new User();
                    $user->name         = $userFullName;
                    $user->email        = $email;
                    $user->is_admin     = 0;
                    $user->password     = bcrypt($password);
                    if ($user->save()) {
                        if($choosePlan!=''){
                            $create_subscription = new Subscription();
                            $create_subscription->user_id = $user->id;
                            $create_subscription->name = config('api.subscription.name');
                            $create_subscription->stripe_id = '';
                            $create_subscription->stripe_plan = $choosePlan;
                            $create_subscription->quantity = 1;
                            $create_subscription->save();
                            $response = [
                                "http_code" => 200,
                                "status"    => "Success",
                                'message' => "User created successfully.",
                            ];
                            $responseCode = 200;
                        } else {
                            $response = [
                                "http_code" => 200,
                                "status"    => "Success",
                                'message' => "User created successfully.",
                            ];
                            $responseCode = 200;
                        }
                    }else {
                        DB::rollBack();
                        $response = [
                            "http_code" => 200,
                            "status"    => "Success",
                            'message' => $exp->getMessage(),
                        ];
                        $responseCode = 200;
                    }
                }
            } catch (Exception $exp){
                DB::rollBack();
                $response = [
                    "http_code" => 200,
                    "status"    => "Success",
                    'message' => $exp->getMessage(),
                ];
                $responseCode = 200;
            } finally {
                DB::commit();
            }
            return response()->json($response, $responseCode);
        }

        /**
          * Webhook to create shortlink
          * Request token, url
          * Response json
        */
        public function createShortLink(Request $request){
            try {
                DB::beginTransaction();
                if(isset($request->url) && $request->url!=""){
                    if (filter_var($request->url, FILTER_VALIDATE_URL)) {
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

        public function suspendSubsciber(Request $request)
        {
        $user = User::where('email', $request->email)->first();
        if ($user) {
          		$user->email = $user->email."_suspend";
          $user->update();
          return response()->json([
            'status' => true,
            'message' => $request->email." is suspended successfully."
          ]);
        } else {
          $check_suspend = User::where('email', $request->email.'_suspend')->first();
          if ($check_suspend){
            return response()->json([
              'status' => false,
              'message' => $request->email." is already suspended."
            ]);
          } else {
            return response()->json([
              'status' => false,
              'message' => $request->email." not found!!! Check Email again."
            ]);
          }
        }
      }

      public function unsuspendSubsciber(Request $request)
      {
        $user = User::where('email', $request->email.'_suspend')->first();
        if ($user) {
          $user->email = $request->email;
          $user->update();
          return response()->json([
            'status' => true,
            'message' => $request->email." is unsuspended successfully."
          ]);
        } else {
          $check_unsuspend = User::where('email', $request->email)->first();
          if ($check_unsuspend){
            return response()->json([
              'status' => false,
              'message' => $request->email." is already unsuspended."
            ]);
          } else {
            return response()->json([
              'status' => false,
              'message' => $request->email." not found!!! Check Email again."
            ]);
          }
        }
      }
    }
