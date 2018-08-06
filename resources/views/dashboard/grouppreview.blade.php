@extends('layout/layout')
@section('content')
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
    <div class="main-dashboard-body">
  		  <div class="main-content">
    		    <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
            						<ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#link-details">Group Details</a></li>
            						</ul>
          				      <div class="tab-content tab-holder">
            				        <div id="link-details" class="tab-pane fade in active">
                  							@php
                  							if(isset($url->subdomain)) {
                  							    if($url->subdomain->type == 'subdomain')
                  							       $shrt_url = config('settings.SECURE_PROTOCOL').$url->subdomain->name.'.'.config('settings.APP_REDIRECT_HOST');
                  							    else
                                                    if($url->subdomain->type == 'subdirectory')
                  							           $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST').'/'.$url->subdomain->name;
                  							} else {
                  							   $shrt_url = config('settings.SECURE_PROTOCOL').config('settings.APP_REDIRECT_HOST');
                  							}
                  							@endphp
          			              	<div class="row">
          			                  	<div class="col-md-2 col-sm-2"><strong>Group:</strong></div>
          			                  	<div class="col-md-10 col-sm-10">
          			                      	<span class="redirection-link-box">
          			                          	<a id="copylink">{{$shrt_url}}/{{$url->shorten_suffix}}</a>
          			                          	<a id="clipboard" class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#copylink" title="Copy shorten URL"><i class="fa fa-copy"></i></a>
          			                      	</span>
          			                  	</div>
          			              	</div>
              				          <div class="row">
                                    <div class="col-md-2 col-sm-2">
                                        <strong>
                                            Group Name
                                        </strong>
                                    </div>
                                    <div class="col-md-10 col-sm-10">
                                        {{$url->title}}
                                    </div>
                                    <div class="col-md-2">
                                        <strong>Tags of the group:</strong>
                                    </div>
                                    <div class="col-md-10">
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
                                      {{$redirecting_time/1000}} Seconds
                                    </div>
                                    <div class="col-md-2">
                                        <strong>Redirecting text:</strong>
                                    </div>
                                    <div class="col-md-10">
                                        <span style="display: inline;">{{$redirecting_text}}</span>
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
                                                <div class="prev-url"><a href="{{$shrt_url}}"></a></div>
                                                <div class="prev-title">
                                                    @if($url->og_title)
                                                        {{$url->og_title}}
                                                    @else
                                                        <strong></strong>
                                                    @endif
                                                </div>
                                                <div class="prev-description">{{$url->og_description}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-condensed show-info-tab">
                                                <thead>
                                                  <tr>
                                                      <th>#</th>
                                                      <th>Short Link</th>
                                                      <th>Long Link</th>
                                                      <th>Count</th>
                                                      <th>Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($sublink)>0)
                                                        @foreach($sublink as $allSublinks)
                                                            <tr>
                                                                <td></td>
                                                                <td><a href="{{$shrt_url}}/{{$allSublinks->shorten_suffix}}">{{$shrt_url}}/{{$allSublinks->shorten_suffix}}</a></td>
                                                                <td>{{$allSublinks->protocol}}://{{$allSublinks->actual_url}}</td>
                                                                <td>{{$allSublinks->count}}</td>
                                                                <td> <a class="btn-primary btn-xs" title="Link Info" href="{{route('getLinkPreview',[$allSublinks->id])}}" terget="_blank"><i class="fa fa-info"></i></a></td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            No Group Link Available For This Group.
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                          
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
