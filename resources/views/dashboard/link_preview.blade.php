@php
    $serverTZ = date_default_timezone_get();
    $key = 0;

    function ogUrl($url=NULL)
    {
        if($url!='' or !empty($url))
        {
            $urlExplode = explode('://', $url);
            $urlExceptProtocol = $urlExplode[1];
            $ogUrlExplode = explode('/', $urlExceptProtocol);
            $ogUrl = $ogUrlExplode[0];
            return $ogUrl;
        }else
        {
            return NULL;
        }
    }

    $defaultPaginate = 10;

    if(empty(Request::query('page')))
    {
        $serialNo = 1;
    }
    elseif(!empty(Request::query('page')))
    {
        $serialNo = ($defaultPaginate*(Request::query('page')-1))+1;
    }


   
        $ipLocations = $url->ipLocations()->orderBy('created_at','desc')->paginate($defaultPaginate);
  
@endphp
<!DOCTYPE html>
<!-- head of th page -->
<html lang="en">
	@include('contents/head')

    <style>
        .redirection-link-box a{
            padding-right: 5px;
        }
        .copy-btn{
            display: none;
        }
        .cp-btn{
            display: none;
        }
        #preview{
            background-color: #f7f7f7;
            border: 1px solid #999999;
            box-shadow: 2px 2px 2px #666666;
            padding: 5px;
        }
        .prev-btn{
            padding-left: 15px;
            cursor: pointer;
        }
        .prev-og-box{
            margin-top: 5px;
        }
        .prev-url{
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            color: #888888;
        }
        .prev-title{
            font-family: Helvetica, Arial, sans-serif;
            font-size: 17px;
            color: #1d2129;
            direction: ltr;
            line-height: 1.34;
        }
        .prev-description{
            color: #666666;
        }
        .na-url-tag{
            font-size: 10px!important;
            color: #ff6666!important;
        }
        .tags {
            list-style: none;
            margin: 0;
            overflow: hidden;
            padding: 0;
        }

        .tags li {
            float: left;
        }

        .sm-tag {
            background: #c0c0c0;
            border-radius: 3px 0 0 3px;
            color: #666666;
            display: inline-block;
            height: 26px;
            line-height: 26px;
            padding: 0 20px 0 23px;
            position: relative;
            margin: 0 10px 10px 0;
            text-decoration: none;
            -webkit-transition: color 0.2s;
        }

        .sm-tag::before {
            background: #fff;
            border-radius: 10px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
            content: '';
            height: 6px;
            left: 10px;
            position: absolute;
            width: 6px;
            top: 10px;
        }

        .sm-tag::after {
            background: #fff;
            border-bottom: 13px solid transparent;
            border-left: 10px solid #c0c0c0;
            border-top: 13px solid transparent;
            content: '';
            position: absolute;
            right: 0;
            top: 0;
        }

        .sm-tag:hover {
            background-color: #3275b2;
            color: white;
        }

        .sm-tag:hover::after {
            border-left-color: #3275b2;
        }

        .show-info-tab thead{
            background-color: #4b86b4;
            color: #ffffff;
            height: 40px;
        }
        .show-info-tab{
            box-shadow: 2px 2px 4px #888888;
            padding: 5px;
        }
        .link-info-date{
            font-size: 13px!important;
        }
        .no-info{
            color: #B3B3B3;
        }
        .normal-date{
            display: none;
        }
    </style>
<body>
<!-- head end -->

<link rel="stylesheet" href="{{ URL('/')}}/public/css/selectize.legacy.css" />
<script src="{{ URL::to('/').'/public/js/selectize.js' }}"></script>
<script src="{{ URL::to('/').'/public/js/selectize_index.js' }}"></script>
<link href="{{ URL::to('/').'/public/css/footer.css'}}" rel="stylesheet" />
<!-- Header Start -->
<!-- Link Preview Files -->
<script src="{{URL::to('/').'/public/Link-Preview-master/js/linkPreview.js'}}"></script>
<script src="{{URL::to('/').'/public/Link-Preview-master/js/linkPreviewRetrieve.js'}}"></script>
<link href="{{URL::to('/').'/public/Link-Preview-master/css/linkPreview.css'}}" rel="stylesheet" type="text/css">
<!-- End Of Link Preview Files -->
<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
<!-- End of Moment JS -->
@include('contents/header')
<!-- Header End -->

@include('contents.modal.allModal')

<!-- Messenger chatbot extension -->
@include('chatbot_extension')

<div class="main-dashboard-body">
  <div class="main-content">
    <div class="container">

      <div class="row">
        <div class="col-md-12 col-sm-12">
          <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#link-details">Link Details</a></li>
              <li><a data-toggle="tab" href="#link-status">Link Status</a></li>
          </ul>
          <div class="tab-content tab-holder">
            <div id="link-details" class="tab-pane fade in active">

              @php
                if(isset($url->subdomain)) {
                  if($url->subdomain->type == 'subdomain')
                      $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                  else if($url->subdomain->type == 'subdirectory')
                      $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name.'/'.$url->shorten_suffix;
                } else {
                  $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->shorten_suffix;
                }
              @endphp
                
              <div class="row">
                  <div class="col-md-2 col-sm-2"><strong>Redirection link:</strong></div>
                  <div class="col-md-10 col-sm-10">
                      <span class="redirection-link-box">
                          <a href="{{$shrt_url}}" id="copylink">{{$shrt_url}}</a>
                          <a id="clipboard" class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#copylink" title="Copy shorten URL"><i class="fa fa-copy"></i></a>
                      </span>
                  </div>
              </div>
              <div class="row">
								{{--dd(urlencode($url->title))--}}
                  @php
                      $actual_url = '';
                      $has_spl_url = 'n';
                      if($url->is_scheduled === 'y')
                      {
                          if(!empty($url->actual_url))
                          {
                              if(strpos($url->actual_url,'https://') == 0 || strpos($url->actual_url,'http://') == 0) {
                                  $actual_url = $url->protocol.'://'.$url->actual_url;
                              }
                              else
                              {
                                  $actual_url = $url->actual_url;
                              }
                          }
                          elseif(empty($url->actual_url))
                          {
                              /* check if there is special schedule available */
                              // for true condition
                              if(count($url->urlSpecialSchedules)>0)
                              {
                                  foreach($url->urlSpecialSchedules as $spl_url)
                                  {
                                      if($spl_url->special_day == date('Y-m-d'))
                                      {
                                          $actual_url = $spl_url->special_day_url;
                                          $has_spl_url = 'y';
                                          break;
                                      }
                                      else
                                      {
                                          $has_spl_url = 'n';
                                          $actual_url = '';
                                      }
                                  }
                              }
                              if(count($url->url_link_schedules)>0 && $has_spl_url == 'n')
                              {
                                  // day-wise schedule
                                  $day = date('N');
                                  foreach ($url->url_link_schedules as $schedule)
                                  {
                                      if($schedule->day==$day)
                                      {
                                          $actual_url = $schedule->protocol.'://'.$schedule->url;
                                          break;
                                      }
                                      else
                                      {
                                          $actual_url = '';
                                      }
                                  }
                              }
                              if(count($url->url_link_schedules)==0 && count($url->urlSpecialSchedules)==0)
                              {
                                  $actual_url = '';
                              }
                          }
                      }
                      elseif($url->is_scheduled === 'n')
                      {
                          if(strpos($url->actual_url,'https://') == 0 || strpos($url->actual_url,'http://') == 0)
                          {
                              $actual_url = $url->protocol.'://'.$url->actual_url;
                          }
                          else
                          {
                              $actual_url = $url->actual_url;
                          }
                      }

                  @endphp
                  <div class="col-md-2 col-sm-2"><strong>
                          @if($url->link_type==0)
                              Clicked link:
                          @elseif($url->link_type==1)
                              Rotating Links:
                          @endif
                      </strong></div>
                  <div class="col-md-10 col-sm-10">
                      @if($url->link_type==0)
                          <span class="redirect-urls" data-id="0"><a href="{{$actual_url}}" id="url-0">{{$actual_url}}</a> <a onclick="copyUrl(0)" class="cp-btn" id="cp-btn-0"><i class="fa fa-copy"></i></a></span>
                      @elseif($url->link_type==1)
                          @if($url->no_of_circular_links>1)
                              <ul>
                                <li><span class="redirect-urls" data-id="0"><a href="{{$actual_url}}" id="url-0">{{$actual_url}}</a> <a onclick="copyUrl(0)" class="cp-btn" id="cp-btn-0"><i class="fa fa-copy"></i></a> </span></li>
                                @foreach($url->circularLink as $key=>$rotatingLink)
                                    @if($key!==($url->count % $url->no_of_circular_links))
                                          @if($key>($url->count % $url->no_of_circular_links))
                                              <li><span class="redirect-urls" data-id="{{$key+1}}"><a href="{{$rotatingLink->protocol}}://{{$rotatingLink->actual_link}}" id="url-{{$key+1}}" style="color: #616161;">{{$rotatingLink->protocol}}://{{$rotatingLink->actual_link}}</a>  <a onclick="copyUrl({{$key+1}})" class="cp-btn" id="cp-btn-{{$key+1}}"><i class="fa fa-copy"></i></a></span></li>
                                          @endif
                                    @endif
                                @endforeach
                                @foreach($url->circularLink as $key=>$rotatingLink)
                                    @if($key!==($url->count % $url->no_of_circular_links))
                                        @if($key<($url->count % $url->no_of_circular_links))
                                              <li><span class="redirect-urls" data-id="{{$key+1}}"><a href="{{$rotatingLink->protocol}}://{{$rotatingLink->actual_link}}" id="url-{{$key+1}}" style="color: #616161;">{{$rotatingLink->protocol}}://{{$rotatingLink->actual_link}}</a>  <a onclick="copyUrl({{$key+1}})" class="cp-btn" id="cp-btn-{{$key+1}}"><i class="fa fa-copy"></i></a></span></li>
                                        @endif
                                    @endif
                                @endforeach
                              </ul>
                          @endif
                      @endif
                  </div>
                  <div class="col-md-2">
                      <strong>Tags of the link:</strong>
                  </div>
                  <div class="col-md-10">
                      {{--<p>Tags associated with this link</p>--}}
                      @php
                          if(is_array($tags))
                          {
                              echo '<ul class="tags">';
                              foreach ($tags as $tag)
                              {
                                  echo '<li><a href="#" class="sm-tag">'.$tag.'</a></li>';
                              }
                              echo '</ul>';
                          }else
                          {
                              echo "<p class='na-url-tag'>".$tags."<p>";
                          }

                      @endphp
                  </div>
                  <div class="col-md-2">
                      <strong>Redirecting time:</strong>
                  </div>
                  <div class="col-md-10">
                    @if($redirecting_time == 0)
                        <span style="display: inline;">0 Seconds</span>
                    @else
                        {{$redirecting_time/1000}} Seconds
                    @endif
                  </div>
                  <div class="col-md-2">
                      <strong>Redirecting text:</strong>
                  </div>
                <div class="col-md-10">
                    @if($redirecting_time == 0)
                        <span style="display: inline;">--</span>
                    @else
                        <span style="display: inline;">{{$redirecting_text}}</span>
                    @endif
                </div>

              </div>
              <hr>
                <div class="row">
                    <h5><strong><a id="prev-btn" class="prev-btn" data-toggle="collapse" data-target="#preview" title="Click hre to view your link preview">Your Link Preview  <span id="caret-icon"><i class="fa fa-caret-down"></i></span></a></strong></h5>
                        <div class="col-md-6 col-md-offset-3">
                            <div id="preview" class="collapse">
                                <div class="" id="thumbnail">
                                    <img width="100%" height="280px" data-src = "{{$url->og_image}}" src="{{$url->og_image}}" alt="{{$url->og_image}}">
                                </div>

                                <div class="left prev-og-box" id="content">
                                    <div class="prev-url"><a href="{{$shrt_url}}">{{ogUrl($shrt_url)}}</a></div>
                                    <div class="prev-title">
                                        @if($url->og_title)
                                            {{$url->og_title}}
                                        @else
                                            <strong>{{ogUrl($shrt_url)}}</strong>
                                        @endif
                                    </div>
                                    <div class="prev-description">{{$url->og_description}}</div>
                                </div>
                            </div>
                        </div>
                </div>
              <hr>
              <div class="tag">
                <ul>
                  <!-- <li>
                      <button id="clipboard" class="btn btn-default btn-sm btngrpthree" data-clipboard-action="copy" data-clipboard-target="#copylink" style="width:70px"><i class="fa fa-clipboard"></i> copy
                      </button>
                  </li>

                  <li>
                      <button class="btn btn-default btn-sm btngrpthree delete-url" data-id="{{ $url->id }}" style="width:70px"><i class="fa fa-trash-o"></i> delete
                      </button>
                  </li>
                  <li>
                    <button id="edit-btn" class="btn btn-default btn-sm btngrpthree" style="width:70px"><i class="fa fa-pencil"></i> edit</button>
                  </li> -->
                  <li>
                    <button id="fb-share-btn" class="btn btn-default btn-sm btngrpthree" style="width:70px"><i class="fa fa-facebook"></i> share</button>
                  </li>
                  <li>
                    {{--<button id="gp-share-btn" class="btn btn-default btn-sm btngrpthree g-interactivepost" data-clientid="815811879-s4o4qvinui63dckggf5u4upjcbjqvjbs.apps.googleusercontent.com" data-contenturl="http://tr5.test/b0DwpA" data-cookiepolicy="none" data-prefilltext="Web Design Development | Software Company USA - Tier5 LLC" data-calltoactionlabel="SEND" data-calltoactionurl="http://tr5.test/b0DwpA" style="width:70px" data-gapiscan="true" data-onload="true" data-gapiattached="true"><i class="fa fa-google-plus"></i> share</button>--}}

                    <button   id="gp-share-btn" class="btn btn-default btn-sm btngrpthree g-interactivepost" data-clientid="{{config('settings.GL.DATA_CLIENTID')}}" data-contenturl="{{$actual_url}}" data-cookiepolicy="none" data-prefilltext="{{$url->title}}" data-calltoactionlabel="SEND" data-calltoactionurl="{{$shrt_url}}" style="width:70px" data-gapiscan="true" data-onload="true" data-gapiattached="true"
											onclick="javascript:window.open('https://plus.google.com/share?url={{$shrt_url}}&data-description={{urlencode($url->meta_description)}}&data-url={{urlencode($url->og_url)}}&data-title={{urlencode($url->title)}}',
          							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i>Share</button>
                  </li>
                  <li>
												{{--
                        <button id="tw-share-btn" class="btn btn-default btn-sm btngrpthree" style="width:70px">
                          <i class="fa fa-twitter"></i> share
                        </button>
												--}}

                        <button  id="tw-share-btn" class="btn btn-default btn-sm btngrpthree" style="width:70px" onclick="javascript:window.open('https://twitter.com/intent/tweet?url={{urlencode($shrt_url)}}&data-url={{urlencode($actual_url)}}&text={{$url->meta_description}}',
  												'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i> Share</button>
									</li>
                  <li>
												{{--
                        <button id="tw-share-btn" class="btn btn-default btn-sm btngrpthree" style="width:70px">
                          <i class="fa fa-linkedin"></i> share
                        </button>
												--}}

                        <button id="ln-share-btn" class="btn btn-default btn-sm btngrpthree" style="width:70px"  onclick="javascript:window.open('https://www.linkedin.com/shareArticle?mini=true&url={{urlencode($actual_url)}}&data-url={{urlencode($shrt_url)}}&title={{urlencode($url->title)}}&summary={{urlencode($url->meta_description)}}',
  												'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"> <i class="fa fa-linkedin"></i> Share
                        </button>
                  </li>
                  <li>
                    <button id="addBrand" class="btn btn-default btn-sm btngrpthree" style="width:130px">
                      <i class="fa fa-bullhorn"></i> Create Ad
                    </button>
                  </li>
                  <li>
                    <button id="brandLink" class="btn btn-default btn-sm btngrpthree" style="width:130px">
                      <i class="fa fa-anchor"></i> Brand Link
                    </button>
                  </li>
                </ul>
              </div>
              <div class="map-area">
                {{-- This is where map loads dynamically --}}
                <div id="regions_div"></div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                          <table class="table table-striped table-condensed show-info-tab">
                              <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date & Time</th>
                                    <th>IP Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Browser</th>
                                    <th>Platform</th>
                                    <th width="5%">Referring Channel</th>
                                    <th width="18%">Query String</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if($ipLocations->count()==0 && ($url->link_type==2) && ($url->parent_id!=0))
                                    <tr>
                                        <td colspan="8" style="text-align: center;"><span class="text-muted text-center">No data available</span></td>
                                    </tr>
                                @elseif(($url->link_type==2) && ($url->parent_id==0))
                                    @if(count($sublink)>0)
                                        @foreach($sublink as $sublinks)
                                            @if(count($sublinks->ipLocations)>0)
                                                @foreach($sublinks->ipLocations as $ipLocation)
                                                    <tr>
                                                        <td>{{$serialNo}}.</td>
                                                        <td>
                                                            <p class="link-info-date" id="momentDt-{{$serialNo}}">{{date_format(date_create($ipLocation->created_at), 'D M d, Y')}}</p>
                                                            <p class="link-info-date" id="momentTm-{{$serialNo}}">{{date_format(date_create($ipLocation->created_at), 'h:i:s a')}}</p>
                                                            <span class="normal-date" id="moment-date-{{$serialNo}}">{{$ipLocation->created_at}}</span>
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->ip_address))
                                                                {{$ipLocation->ip_address}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->city))
                                                                {{$ipLocation->city}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->country))
                                                                {{$ipLocation->country}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->browser))
                                                                {{$ipLocation->browser}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->platform))
                                                                {{$ipLocation->platform}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->referer))
                                                                {{$ipLocation->referer}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ipLocation->query_string))
                                                                {{$ipLocation->query_string}}
                                                            @else
                                                                <small class="no-info">NA</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $serialNo++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @else
                                     <tr>
                                        <td colspan="8" style="text-align: center;"><span class="text-muted text-center">No data available</span></td>
                                    </tr>

                                    @endif
                                @elseif($ipLocations->count()>0)
                                    @foreach($ipLocations as $ipLocation)
                                        <tr>
                                            <td>{{$serialNo}}.</td>
                                            <td>
                                                <p class="link-info-date" id="momentDt-{{$serialNo}}">{{date_format(date_create($ipLocation->created_at), 'D M d, Y')}}</p>
                                                <p class="link-info-date" id="momentTm-{{$serialNo}}">{{date_format(date_create($ipLocation->created_at), 'h:i:s a')}}</p>
                                                <span class="normal-date" id="moment-date-{{$serialNo}}">{{$ipLocation->created_at}}</span>
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->ip_address))
                                                    {{$ipLocation->ip_address}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->city))
                                                    {{$ipLocation->city}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->country))
                                                    {{$ipLocation->country}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->browser))
                                                    {{$ipLocation->browser}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->platform))
                                                    {{$ipLocation->platform}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->referer))
                                                    {{$ipLocation->referer}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($ipLocation->query_string))
                                                    {{$ipLocation->query_string}}
                                                @else
                                                    <small class="no-info">NA</small>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $serialNo++;
                                        @endphp
                                    @endforeach
                                @endif
                              </tbody>
                          </table>
                          {{ $ipLocations->links() }}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12 col-sm-12">
                  <strong>Link Description:</strong><br>
                  	{{$url->title}}
                  </div>
              </div>
            </div>

            <div id="link-status" class="tab-pane fade">
               <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="tot-clicks">
                            <h2>Total Clicks {{$url->count}}</h2>
                            <div class="tot-clicks-body">
                                <div class="chart-div" id="chart_div">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="tot-clicks">
                            <h2>Platform Status</h2>
                            <div class="tot-clicks-body">
                                <div class="chart-div" id="platform_div">

                                </div>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="tot-clicks">
                            <h2>Browser Status</h2>
                            <div class="tot-clicks-body">
                                <div class="chart-div" id="browser_div">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="tot-clicks">
                            <h2>Referring Chanels</h2>
                            <div class="tot-clicks-body">
                                <div class="chart-div" id="referral_div">

                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>


          </div>
        </div>
      </div>

    </div>
  </div>
</div>



@include('contents/footer')

<script>
    $(function(){
        $('.redirection-link-box').mouseover(function(){
            $('.copy-btn').show();
        });
        $('.redirection-link-box').mouseout(function(){
            $('.copy-btn').hide();
        });

        $('.redirect-urls').mouseover(function(){
            var cpId = $(this).data('id');
            $('#cp-btn-'+cpId).show();
        });

        $('.redirect-urls').mouseout(function(){
            var cpId = $(this).data('id');
            $('#cp-btn-'+cpId).hide();
        });

        $('#prev-btn').on('click', function(){
            var icon = $('#caret-icon i').prop('class');
            if(icon=='fa fa-caret-up')
            {
                $('#caret-icon i').prop('class', 'fa fa-caret-down');
            }else
            {
                $('#caret-icon i').prop('class', 'fa fa-caret-up');
            }
        });

        // time of users
        //var timezone = moment.tz.guess();
        //var newYork    = moment.tz("2014-06-01 12:00", "{{$serverTZ}}");
        //var losAngeles = newYork.clone().tz("America/Los_Angeles");
        //alert(tm.clone().tz(timezone));
        //alert(losAngeles);

        for(var i=0; i<`{{$ipLocations->count()}}`; i++)
        {
            var indx = 1+parseInt(i);
            var currentDate = $('#moment-date-'+indx).text();
            var timezone = moment.tz.guess();
            //Date.parse(currentDate)
            var tm = moment.tz(Date.parse(currentDate), "{{$serverTZ}}");
            var momentDt = tm.clone().tz(timezone).format('dddd MMMM Do, YYYY');
            var momentTm = tm.clone().tz(timezone).format('hh:mm:ss A');
            $('#momentDt-'+indx).text(momentDt);
            $('#momentTm-'+indx).text(momentTm);
        }

    });


    function copyUrl(id)
    {
        var temp = $("<input>");
        $("body").append(temp);
        var data = $('#url-'+id).prop('href');
        data = data.trim();
        temp.val(data).select();
        document.execCommand("copy");
        temp.remove();
        var node = document.getElementById('url-'+id);
        if (document.body.createTextRange) {
            const range = document.body.createTextRange();
            range.moveToElementText(node);
            range.select();
        } else if (window.getSelection) {
            const selection = window.getSelection();
            const range = document.createRange();
            range.selectNodeContents(node);
            selection.removeAllRanges();
            selection.addRange(range);
        } else {
            console.warn("Could not select text in node: Unsupported browser.");
        }
    }
</script>

<!-- ManyChat -->
<!-- <script src="//widget.manychat.com/216100302459827.js" async="async"></script> -->


{{-- script for summernote js --}}
<script>
    $(document).ready(function () {


      function initSummernote(preloadText) {
      $('#redirectingTextTemplate').summernote({
      height: 100,
      minHeight: null,
      maxHeight: null,
      focus: true,
      toolbar: [
          ['style', ['bold', 'italic', 'underline']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['height', ['height']],
          ['insert', ['link']],
          ['misc', ['undo', 'redo', 'codeview']]
      ]
      });
        $('#redirectingTextTemplate').summernote('code', preloadText);
      }

        $('#clipboard').on('click', function () {
            new Clipboard('#clipboard');
        });
        $('#edit-btn').on('click', function () {
            //alert('clicked - here');
            $("#editModalBody #urlTitle").val('{{$url->title}}');
            $("#editModalBody #urlId").val('{{$url->id}}');
            $('#myModal').modal('show');
            editAction();
        });
        $('#fb-share-btn').on('click', function () {
					fb_share("{{config('settings.FB.APP_ID')}}",
					'{{$shrt_url}}',
					'{{$actual_url}}',
					'{{$url->og_description}}',
					'{{$url->og_title}}' ,
					'{{$url->og_image}}' ,
					'{{$url->og_url}}');
            //fb_share("{{ route('getIndex') }}/{{ $url->shorten_suffix }}" , '{{url('/')}}');
        });
        $('#addBrand').on('click', function () {
            $("#urlId1").val('{{$url->id}}');
            $("#redirectingTime").val('{{$url->redirecting_time/1000}}');
            initSummernote('{!! $url->redirecting_text_template !!}');
            $('#myModal1').modal('show');
        });
        $('#brandLink').on('click', function () {
            $("#subdomainModalBody #urlId").val('{{ $url->id }}');
            $("#subdomainBrand").val('');
            $("#subdomainAlert").text('');
            $("#subdomainRadioAlert").text('');
            $("#subdomainRadio").attr('checked',false);
            $("#subdirectoryRadio").attr('checked',false);
            $('#subdomainModal').modal('show');
        });
    });


    function editAction() {
        $('#editUrlTitle').on('click', function () {
            var id = $('.modal-body #urlId').val();
            var title = $('.modal-body #urlTitle').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('postEditUrlInfo') }}",
                data: {id: id, title: title, _token: "{{ csrf_token() }}"},
                success: function(response) {
                  console.log('postEditUrlInfo');
                    $('#myModal').modal('hide');
                    swal({
                        title: "Success",
                        text: "Successfully edited title",
                        type: "success",
                        html: true
                    });
                    $('#urlTitleHeading').replaceWith('<h1 id="urlTitleHeading">'+response.url.title+'</div>');
                    $('#tab-title').replaceWith('<span id="tab-title" class="title">'+response.url.title+'</span>');
                    $(".modal-body #urlTitle").val(response.url.title);
                },
                error: function(response) {
                    swal({
                        title: "Oops!",
                        text: "Cannot edit this title",
                        type: "warning",
                        html: true
                    });
                }
            });
        });
    }

</script>


{{-- Script for google maps --}}
<script type="text/javascript">

          google.charts.load('current', {'packages':['corechart', 'geochart']});
          $.ajax({
              url: "{{ route('postFetchAnalytics') }}",
              type: 'POST',
              data: {url_id: {{ $url->id }}, _token: "{{ csrf_token() }}"},
              success: function (response) {
                console.log(response);
                  if (response.status == "success") {
                      google.charts.setOnLoadCallback(function () {
                          var data = google.visualization.arrayToDataTable(response.location);
                          var options = {
                              colorAxis: {colors: '#3366ff'},
                              background: 'rgba(255, 255, 255, 0.8)',
                              width   : '100%',
                              height  : 360,
                              margin  : 15,
                              border  : 15,
                              marginColor : 'black'
                          };
                          var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
                          chart.draw(data, options);
                          @if ($subscription_status != null)
                          google.visualization.events.addListener(chart, 'select', function() {
                              var selectionIdx = chart.getSelection()[0].row;
                              var countryName = data.getValue(selectionIdx, 0);
                              window.location.href = "{{ route('getIndex') }}/{{ $url->shorten_suffix }}/country/" + countryName + '/analytics';
                          });
                          @endif
                      });
                      google.charts.setOnLoadCallback(function () {
                          var data = google.visualization.arrayToDataTable(response.location);
                          var options = {
                              title: 'Number of hits per country',
                              width: 350,
                              height: 250,
                          };
                          var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                          chart.draw(data, options);
                          @if ($subscription_status != null)
                          google.visualization.events.addListener(chart, 'select', function() {
                              var selectionIdx = chart.getSelection()[0].row;
                              var countryName = data.getValue(selectionIdx, 0);
                              window.location.href = '{{ route('getIndex') }}/{{ $url->shorten_suffix }}/country/' + countryName + '/analytics';
                          });
                          @endif
                      });
                      @if ($subscription_status != null)
                      google.charts.setOnLoadCallback(function () {
                          var data = google.visualization.arrayToDataTable(response.platform);
                          var options = {
                              title: 'Platform Shares',
                              pieHole: 0.4,
                              slices: {textStyle: {fontSize: 6}},
                              width: 400,
                              height: 250,
                          };
                          var chart = new google.visualization.PieChart(document.getElementById('platform_div'));
                          chart.draw(data, options);
                      });
                      google.charts.setOnLoadCallback(function () {
                          var data = google.visualization.arrayToDataTable(response.browser);
                          var options = {
                              title: 'Browser Stats',
                              pieHole: 0.4,
                              slices: {textStyle: {fontSize: 6}},
                              width: 400,
                              height: 250,
                          };
                          var chart = new google.visualization.PieChart(document.getElementById('browser_div'));
                          chart.draw(data, options);
                      });
                      google.charts.setOnLoadCallback(function () {
                          var data = google.visualization.arrayToDataTable(response.referer);
                          var options = {
                              title: 'Referring Channels',
                              pieHole: 0.4,
                              slices: {textStyle: {fontSize: 6}},
                              width: 400,
                              height: 250,
                          };
                          var chart = new google.visualization.PieChart(document.getElementById('referral_div'));
                          chart.draw(data, options);
                      });
                      @endif
                  } else {
                   console.log('Response error!');
                  }
              }
          });
  </script>



<script type="text/javascript">

var appURL = "{{url('/')}}";
appURL = appURL.replace('https://','');
appURL = appURL.replace('http://','');

console.log('appURL : ',appURL);

// var giveMyTags = function() {
// 	$.ajax({
// 		type 	:	"POST",
// 		url		:	"{{route('giveMyTags')}}",
// 		data	: {_token:'{{csrf_token()}}'},
// 		success : function(res) {
// 			console.log(res);
// 			var tagsArray = [];
// 			for(var i = 0 ; i < res.data.length ; i ++) {
// 				var ob = {tag : res.data[i]};
// 				console.log('each ob : ',ob);
// 				tagsArray.push(ob);
// 			}
// 			console.log('final tags : ',tagsArray);
// 			$('#shortTagsContentss').selectize({
// 				maxItems: null,
// 				valueField: 'tag',
// 				labelField: 'tag',
// 				searchField: 'tag',
// 				options: tagsArray,
// 				create: true
// 			});
// 		},
// 		error : function(res) {
// 			console.log(res);
// 		}
// 	});
// }

window.onload = function(){
	console.log('reached here');
	//giveMyTags();
}

// var $select = $('#shortTagsContentss').selectize({
// 				maxItems: null,
// 				valueField: 'tag',
// 				labelField: 'tag',
// 				searchField: 'tag',
// 				options: [
// 					{tag: 'tag1'},{tag:'tag2'},{tag:'tag3'}
// 				],
// 				create: true
// 			});

	var maintainSidebar = function(thisInstance) {
		//facebook analytics checkbox for short urls
		if (thisInstance.id === "checkboxAddFbPixelid" && thisInstance["name"] === "chk_fb_short") {
			if(thisInstance.checked) {
				$('#fbPixelid').show();
			} else {
				$('#fbPixelid').hide();
				$('#fbPixelid').val('');
			}
		}

		//facebook analytics checkbox for custom urls
		if (thisInstance.id === "checkboxAddFbPixelid1" && thisInstance["name"] === "chk_fb_custom") {
			if(thisInstance.checked) {
				$('#fbPixelid1').show();
			} else {
				$('#fbPixelid1').hide();
				$('#fbPixelid1').val('');
			}
		}

		//google analytics checkbox for short urls
		if (thisInstance.id === "checkboxAddGlPixelid" && thisInstance["name"] === "chk_gl_short") {
			if(thisInstance.checked) {
				$('#glPixelid').show();
			} else {
				$('#glPixelid').hide();
				$('#glPixelid').val('');
			}
		}

		//google analytics checkbox for custom urls
		if (thisInstance.id === "checkboxAddGlPixelid1" && thisInstance["name"] === "chk_gl_custom") {
			if(thisInstance.checked) {

				$('#glPixelid1').show();
			} else {
				$('#glPixelid1').hide();
				$('#glPixelid1').val('');
			}
		}

		//addtags for short urls
		if (thisInstance.id === "shortTagsEnable" && thisInstance["name"] === "shortTagsEnable") {
			if(thisInstance.checked) {
				$('#shortTagsArea').show();
			} else {
				$('#shortTagsArea').hide();
				$("#shortTagsContents").tagsinput('removeAll');
			}
		}

		//addtags for custom urls
		if (thisInstance.id === "customTagsEnable" && thisInstance["name"] === "customTagsEnable") {
			if(thisInstance.checked) {
				$('#customTagsArea').show();
			} else {
				$('#customTagsArea').hide();
				$("#customTagsContents").tagsinput('removeAll');
			}
		}

		//add short descriptions for short urls
		if (thisInstance.id === "shortDescriptionEnable" && thisInstance["name"] === "shortDescriptionEnable") {
			if(thisInstance.checked) {
				$('#shortDescriptionContents').show();
			} else {
				$('#shortDescriptionContents').hide();
				$('#shortDescriptionContents').val('');
			}
		}

		//add short descriptions for short urls
		if (thisInstance.id === "customDescriptionEnable" && thisInstance["name"] === "customDescriptionEnable") {
			if(thisInstance.checked) {
				$('#customDescriptionContents').show();
			} else {
				$('#customDescriptionContents').hide();
				$('#customDescriptionContents').val('');
			}
		}
	}

	$(document).ready(function() {

		// $('#dashboard-tags-to-search').on('beforeItemAdd', function(event) {
		// 	var string = $(this).text();
		// 	$(this).html(string.replace(/,/g , ''));
		//   // event.item: contains the item
		//   // event.cancel: set to true to prevent the item getting added
		// });

		$("#dashboard-search-btn").on('click',function() {
			console.log('came here : submitting form');
			var data = $("#dashboard-search-form").serialize();
			$("#dashboard-search-form").submit();
		});

		// $("#dashboard-search-form").on('submit',function(e){
		// 	console.log('form submit handler called');
		// 	e.preventDefault();
		// });

		$("#dashboard-search").on('click',function() {
			var tags = $("#dashboard-tags-to-search").tagsinput('items');
			var text = $("#dashboard-text-to-search").val();
			console.log('tags :',tags,' text: ',text);
		});

		// $('.shortTagsContents').tagsinput({
    //   	allowDuplicates: false,
		// 		maxChars: 20,
    //     // itemValue: 'id',  // this will be used to set id of tag
    //     // itemText: 'label' // this will be used to set text of tag
    // });
		// $('.customTagsContents').tagsinput({
    //   	allowDuplicates: false,
		// 		maxChars: 20,
    //     // itemValue: 'id',  // this will be used to set id of tag
    //     // itemText: 'label' // this will be used to set text of tag
    // });
		// $('.dashboard-tags-to-search').tagsinput({
    //   	allowDuplicates: false,
		// 		maxChars: 20,
		// 		maxTags: 3
    //     // itemValue: 'id',  // this will be used to set id of tag
    //     // itemText: 'label' // this will be used to set text of tag
    // });


		$(":checkbox").on("change", function() {
			maintainSidebar(this);
    });



		// $('#checkboxAddGlPixelid1, input[type="checkbox"]').on('click', function(){
		// 	if($(this).prop("checked") == true){
		// 			$('#glPixelid1').show();
    //   }
    //   else if($(this).prop("checked") == false){
		// 			$('#glPixelid1').hide();
		// 			$('#glPixelid1').val('');
    //   }
		// });
    //
		// $('#checkboxAddFbPixelid1, input[type="checkbox"]').on('click', function(){
		// 	if($(this).prop("checked") == true){
		// 			$('#fbPixelid1').show();
    //   }
    //   else if($(this).prop("checked") == false){
		// 			$('#fbPixelid1').hide();
		// 			$('#fbPixelid1').val('');
    //   }
		// });

		$(this).on('click', '.menu-icon', function(){
	    	$(this).addClass("close");
	    	$('#userdetails').slideToggle(500);
	    	$('#myNav1').hide();
	    	$('#myNav2').hide();
	    });

	    $("#basic").click(function(){
	    	$('.menu-icon').addClass("close");
	    	$('#myNav1').slideToggle(500);
	    	$('#myNav2').hide();
	    	$('#userdetails').hide();
				maintainSidebar(this);
	    });

	    $("#advanced").click(function(){
	    	$('.menu-icon').addClass("close");
	    	$('#myNav2').slideToggle(500);
	    	$('#myNav1').hide();
	    	$('#userdetails').hide();
				maintainSidebar(this);
	    });

	    $(this).on('click', '.close', function(){
        	$('.userdetails').hide();
        	$(this).removeClass("close");
        });

		$('[data-toggle="tooltip"]').tooltip();
        $('#hamburger').on('click', function () {
            $('.sidebar.right').addClass('open', true);
            $('.sidebar.right').removeClass('close', true);
        });
        $('#cross').on('click', function () {
            $('.sidebar.right').toggleClass('close', true);
            $('.sidebar.right').removeClass('open', true);
        });
        $('#tr5link').on('click', function () {
            $('.tr5link').addClass('open', true);
            $('.tr5link').removeClass('close', true);
        });

        $('#customLink').on('click', function () {
            $('.sharebar').addClass('open', true);
            $('.sharebar').removeClass('close', true);
        });
        $('#cross2').on('click', function () {
            $('.sharebar').addClass('close', true);
            $('.sharebar').removeClass('open', true);
        });
        $('#noTr5Link').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });
        $('#noCustomLink').on('click', function () {
            swal({
                type: 'warning',
                title: 'Notification',
                text: 'You have maximum shorten links. Please upgrade account to get hassle free services.'
            });
        });


	});
</script>
<script src="https://sdkcarlos.github.io/sites/holdon-resources/js/HoldOn.js"></script>
<script src="{{ URL::to('/').'/public/resources/js/min/toucheffects-min.js'}}"></script>

<script type="text/javascript">
	$(document).ready(function(){


		$.fn.modal.Constructor.prototype.enforceFocus = function() {};

		$(".list-group ul li").click(function(){
			$(this).addClass("active");
			$(".list-group ul li").not($(this)).removeClass("active");
			$(window).scrollTop(500);
			var index = $(this).index();
		        $("div.tab-content").removeClass("active");
		        $("div.tab-content").eq(index).addClass("active");
			});
	});
</script>


<script>
            $(document).ready(function () {
                var options = {
                    theme:"custom",
                    content:'<img style="width:80px;" src="{{ URL::to('/').'/public/resources/img/company_logo.png' }}" class="center-block">',
                    message:"Please wait a while",
                    backgroundColor:"#212230"
                };
	        $('#swalbtn1').click(function(){

                	var actualUrl = $('#givenActualUrl').val();
                    var customUrl = $('#makeCustomUrl').val();
                    @if (Auth::user())
                        var userId = {{ Auth::user()->id }};
                    @else
                        var userId = 0;
                    @endif

										var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid1").prop('checked');
										var fbPixelid							= 	$("#fbPixelid1").val();
										var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid1").prop('checked');
										var glPixelid							= 	$("#glPixelid1").val();
										var allowTag							=   $("#customTagsEnable").prop('checked');
										var tags 									= 	$("#customTagsContents").tagsinput('items');
										var allowDescription      = 	$("#customDescriptionEnable").prop('checked');
										var searchDescription			= 	$("#customDescriptionContents").val();

                    $.ajax({
	                    type:"POST",
	                    url:"/check_custom",
	                    data: {custom_url: customUrl , _token:'{{csrf_token()}}'},
	                    success:function(response){
	                    	console.log('check_custom');
	                    	console.log(response);
	                    	if(response == 1)
	                    	{
	                    		console.log(response);
	                    		if (ValidURL(actualUrl))
			                    {
			                        if (ValidCustomURL(customUrl))
			                        {
			                            $.ajax({
			                                type: "POST",
			                                url: "{{ route('postCustomUrlTier5') }}",
			                                data: {
																					checkboxAddFbPixelid 	: checkboxAddFbPixelid,
																					fbPixelid							: fbPixelid,
																					checkboxAddGlPixelid 	: checkboxAddGlPixelid,
																					glPixelid 						: glPixelid,
			                                    actual_url						: actualUrl,
			                                    custom_url						: customUrl,
			                                    user_id								: userId,
																					allowTag							: allowTag,
																					tags									: tags,
																					allowDescription			: allowDescription,
																					searchDescription			: searchDescription,
			                                    _token: "{{ csrf_token() }}"
			                                }, success: function (response) {
			                                	console.log('postCustomUrlTier5');
			                                    if(response.status=="success") {
			                                        var shortenUrl = response.url;
			                                        var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
			                                        swal({
			                                            title: "Shorten Url:",
			                                            text: displayHtml,
			                                            type: "success",
			                                            html: true
			                                        }, function() {
			                                            window.location.reload();
			                                        });
			                                        new Clipboard('#clipboardswal');
			                                        $('#clipboardswal').on('click', function () {
			                                            window.location.reload();
			                                        });
			                                        HoldOn.close();
			                                    } else {
			                                        swal({
			                                            title: null,
			                                            text: "Please paste an actual URL",
			                                            type: "warning",
			                                            html: true
			                                        });
			                                        HoldOn.close();
			                                    }
			                                }, error: function(response) {
			                                    console.log('Response error!');
			                                    HoldOn.close();
			                                }, statusCode: {
			                                    500: function() {
			                                        swal({
			                                            title: null,
			                                            text: "Access Forbidden, Please paste a valid URL!",
			                                            type: "error",
			                                            html: true
			                                        });
			                                        HoldOn.close();
			                                    }
			                                }
			                            });
			                        }
			                        else
			                        {
			                            swal({
			                                type: "warning",
			                                title: null,
			                                text: "Please Enter A Custom URL<br>It Should Be AlphaNumeric",
			                                html: true
			                            });
			                        }
			                    }
			                    else
			                    {
			                        swal({
			                            type: "warning",
			                            title: null,
			                            text: "Please Enter An URL"
			                        	});
			                    }
	                    	}
	                    	else
	                    	{
	                    		$("#err_cust").show();
	                    		//url already used by this user
	                    	}

	                    }
	                });
                });



                function ValidURL(str) {

										if(str.indexOf("http://") == 0) {
											return true;
										} else if(str.indexOf("https://") == 0) {
											return true;
										} else {
											return false;
										}

                    // var regexp = new RegExp("[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)([a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;%\$#_]*)?\.(com|org|net|co|edu|ac|gr|htm|html|php|asp|aspx|cc|in|gb|au|uk|us|pk|cn|jp|br|co|ca|it|fr|du|ag|gl|ly|le|gs|dj|cr|to|nf|io|xyz)");
                    // var url = str;
                    // if (!regexp.test(url)) {
                    //     return false;
                    // } else {
                    //     return true;
                    // }
                }

                function ValidCustomURL(str) {
                    var regexp = new RegExp("^[a-zA-Z0-9_]+$");
                    var url = str;
                    if (!regexp.test(url)) {
                        return false;
                    } else {
                        return true;
                    }
                }

                $('#swalbtn').click(function() {
                    var url = $('#givenUrl').val();
                    var validUrl = ValidURL(url);
                    @if (Auth::user())
                        var userId = {{ Auth::user()->id }};
                    @else
                        var userId = 0;
                    @endif

										var checkboxAddFbPixelid 	= 	$("#checkboxAddFbPixelid").prop('checked');
										var fbPixelid							= 	$("#fbPixelid").val();
										var checkboxAddGlPixelid 	= 	$("#checkboxAddGlPixelid").prop('checked');
										var glPixelid							= 	$("#glPixelid").val();
										var allowTag							=   $("#shortTagsEnable").prop('checked');
										var tags 									= 	$("#shortTagsContents").tagsinput('items');
										var allowDescription      = 	$("#shortDescriptionEnable").prop('checked');
										var searchDescription			= 	$("#shortDescriptionContents").val();

                    if(url) {
                        if(validUrl) {
                            HoldOn.open(options);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('postShortUrlTier5') }}",
                                data: {
																	url										: url,
																	user_id								: userId,
																	checkboxAddFbPixelid 	: checkboxAddFbPixelid,
																	fbPixelid 						: fbPixelid,
																	checkboxAddGlPixelid 	: checkboxAddGlPixelid,
																	glPixelid 						: glPixelid,
																	allowTag							: allowTag,
																	tags									: tags,
																	allowDescription			: allowDescription,
																	searchDescription			: searchDescription,
																	_token: "{{ csrf_token() }}"},
                                success: function (response) {
                                	console.log('postShortUrlTier5');
                                    if(response.status=="success") {
                                        var shortenUrl = response.url;
                                        var displayHtml = "<a href="+shortenUrl+" target='_blank' id='newshortlink'>"+shortenUrl+"</a><br><button class='button' id='clipboardswal' data-clipboard-target='#newshortlink''><i class='fa fa-clipboard'></i> Copy</button>";
                                        swal({
                                            title: "Shorten Url:",
                                            text: displayHtml,
                                            type: "success",
                                            html: true
                                        }, function() {
                                            window.location.reload();
                                        });
                                        new Clipboard('#clipboardswal');
                                        $('#clipboardswal').on('click', function () {
                                            window.location.reload();
                                        });
                                        HoldOn.close();
                                    } else {
                                        swal({
                                            title: null,
                                            text: "Please paste an actual URL",
                                            type: "warning",
                                            html: true
                                        });
                                        HoldOn.close();
                                    }
                                }, error: function(response) {
                                    console.log('Response error!');
                                    HoldOn.close();
                                }, statusCode: {
                                    500: function() {
                                        swal({
                                            title: null,
                                            text: "Access Forbidden, Please paste a valid URL!",
                                            type: "error",
                                            html: true
                                        });
                                        HoldOn.close();
                                    }
                                }
                            });
                        } else {
                            var errorMsg="Enter A Valid URL";
                            swal({
                                title: null,
                                text: errorMsg,
                                type: "error",
                                html: true
                            });
                        }
                    } else {
                        var errorMsg="Please Enter An URL";
                        swal({
                            title: null,
                            text: errorMsg,
                            type: "warning",
                            html: true
                        });
                    }
                });

            });

        </script>
        <script type="text/javascript">
        $(document).ready(function () {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });
        </script>
        <script>
        $(document).ready(function(){
            @if (isset($filter) and $filter != null) {

                $.ajax({
                    type: "POST",
                    url: "{{ route('postChartDataFilterDateRange') }}",
                    data: {
                        "user_id": {{ $user->id }},
                        "start_date": "{{ $filter['start'] }}",
                        "end_date": "{{ $filter['end'] }}",
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                    	console.log('postChartDataFilterDateRange');
                    	console.log(response);
                    	var date_from = "{{ date( 'M d'  , strtotime($filter['start'])) }}";
                    	var date_to   = "{{ date( 'M d'  , (strtotime($filter['end']))-86400) }}";

                    	$('#date_range').text(date_from+ ' - ' +date_to);

                        var chartDataStack = [];
                        $('#columnChart').highcharts({
                            chart: {
                                type: 'column',
                                backgroundColor: 'rgba(255, 255, 255, 0)'
                            },
                            title: {
                                text: null
                            },
                            xAxis: {
                                type: 'category',
                                labels: {
                                    style: {
                                        fontWeight: 'bold',
                                        color: '#fff'
                                    }
                                }
                            },
                            yAxis: {
                                labels: {
                                    enabled: false
                                },
                                title: {
                                    text: null
                                },
                                gridLineWidth: 0,
                                minorGridLineWidth: 0
                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: false,
                                        format: '{point.y:.1f}%'
                                    },
                                    events:{
                                        click: function (event) {
                                            var pointName = event.point.name;
                                            if (pointName.search(appURL)) {
                                                var pointData = event.point.year+' '+pointName;
                                                chartDataStack = [];
                                                chartDataStack.push(pointData);
                                            } else {
                                                pushChartDataStack(pointName);
                                            }
                                        }
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#fff',
                                borderWidth: 1,
                                borderRadius: 10,
                                borderColor: '#AAA',
                                headerFormat: null,
                                pointFormat: '<span style="color:{point.color}">{point.name}</span><br/>Total clicks: <b>{point.y:.0f}</b>'
                            },
                            series: [{
                                name: 'URLs',
                                colorByPoint: true,
                                //pointWidth: 28,
                                data: response.chartData
                            }],
                            drilldown: {
                                activeAxisLabelStyle: {
                                    textDecoration: 'none',
                                    fontStyle: 'italic',
                                    color: '#54BDDC'
                                },
                                activeDataLabelStyle: {
                                    textDecoration: 'none',
                                    fontStyle: 'italic',
                                    color: '#fff'
                                },
                                drillUpButton: {
                                    relativeTo: 'spacingBox',
                                    position: {
                                        y: 0,
                                        x: 0
                                    },
                                    theme: {
                                        fill: 'white',
                                        'stroke-width': 1,
                                        stroke: 'silver',
                                        r: 0,
                                        states: {
                                            hover: {
                                                color: '#fff',
                                                stroke: '#039',
                                                fill: '#2AABD2'
                                            },
                                            select: {
                                                color: '#fff',
                                                stroke: '#039',
                                                fill: '#bada55'
                                            }
                                        }
                                    }
                                },
                                series: [
                                @foreach ($dates as $key => $date)
                                {
                                    name: '{{ $date }}',
                                    id: '{{ $date }}',
                                    data: response.statData[{{ $key }}]
                                },
                                @endforeach
                                ]
                            }
                        });
                        @if ($subscription_status != null)
                            function pushChartDataStack(url) {
                                date = new Date(chartDataStack.pop());
                                nextDate = new Date(date.setDate(date.getDate()+1)).toISOString().slice(0, 10);
                                //window.location.href = url+"/date/"+nextDate+"/analytics";
                            }
                        @endif
                    },
                    error: function(response) {
                        console.log('Response error!');
                    },
                    statusCode: {
                        500: function(response) {
                            console.log('500 Internal server error!');
                        }
                    }
                });
            }
            @else
						var textToSearch = $("#dashboard-text-to-search").val();
						var tagsToSearch = $("#dashboard-tags-to-search").val();
            $.ajax({
                type: 'post',
                url: "{{ route('postFetchChartData') }}",
                data: {
									'user_id': '{{ $user->id }}',
									'_token': '{{ csrf_token() }}',
									textToSearch : textToSearch,
									tagsToSearch : tagsToSearch
								},
                success: function(response) {
                	console.log('postFetchChartData');
                	console.log(response);
                    var chartDataStack = [];
										var urlSeries = [];
										if (response.urls.length > 0) {
											var ur_len = response.urls.length;
											for(var i = 0 ; i < ur_len ; i ++) {
												var ur_obj = {
													name 	: response.urls[i]['name'],
													id 		:	response.urls[i]['name'],
													data 	:	response.urlStat[i]
												};
												urlSeries.push(ur_obj);
												ur_obj = null;
											}
										}
                    $('#columnChart').highcharts({
                        chart: {
                            type: 'column',
                            backgroundColor: 'rgba(49, 83, 105, 1)'
                        },
                        title: {
                            text: null
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                style: {
                                    fontWeight: 'bold',
                                    color: '#fff'
                                }
                            }
                        },
                        yAxis: {
                            labels: {
                                enabled: false
                            },
                            title: {
                                text: null
                            },
                            gridLineWidth: 0,
                            minorGridLineWidth: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series : {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: false,
                                    format: '{point.y:.1f}%'
                                },
                                events : {
                                    click: function (event) {
                                        var pointName = event.point.name;
																				//var urlToSearch = "{{url('/')}}";
																				var urlToSearch = appURL;
                                        if (pointName.search(urlToSearch) == -1) {
																						console.log('searching for :',urlToSearch);
																						console.log('serach_ res',pointName.search(urlToSearch));
																						console.log('came here 1 : pointname : ',pointName);
																						console.log('');
                                            pushChartDataStack(pointName);
                                        } else {
																						console.log('searching for :',urlToSearch);
																						console.log('serach_ res',pointName.search(pointName));
																						console.log('came here 2 : pointname : ',pointName);
                                            chartDataStack = [];
																						console.log('');
                                            chartDataStack.push(pointName);
                                        }
                                    }
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            borderWidth: 2,
                            borderRadius: 5,
                            borderColor: '{point.color}',
                            headerFormat: null,
                            pointFormat: '<span style="color:{point.color}">{point.name}</span><br/><span style="color:{point.color}">\u25A0</span> Total clicks: <b>{point.y:.0f}</b>'
                        },
                        series: [{
                            name: 'URLs',
                            colorByPoint: true,
                            //pointWidth: 50,
                            data: response.urls,    //dataset for all urls and counts
                        }],
                        drilldown: {
                            activeAxisLabelStyle: {
                                textDecoration: 'none',
                                fontStyle: 'italic',
                                color: '#ffffff'
                            },
                            activeDataLabelStyle: {
                                textDecoration: 'none',
                                fontStyle: 'italic',
                                color: '#fff'
                            },
                            drillUpButton: {
                                relativeTo: 'spacingBox',
                                position: {
                                    y: 0,
                                    x: 0
                                },
                                theme: {
                                    fill: 'white',
                                    'stroke-width': 1,
                                    stroke: 'silver',
                                    r: 0,
                                    states: {
                                        hover: {
                                            color: '#fff',
                                            stroke: '#039',
                                            fill: '#2AABD2'
                                        },
                                        select: {
                                            color: '#fff',
                                            stroke: '#039',
                                            fill: '#bada55'
                                        }
                                    }
                                }
                            },
                            series: urlSeries
                        }
                    });
                    @if ($subscription_status != null)
                    function pushChartDataStack(data) {
												console.log('came here 3');
                        chartDataStack.push(data);
                        date = new Date(chartDataStack.pop());
                        month = date.getMonth()+1;
                        isoDate = date.getFullYear()+"-"+month+"-"+date.getDate();
												console.log('location to redirect : ',chartDataStack[0]+"/date/"+isoDate+"/analytics");
                        //window.location.href = chartDataStack[0]+"/date/"+isoDate+"/analytics";
                    }
                    @endif
                },
                error: function(response) {
                    console.log('Response error!');
                },
                statusCode: {
                    500: function(response) {
                        console.log('500 Internal server error!');
                    }
                }
            });
            @endif
        });
        </script>
        @if(Session::has('success'))
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        title: "Success",
                        text: "{{Session::flush('success')}}",
                        type: "success",
                        html: true
                    });
                });
            </script>
        @endif
        @if(Session::has('error'))
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        title: "Error",
                        text: "{{Session::flush('error')}}",
                        type: "error",
                        html: true
                    });
                });
            </script>
        @endif
        @if ($errors->any())
            <script>
                $(document).ready(function(){
                    swal({
                        title: "Error",
                        text: "@foreach ($errors->all() as $error){{ $error }}<br/>@endforeach",
                        type: "error",
                        html: true
                    });
                });
            </script>
        @endif
        <script>

        </script>
        <script src="{{ URL('/')}}/public/resources/js/bootstrap-datepicker.min.js"></script>
        <script>
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                toggleActive: true,
                clearBtn: true,
                //startDate: '-1m',
                endDate: '+0d'
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#datePickerFrom').on('blur', function () {
                    var from = $(this).val();
                    if (from == null) {
                        $(this).focus();
                        $(this).parent().append('<p style="color: red">Start date can not be null.</p>');
                    }
                });
                $('#datePickerTo').on('blur', function () {
                    var to = $(this).val();
                    if (to ===null) {
                        $(this).focus();
                        $(this).parent().append('<p style="color: #f00">End cate can not be null.</p>');
                    }
                });
            });
        </script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>


		@if(\Session::has('adv'))
		<script type="text/javascript">
			$(document).ready(function(){
				swal({
                        title: "Nothing to upgrade",
                        text: "{{Session::get('adv')}}",
                        type: "info",
                        html: true
                    });
			});
		</script>
		@endif


		<script type="text/javascript">
			$(document).ready(function(){

				/*if (typeof(FB) != 'undefined'
		     && FB != null ) {
		    // run the app
			} else {
			    alert('check browser settings to enable facebook sharing.. ');
			}*/
			});

      /** Function to delete url **/

        $(function () {
            $(".delete-url").click(function (e) {
              e.preventDefault();
              var url_id = $(this).data('id');
              swal({
                  title: "Are you sure?",
                  text: "You will not be able to recover this imaginary file!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                }, function (isConfirm) {
                  if (!isConfirm) return;
                  $.ajax({
                      type: "POST",
                      url: "{{ route('deleteShortenUrl') }}",
                      data: {id: url_id, _token: "{{ csrf_token() }}"},
                      success: function(response) {
                        swal({
                          title: "Success",
                          text: "Url deleted successfully.",
                          type: "success",
                          html: true
                        },function(isConfirm){
													window.location.href = "{{ url('/') }}/app/user/dashboard";
												});
                      },
                      error: function(response) {
                          swal({
                              title: "Oops!",
                              text: "Cannot delete this url.",
                              type: "error",
                              html: true
                          });
                      }
                  });
              });
            });
        });


            /* countdown time frontend validiation */
            $(document).ready(function(){
                $('#redirectingTime').bind('keyup change click' ,function(){
                    var countDownTime = $(this).val();
                    if(countDownTime.match(/[0-9]|\./))
                    {
                        if(countDownTime<=30 && countDownTime>=1)
                        {
                            $('#redirectingTime').val(countDownTime);
                        }
                        if(countDownTime>30)
                        {
                            $('#redirectingTime').val(30);
                        }
                        if(countDownTime<=0)
                        {
                            $('#redirectingTime').val(1);
                        }


                    }else
                    {
                        swal({
                            type: 'warning',
                            title: 'Notification',
                            text: 'Countdown time should be numeric and minimum 1 & maximum 30.'
                        });
                        $('#redirectingTime').val(5);
                    }
                });
            });

		</script>

</body>
</html>
