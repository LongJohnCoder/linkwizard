
<header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="logo">
					<img src="{{url('/')}}/public/images/logo.png" class="img-responsive">
				</div>
			</div>

			<div class="col-md-8">
				<div class="top-right">
					@if(count($limit) > 0)
					<div class="createlink openpop">
						<a href="javascript:void(0)" id="basic">Create tier5 link</a>
					</div>
					@endif
					@if ($subscription_status != null)
						 @if(count($limit) > 0)
						 	<div class="createlink openpop">
						 		<a href="javascript:void(0)" id="advanced" style="background-color:red">Create Custom link</a>
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
	                	<!-- <a href="#" id="cross1" class="closebtn"><i class="fa fa-times" style="color:white"></i></a> -->
		                <div class="overlay-content">
	                        <div class="col-md-12 col-sm-12">
	                            <label for="givenUrl" style="color:white">Paste An Actual URL Here</label>
	                            <input id="givenUrl" class="myInput form-control" type="text" name="" placeholder="Paste Your URL Here">
	                            <button id="swalbtn" type="submit" class="btn btn-primary btn-sm">
	                                Shorten Url
	                            </button>
	                        </div>
		                </div>
	                </div>

	                <div id="myNav2" class="userdetails">
		                <!-- <a href="#" id="cross2" class="closebtn"><i class="fa fa-times" style="color:white"></i></a> -->
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
	                            <button id="swalbtn1" type="submit" class="btn btn-primary btn-sm">
	                                Shorten Url
	                            </button>
	                            <br>
	                            <span id="err_cust" style="color:red; display:none;" >This URL is taken. Please try with a different name</span>
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