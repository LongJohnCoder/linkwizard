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
    use Mockery\Exception;

    class UrlController extends Controller{
        /**
         * Function returns view for edit url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function editUrlView($id=NULL){
            $urls = Url::findOrFail($id);
            if (Auth::check()) {
                if (\Session::has('plan')) {
                    return redirect()->action('HomeController@getSubscribe');
                } else {
                    $user = Auth::user();
                    $count = DB::table('urls')->selectRaw('count(user_id) AS `count`')->where('user_id', $user->id)->groupBy('user_id')->get();
                    $total_links = null;
                    if ($count) {
                        $total_links = $count[0]->count;
                        $limit = LinkLimit::where('user_id', $user->id)->first();
                        if ($limit) {
                            $limit->number_of_links = $total_links;
                            $limit->save();
                        }
                    }

                    if ($user->subscribed('main', 'tr5Advanced')) {
                        $subscription_status = 'tr5Advanced';
                        $limit = Limit::where('plan_code', 'tr5Advanced')->first();
                    } elseif ($user->subscribed('main', 'tr5Basic')) {
                        $subscription_status = 'tr5Basic';
                        $limit = Limit::where('plan_code', 'tr5Basic')->first();
                    } else {
                        $subscription_status = false;
                        $limit = Limit::where('plan_code', 'tr5free')->first();
                    }
                    $urlTags = UrlTag::whereHas('urlTagMap.url', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->pluck('tag')->toArray();
                    return view('dashboard.edit_url', [
                        'urlTags' => $urlTags,
                        'total_links' => $total_links,
                        'limit' => $limit,
                        'subscription_status' => $subscription_status,
                        'user' => $user,
                        'type' => 'short',
                        'urls' => $urls
                    ]);
                }
            }
        }

        /**
         * Function returns view for edit url
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */

        public function editUrl(Request $request, $id=NULL){
            $this->validate($request, [
                "actual_url" => 'required|url'
            ]);

            $meta_Data = $this->getPageMetaContents($request->actual_url);
            $explode_url = explode("://", $request->actual_url);
            $protocol = $explode_url[0];
            $page_url = $explode_url[1];

            $url = Url::find($id);

            $url->protocol = $protocol;
            $url->actual_url = $page_url;
            $url->title = $meta_Data['title'];
            if(isset($request->allowDescription) && $request->allowDescription=='on')
            {
                $url->meta_description = $request->searchDescription;
            }
            else
            {
                $url->meta_description = $meta_Data['meta_description'];
            }

            if(isset($request->allowCountDown) && $request->allowCountDown=='on')
            {
                if(!empty($request->redirecting_time) && $request->redirecting_time >= 1 && $request->redirecting_time <= 30)
                {
                    $url->redirecting_time = ($request->redirecting_time)*1000;
                }
                else
                {
                    $url->redirecting_time = 5000;
                }
            }
            else
            {
                $url->redirecting_time = 5000;
            }
            

            if(isset($request->allowExpiration) && $request->allowExpiration=='on')
            {
                if(isset($request->date_time)){

                    $date = date_create($request->date_time);
                    $new_date = $date;
                    $url->date_time=$new_date;
                    $url->timezone=$request->timezone;
                    $url->redirect_url=$request->redirect_url;
                }else{
                    $url->date_time=NULL;
                    $url->timezone=" ";
                    $url->redirect_url=" ";

                }
            }else{
                    $url->date_time=NULL;
                    $url->timezone=" ";
                    $url->redirect_url=" ";

                }
            if(isset($request->link_preview_selector) && $request->link_preview_selector=='on')
            {
                if(isset($request->link_preview_original) && $request->link_preview_original=='on')
                {
                    $url->is_custom = 0;
                    $url->og_title = $meta_Data['og_title'];
                    $url->og_description = $meta_Data['og_description'];
                    $url->og_url = $meta_Data['og_url'];
                    $url->og_image = $meta_Data['og_image'];
                    $url->twitter_title = $meta_Data['twitter_title'];
                    $url->twitter_description = $meta_Data['twitter_description'];
                    $url->twitter_url = $meta_Data['twitter_url'];
                    $url->twitter_image = $meta_Data['twitter_image'];
                }

                if(isset($request->link_preview_custom) && $request->link_preview_custom=='on'){
                    $url->is_custom = 1;

                    if(isset($request->org_img_chk) && $request->org_img_chk=='on')
                    {
                        $url->og_image = $meta_Data['og_image'];
                    }elseif(isset($request->cust_img_chk) && $request->cust_img_chk =='on'){

                        if($request->hasFile('img_inp'))
                        {
                            $image = $request->file('img_inp');
                            $upload_path ='public/uploads/images';
                            $imagename = uniqid() .'.'. $image->getClientOriginalExtension();
                            $request->img_inp->move($upload_path, $imagename);
                            $url->og_image = '/public/uploads/images/'.$imagename;
                        }
                        else
                        {
                            $url->og_image = NULL;
                        }

                    }

                    if(isset($request->org_title_chk) && $request->org_title_chk=='on')
                    {
                        $url->og_title = $meta_Data['og_title'];
                    }
                    elseif(isset($request->cust_title_chk) && $request->cust_title_chk=='on')
                    {
                        $url->og_title = $request->title_inp;
                    }

                    if(isset($request->org_dsc_chk) && $request->org_dsc_chk=='on')
                    {
                        $url->og_description = $meta_Data['og_description'];
                    }
                    elseif(isset($request->cust_dsc_chk) && $request->cust_dsc_chk=='on')
                    {
                        $url->og_description = trim($request->dsc_inp);
                    }
                }
            }else
            {
                $url->og_title = $meta_Data['og_title'];
                $url->og_description = $meta_Data['og_description'];
                $url->og_url = $meta_Data['og_url'];
                $url->og_image = $meta_Data['og_image'];
                $url->twitter_title = $meta_Data['twitter_title'];
                $url->twitter_description = $meta_Data['twitter_description'];
                $url->twitter_url = $meta_Data['twitter_url'];
                $url->twitter_image = $meta_Data['twitter_image'];
            }

            if($url->save())
            {

            if(isset($request->tags) && count($request->tags)>0)
            {
                DB::table('url_tag_maps')->where('url_id', $id)->delete();

                for($i=0; $i<count($request->tags); $i++)
                {
                    $url_tag_map = new UrlTagMap();

                    $url_tag_id = UrlTag::where('tag', $request->tags[$i])->first();
                    if(count($url_tag_id)>0)
                    {
                        $url_tag_map->url_tag_id = $url_tag_id->id;
                        $url_tag_map->url_id = $id;
                        $url_tag_map->save();
                    }else
                    {
                        $url_tag = new UrlTag();
                        $url_tag->tag = $request->tags[$i];
                        $url_tag->save();

                        $url_tag_map->url_tag_id = $url_tag->id;
                        $url_tag_map->url_id = $id;
                        $url_tag_map->save();
                    }
                }
            }

            if(isset($request->checkboxAddFbPixelid) && $request->checkboxAddFbPixelid == 'on')
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'fb_pixel_id' => $request->fbPixelid,
                    ));
                }
                else
                {
                    $url_feature = new UrlFeature();
                    $url_feature->fb_pixel_id = $request->fbPixelid;
                    $url_feature->url_id = $id;
                    $url_feature->save();
                }
            }else
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                //dd($url->id);
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'fb_pixel_id' => NULL,
                    ));
                }
            }

            if(isset($request->checkboxAddGlPixelid) && $request->checkboxAddGlPixelid == 'on')
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'gl_pixel_id' => $request->glPixelid,

                    ));
                }else
                {
                    $url_feature = new UrlFeature();
                    $url_feature->gl_pixel_id = $request->glPixelid;
                    $url_feature->url_id = $id;
                    $url_feature->save();
                }
            }else
            {
                $url_feature_count = UrlFeature::where('url_id', $id)->first();
                if(count($url_feature_count)>0)
                {
                    DB::table('url_features')->where('url_id',$id)->update(array(
                        'gl_pixel_id' => NULL,

                    ));
                }
            }


                return redirect()->route('getDashboard')->with('edit_msg', '0');
            }
            return redirect()->route('getDashboard')->with('edit_msg', '1');
        }

        public function getPageMetaContents($url){
            $meta = array();
            $meta['title'] = $meta['meta_description'] = null;
            $meta['og_title'] = $meta['og_description'] = $meta['og_url'] = $meta['og_image'] = null;
            $meta['twitter_title'] = $meta['twitter_description'] = $meta['twitter_url'] = $meta['twitter_image'] = null;
            try {
                $html = file_get_contents($url);
                if (strlen($html) > 0) {
                    if (preg_match("/\<title\>(.*)\<\/title\>/i", (string) $html, $title)) {
                        $meta['title'] = $title[1];
                    }
                    $doc = new \DOMDocument();
                    @$doc->loadHTML($html);
                    $metas = $doc->getElementsByTagName('meta');
                    for ($i = 0; $i < $metas->length; $i++){
                        $m = $metas->item($i);
                        switch ($m->getAttribute('property')) {

                          //meta data attributes for fb
                          case 'og:title':
                                $meta['og_title'] = $m->getAttribute('content');
                            break;
                          case 'og:description':
                                $meta['og_description'] = $m->getAttribute('content');
                            break;
                          case 'og:url':
                                $meta['og_url'] = $url;
                            break;
                          case 'og:image':
                                $meta['og_image'] = $m->getAttribute('content');
                            break;

                          default:
                            # code...
                            break;
                        }

                        switch($m->getAttribute('name')) {
                          //meta data attributes for instagram
                          case 'twitter:title':
                                $meta['twitter_title'] = $m->getAttribute('content');
                            break;
                          case 'twitter:description':
                                $meta['twitter_description'] = $m->getAttribute('content');
                            break;
                          case 'twitter:url':
                                $meta['twitter_url'] = $url;
                            break;
                          case 'twitter:image':
                                $meta['twitter_image'] = $m->getAttribute('content');
                            break;

                          default:
                            # code...
                            break;
                        }

                        switch($m->getAttribute('name')) {
                          //meta data attributes for instagram

                          case 'description':
                                $meta['meta_description'] = $m->getAttribute('content');
                            break;

                          default:
                            # code...
                            break;
                        }
                    }
                }
                return $meta;
            } catch(\Exception $e) {
                return $meta;
            }
        }

        public function deleteUrl($id=NULL)
        {
            try
            {
                $url = Url::find($id);
                $url->delete();
                echo 0;
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }

        }
    }



