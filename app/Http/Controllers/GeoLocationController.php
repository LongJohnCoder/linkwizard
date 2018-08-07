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
            try{
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
            } catch (Exception $e) {
                return \Response::json(array(
                    'status' => false,
                    'status_code' => 500,
                    'message'   => $e->getMessage()
                ));
            }
        }

        public function getSelectedCountryDetails(Request $request){
            try{
                $selectedCountry=array();
                //return $request->all();
                if(count($request->selectedContry)>0){
                    for($i=0; $i<count($request->selectedContry); $i++){
                        $getCountry=Country::where('name',$request->selectedContry[$i])->first();
                        if($getCountry){
                            $selectedCountry[$i]['id']=$getCountry->id;
                            $selectedCountry[$i]['name']=$getCountry->name;
                            $selectedCountry[$i]['code']=$getCountry->code;
                        }
                    }
                }

                return \Response::json(array(
                    'status' => true,
                    'status_code' => 200,
                    'data' => $selectedCountry
                ));
            } catch (Exception $e) {
                return \Response::json(array(
                    'status' => false,
                    'status_code' => 500,
                    'message'   => $e->getMessage()
                ));
            }
        }

        public function getCountryDetails(Request $request){
            try{
                $getCountry=Country::where('name',$request->countryName)->first();
                if($getCountry){
                    $selectedCountry['id']=$getCountry->id;
                    $selectedCountry['name']=$getCountry->name;
                    $selectedCountry['code']=$getCountry->code;
                    //return view('dashboard.custom',compact('selectedCountry'));
                    return \Response::json(array(
                        'status' => true,
                        'status_code' => 200,
                        'data' => $selectedCountry
                    ));
                }else{
                    return \Response::json(array(
                        'status' => false,
                        'status_code' => 400,
                        'message' => "No Country Found"
                    ));
                }
            } catch (Exception $e) {
                return \Response::json(array(
                    'status' => false,
                    'status_code' => 500,
                    'message'   => $e->getMessage()
                ));
            }
        }

        public function getnotSelectedcountry(Request $request){
           // return $request->all()data;
            try{
                $getAllCountry=Country::select('name', 'code')->whereNOTIn('name',$request->data)->get();
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
            } catch (Exception $e) {
                return \Response::json(array(
                    'status' => false,
                    'status_code' => 500,
                    'message'   => $e->getMessage()
                ));
            }
        }

        public function getDenyCountryInAllowAll(Request $request){
            try{
                //action redirect
                $selectedCountry=array();
                $getCountry=Country::select('id','name', 'code')->get();
                if($getCountry){
                    foreach ($getCountry as $key => $country) {
                        if($request->data!=""){
                            if (in_array($country->name,$request->data)){
                                $key = array_search($country->name, $request->data);
                                if( $request->action[$key]==1){
                                    $value=0; 
                                }
                                if( $request->redirect[$key]==1){
                                    $value=2; 
                                }
                            }else{
                                $value=1; 
                            }
                        }else{
                            $value=1; 
                        }
                        $selectedCountry[++$key][0]=$country->name;
                        $selectedCountry[$key][1]=$value;
                        $selectedCountry[$key][2]=$country->code;
                    }
                    return \Response::json(array(
                        'status' => true,
                        'status_code' => 200,
                        'data' => $selectedCountry
                    ));
                }else{
                    return \Response::json(array(
                        'status' => false,
                        'status_code' => 400,
                        'message' => "No Country Found"
                    ));
                }
            }catch(Exception $e){
                return \Response::json(array(
                    'status' => false,
                    'status_code' => 500,
                    'message'   => $e->getMessage()
                ));
            }
        }
    }

       
