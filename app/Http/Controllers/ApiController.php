<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;
use App\Subscription;
use Validator;

class ApiController extends Controller
{
  /*
  * Webhook call for create a user with highest membership
  * Request token, email
  * Response json
  */
  public function createUserByEmail(Request $request)
  {
    $token = $request->token;
    $email = $request->email;
    try {
      $v = \Validator::make($request->all(), [
          'email' => 'required|email|unique:users',
      ]);
      if($v->fails()) {
        return \Response::json([
          "http_code" => 400,
          "status"    => "error",
          "message"   => "email address format is incorrect or is already present!"
        ],400);
      }

      if ($token != config('api.token')) {
        return \Response::json([
          "http_code" => 400,
          "status"    => "error",
          "message"   => "Authentication token incorrect"
        ],400);
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
              "status"    => "success",
              "message"   => "User created successfully with default password!"
            ],200);

        } else {
          return \Response::json([
            "http_code" => 500,
            "status"    => "error",
            "message"   => "Database connectivity error.. Please try after sometime!"
          ],500);
        }
      }
    } catch (Exception $e) {
      return \Response::json([
        "http_code" => 500,
        "status"    => "error",
        "message"   => $e->getMessage()
      ],500);
    }
  }

  /*
  * Webhook call for delete a user
  * Request token, email
  * Response json
  */
  public function deleteUserByEmail(Request $request)
  {
    $token = $request->token;
    $email = $request->email;
    try {
      if ($token != config('api.token')) {
        return \Response::json([
          "http_code" => 403,
          "status"    => "error",
          "message"   => "Authentication token incorrect"
        ],403);
      } else {
        $user = User::where('email', $email)->first();
        if ($user) {
          if ($user->delete()) {
            return \Response::json([
              "http_code" => 200,
              "status"    => "success",
              "message"   => "User delete successfully."
            ],200);
          } else {
            return \Response::json([
              "http_code" => 500,
              "status"    => "error",
              "message"   => "Database error"
            ],500);
          }
        } else {
          return \Response::json([
            "http_code" => 404,
            "status"    => "error",
            "message"   => "User not found"
          ],404);
        }
      }

    } catch (Exception $e) {
      return \Response::json([
        "http_code" => 500,
        "status"    => "error",
        "message"   => $e->getMessage()
      ],500);
    }
  }
    /**
     * Webhook to create new subscriber
     * Request @params Company Name, Email,
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
                  "http_code" => 403,
                  "status"    => false,
                  'message' => "Please enter correct email format or email already present!",
              ];
              $responseCode = 403;
              return response()->json($response, $responseCode);
          }
          if ($token != config('api.token')) {
            $response = [
              "http_code" => 403,
              "status"    => false,
              'message' => "Authentication token incorrect!",
          ];
          $responseCode = 403;
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
                          "http_code" => 201,
                          "status"    => true,
                          'message' => "User created successfully.",
                      ];
                      $responseCode = 201;
              } else {
                  $response = [
                      "http_code" => 201,
                      "status"    => true,
                      'message' => "User created successfully.",
                  ];
                  $responseCode = 201;
              }
          }else {
          DB::rollBack();
          $response = [
              "http_code" => 404,
              "status"    => false,
              'message' => $exp->getMessage(),
          ];
          $responseCode = 404;
        }
      }
      } catch (Exception $exp){
          DB::rollBack();
          $response = [
              "http_code" => 500,
              "status"    => false,
              'message' => $exp->getMessage(),
          ];
          $responseCode = 500;
      } finally {
          DB::commit();
      }
      return response()->json($response, $responseCode);
  }
}
