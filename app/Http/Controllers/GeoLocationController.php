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
    use Mail;
    use App\Http\Requests\ForgotPasswordRequest;
    /** Controller To Manage GEOLOCATOR Curd operation**/
    class GeoLocationController extends Controller{

    	//Method To Get All Country Name and Code
    	public function getAllCountry(Request $request){
    		$getAllCountry=Country::select('name', 'code')->get();
    		$location[0][0] = 'Country';
        	$location[0][1] = 'Code';
        	if(count($getAllCountry)>0){
        		foreach ($getAllCountry as $key => $country) {
            		$location[++$key][0] =$country->name;
            		$location[$key][1] = $country->code;
        		}
        	}
			return \Response::json(array(
                'status' => true,
                'status_code' => 200,
                'data' => $location
            ));
    	}
    }

       
