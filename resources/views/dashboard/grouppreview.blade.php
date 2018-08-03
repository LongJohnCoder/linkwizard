@extends('layout/layout')
@section('content')
	<div class="main-dashboard-body">
  		<div class="main-content">
    		<div class="container">
      			<div class="row">
        			<div class="col-md-12 col-sm-12">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#link-details">Link Details</a></li>
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
                                </tr>
                              </thead>
                              <tbody>
                               
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
