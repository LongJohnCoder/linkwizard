<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function test(Request $req)
    {
    	echo $req->url;
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
}
