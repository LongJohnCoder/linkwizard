<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class ApiController extends Controller
{
    //
    public function createUserByEmail(Request $request) {

      //if the request header token matches with the token in configuration file
      if(strcmp($request->header('token'),config('api.token')) == 0) {
        //create user with password !Aworker2#

        $email  = isset($request->email) && strlen($request->email) > 0 ? $request->email : null;
        if($email == null) {
          return \Response::json([
            "http_code" => 404,
            "status"    => "error",
            "message"   => "email address cannot be empty!"
          ],404);
        }

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

        $name   = explode('@',$email);
        $name   = $name[0];

        $user = new User();
        $user->name   = $name;
        $user->email  = $email;
        $user->password = config('api.default_password');
        $user->remember_token = '';

        if($user->save()) {
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

      } else {
        return \Response::json([
          "http_code" => 404,
          "status"    => "error",
          "message"   => "Authentication token incorrect"
        ],404);
      }
    }
}
