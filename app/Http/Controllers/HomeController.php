<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Event;
use App\Events\MailEvent;

class HomeController extends Controller
{
    public function test()
    {
    	/*$a = 2;
    	$b = 3;
    	//dd(1);
    	$res = Event::fire(new MailEvent($a, $b));
    	dd($res);*/
    	header("Location: http://google.com");
		die();

    }

    public function postShortUrl(Request $req)
    {
    	$longUrl = $req->url;



    	//$longUrl = 'http://stackoverflow.com/questions/23059918/laravel-get-base-url';
	    $apiKey  = 'AIzaSyAbwUzc7OXkeWJAKJh9nzB3QUolmh3uoRc';
	     
	    //3 
	    $postData = array('longUrl' => $longUrl, 'key' => $apiKey);
	    $jsonData = json_encode($postData);
	      
	    //4
	    $curlObj = curl_init(); 
	    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyAbwUzc7OXkeWJAKJh9nzB3QUolmh3uoRc');
	    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curlObj, CURLOPT_HEADER, 0);
	    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	    curl_setopt($curlObj, CURLOPT_POST, 1);
	    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
	     
	    //5
	    $response = curl_exec($curlObj);
	    $json = json_decode($response);
	      
	    //6
	    curl_close($curlObj);
	     
	    //7
	    if(isset($json->error)){
	        //echo $json->error->message;
	        //echo "<pre>";
	        $json->status = "error";
	        echo json_encode($json);
	    }else{
	        //echo $json->id;
	        //echo "<pre>";
	        $json->status = "success";
	        //echo json_encode($json);
	        return response()->json($json);
	    }  
    }

    public function LoginAttempt(Request $req)
    {
    	//dd($req);
    	$email = $req->email;
    	$password = $req->password;
    	$remember_me = isset($request->rememberme)? true : false;


    	if (Auth::attempt(['email' => $email, 'password' => $password], $remember_me)) 
    	{
    		echo "login successfull";
    	}
    	
    }

    public function postRegister(Request $req)
    {
    	//dd($req);
    	if(User::where('email',$req->Email)->first())
    	{
    		return redirect()->route('getIndex')->with('fail', 'Email alread exist try with different email!');
    	}
    	else
    	{
    		$user = new User();

	    	$user->email = $req->Email;
	    	$user->password = bcrypt($req->password);

	    	if($user->save())
	    	{
	    		return redirect()->route('getIndex')->with('success', 'You have successfully registered please login');
	    	}
	    	else
	    	{
	    		return redirect()->route('getIndex')->with('fail', 'Cannot register now please try after sometime');
	    	}
    	}
    	

    }

    public function getDashboard()
    {
    	return view('urlshortner.dashboard');
    }


}
