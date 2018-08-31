<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//old
use App\Pixel;
use App\UrlFeature;
//new
use App\UserPixels;
use App\PixelProviders;
use App\PixelUrl;



class Pixeltransfar extends Controller
{
    public function pixel(Request $request){

        $pixel = Pixel::all();
        
				
        foreach ($pixel as $key => $value) {

					$user_pixel=new UserPixels();
        	//user pixel table data
        	$user_pixel->id=$value->id;
        	$user_pixel->user_id=$value->user_id; 	

        	if($value->network == 'fb_pixel_id'){

						$providers                   = PixelProviders::where('provider_code','=','FB')->select('id')->first();
						$is_custom                   = 0;
						$user_pixel->script_position = 0;

        	}elseif($value->network == 'gl_pixel_id'){

						$providers                   = PixelProviders::where('provider_code','=','GL')->select('id')->first();
						$is_custom                   = 0;
						$user_pixel->script_position = 0;

        	}elseif($value->network == 'custom_pixel_id'){

						$providers                   = PixelProviders::where('provider_code','=','CS')->select('id')->first();
						$is_custom                   = 1;
						$user_pixel->script_position = 1;

        	}

					$user_pixel->pixel_provider_id =$providers->id;
					$user_pixel->pixel_id          =$value->pixel_id;
					$user_pixel->pixel_script      =$value->custom_pixel_script;
					$user_pixel->is_custom         =$is_custom;
					$user_pixel->pixel_name        =$value->pixel_name;
					$user_pixel->created_at        =$value->created_at;
					$user_pixel->updated_at        =$value->updated_at;
					$user_pixel->save();
					//dd($user_pixel);
					if($user_pixel){
						//pixel_url
						$pixel_url_detail = UrlFeature::where($value->network ,'=',$value->pixel_id )->select('url_id','created_at','updated_at')->get();
						//dd($pixel_url_detail);
						foreach ($pixel_url_detail as $pkey => $urlid) {
							
							$url_id     =$urlid->url_id;
							$updated_at =$urlid->updated_at;
							$created_at =$urlid->created_at;

							$pixel_url=new PixelUrl();
							$pixel_url->url_id=$url_id;
							$pixel_url->pixel_id=$user_pixel->id;
							$pixel_url->created_at=$created_at;
							$pixel_url->updated_at=$updated_at;
							$pixel_url->save();
							//dd($pixel_url);

						}

					}
        	   
        }
    }
}
