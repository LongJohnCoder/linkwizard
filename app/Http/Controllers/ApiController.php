<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Subscription;

class ApiController extends Controller
{
    //
    public function createUserByEmail(Request $request) {
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

    public function deleteUserByEmail(Request $request)
    {
      $token = $request->token;
      $email = $request->email;
      try {
        if ($token != config('api.token')) {
          return \Response::json([
            "http_code" => 400,
            "status"    => "error",
            "message"   => "Authentication token incorrect"
          ],400);
        } else {
          $user = User::where('email', $email)->first();
          if ($user) {
            if ($user->delete()) {
              return \Response::json([
                "http_code" => 200,
                "status"    => "error",
                "message"   => "User delete successfull"
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
              "http_code" => 400,
              "status"    => "error",
              "message"   => "User not found"
            ],400);
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
}
