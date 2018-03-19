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
            "http_code" => 404,
            "status"    => "error",
            "message"   => "email address format is incorrect or is already present!"
          ],404);
        }

        if ($token != config('api.token')) {
          return \Response::json([
            "http_code" => 404,
            "status"    => "error",
            "message"   => "Authentication token incorrect"
          ],404);
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
              "http_code" => 404,
              "status"    => "error",
              "message"   => "Database connectivity error.. Please try after sometime!"
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
}
