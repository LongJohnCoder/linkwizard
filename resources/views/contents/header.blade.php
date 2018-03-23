<header>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<div class="logo">
					 <a href="{{url('/')}}/about"><img src="{{config('settings.SITE_LOGO')}}" class="img-responsive"></a>
				</div>
			</div>

			<div class="col-md-8 col-sm-8">
				<div class="top-right">
					@if(count($limit) > 0)
					{{--
						<div class="createlink boder openpop">
							<a href="javascript:void(0)" id="basic">
								<!-- Create tier5 link --> +Add tier5 link</a>
						</div>
					--}}

					<div class="createlink boder openpop">
						<a href="{{route('createShortenedLink')}}">
							@if(config('settings.VIEW.SHORT_LINK') !== null)
						<!-- Create tier5 link --> +{{config('settings.VIEW.SHORT_LINK')}}</a>
							@else
								+Add short link
							@endif
					</div>

					@endif
					@if ($subscription_status != null)
						 @if(count($limit) > 0)
						 	{{--
								<div class="createlink openpop">
						 			<a href="javascript:void(0)" id="advanced"><!-- Create Custom link -->
						 				+Add Custom link
						 			</a>
						 		</div>
							--}}

							<div class="createlink openpop">
						 		<a href="{{route('createCustomLink')}}"><!-- Create Custom link -->
									@if(config('settings.VIEW.CUSTOM_LINK') !== null)
						 				+{{config('settings.VIEW.CUSTOM_LINK')}}
									@else
										+Add Custom link
									@endif
						 		</a>
						 	</div>

						 @endif
					@endif
					<div class="hamburg-menu">
	                  <a href="#" id="menu-icon" class="menu-icon">
	                    <div class="span bar top" style="background-color: #fff;"></div>
	                    <div class="span bar middle" style="background-color: #fff;"></div>
	                    <div class="span bar bottom" style="background-color: #fff;"></div>
	                  </a>
	                </div>
	                <div id="userdetails" class="userdetails">
	                	<div>
		                	<a href="{{ route('getLogout') }}" class="signout"><i class="fa fa-sign-out"></i> Sign out</a>
		                	<p style="color:white">{{ $user->name }}</p>
		                	<p style="color:white">{{ $user->email }}</p>
		                	@if ($subscription_status != 'tr5Advanced')
		                		<a href="{{ route('getSubscribe') }}" class="upgrade"><i class="fa fa-sign-out"></i> Upgrade</a>
		                	@endif
	                	</div>
	                </div>

	                <div id="myNav1" class="userdetails">
                    <div class="mainscrool">
	                	<!-- <a href="#" id="cross1" class="closebtn"><i class="fa fa-times" style="color:white"></i></a> -->
                        <div class="overlay-content">
	                        <div class="col-md-12 col-sm-12">
	                            <label for="givenUrl" style="color:white">Paste An Actual URL Here</label>
	                            <input id="givenUrl" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
															<br>
															<label for="addFbPixelid" style="color:white">Add facebook pixel</label>
															<input id="checkboxAddFbPixelid" type="checkbox" name="chk_fb_short" style="color: white">
															<input id="fbPixelid" class="myInput form-control" type="number" name="client_fb_pixel_id" placeholder="Paste Your Facebook-pixel-id Here" style="display : none">

															<br>
															<label for="addGlPixelid" style="color:white">Add google pixel</label>
															<input id="checkboxAddGlPixelid" type="checkbox" name="chk_gl_short" style="color: white">
															<input id="glPixelid" class="myInput form-control" type="number" name="client_gl_pixel_id" placeholder="Paste Your Google-pixel-id Here" style="display : none">

															<br>
															<label for="shortTags" style="color:white">Add tags</label>
															<input id="shortTagsEnable" type="checkbox" name="shortTagsEnable" style="color: white">
															<div id="shortTagsArea" style="display: none">
																<input id="shortTagsContentss" class="myInput form-control" data-role="tagsinput" type="text" name="shortTagsContents" placeholder="Mention tags for this link" >
															</div>

															<br>
																<label for="shortDescription" style="color:white">Add description</label>
																<input id="shortDescriptionEnable" type="checkbox" name="shortDescriptionEnable" style="color: white">

                                <textarea id="shortDescriptionContents" class="myInput form-control description" type="textarea" name="shortDescriptionContents" placeholder="Mention description for this link" style="display : none"></textarea>

																<button id="swalbtn" type="submit" class="btn btn-primary btn-sm">
		                                Shorten Url
		                            </button>
															<br>
	                        </div>
		                </div>
                  </div>
	                </div>

	                <div id="myNav2" class="userdetails">
		                <!-- <a href="#" id="cross2" class="closebtn"><i class="fa fa-times" style="color:white"></i></a> -->
                    <div class="mainscrool">
		                <div class="overlay-content">
	                        <div class="col-md-12 col-sm-12">
	                            <label for="givenActualUrl" style="color:white;">Paste An Actual URL Here</label>
	                            <input id="givenActualUrl" style="width:280px" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
	                            <br>
	                            <br>
	                            <label for="makeCustomUrl" style="color:white">Create Your Own Custom Link</label>
	                            <div class="input-group">
	                                <span class="input-group-addon">{{ env('APP_HOST') }}</span>
	                                <input id="makeCustomUrl" class="myInput form-control" type="text" name="" placeholder="e.g. MyLinK">
	                            </div>
															<br>

															<label for="checkboxAddFbPixelid1" style="color:white">Add facebook pixel</label>
															<input id="checkboxAddFbPixelid1" type="checkbox" name="chk_fb_custom" style="color: white">
															<input id="fbPixelid1" class="myInput form-control" type="number" placeholder="Paste Your Facebook-pixel-id Here" style="display : none">
															<br>
															<label for="addGlPixelid1" style="color:white">Add google pixel</label>
															<input id="checkboxAddGlPixelid1" type="checkbox" name="chk_gl_custom" style="color: white">
															<input id="glPixelid1" class="myInput form-control" type="number" name="client_gl_pixel_id1" placeholder="Paste Your Google-pixel-id Here" style="display : none">

															<br>
															<label for="customTags" style="color:white">Add tags</label>
															<input id="customTagsEnable" type="checkbox" name="customTagsEnable" style="color: white">
															<div id="customTagsArea" style="display: none">
																<input id="customTagsContents" class="myInput form-control" data-role="tagsinput" type="text" name="customTagsContents" placeholder="Mention tags for this link" style="display: none">
															</div>

															<br>
																<label for="customDescription" style="color:white">Add description</label>
																<input id="customDescriptionEnable" type="checkbox" name="customDescriptionEnable" style="color: white">
                                <textarea id="customDescriptionContents" class="myInput form-control description" type="textarea" name="customDescriptionContents" placeholder="Mention description for this link" style="display : none"></textarea>
		                            <button id="swalbtn1" type="submit" class="btn btn-primary btn-sm">
		                                Shorten Url
		                            </button>
	                            <br>
	                            <span id="err_cust" style="color:red; display:none;" >This URL is taken. Please try with a different name</span>
	                        </div>
		                </div>
                  </div>
		            </div>


		            <div class="top-menu dashboard-menu">
						<!-- <div class="mobile-menu">
							<div class="hamburg-menu">
				              <a href="#" class="menu-icon" style="display: block;">
				                <div class="span bar top" style="background-color: #fff;"></div>
				                <div class="span bar middle" style="background-color: #fff;"></div>
				                <div class="span bar bottom" style="background-color: #fff;"></div>
				              </a>
				            </div>
				            <ul>
				            	<li><a href="/about">about</a></li>
				            	<li><a href="/features">features</a></li>
				            	<li><a href="/pricing">pricing</a></li>
				            	<li><a href="/blog">blog</a></li>
				            	@if ($user->is_admin == 1)
		               				<li><a style="color:green" href="{{ route('getAdminDashboard') }}">ADMIN DASHBOARD</a></li>
                    			@endif
				            </ul>
				        </div> -->
				        <div class="desktop-menu">
				            <ul>
				            	<li><a href="/about">about</a></li>
				            	<li><a href="/features">features</a></li>
				            	<li><a href="/pricing">pricing</a></li>
				            	<li><a href="/blog">blog</a></li>
											<li><a href="{{route('getDashboard')}}">dashboard</a></li>
				            	@if ($user->is_admin == 1)
		               				<li><a style="color:green" href="{{ route('getAdminDashboard') }}">ADMIN DASHBOARD</a></li>
                    	@endif

				            </ul>
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
