<div class="col-md-8">
	<div class="top-menu">
		<div class="mobile-menu">
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
                @if(!\Auth::check())
            	<li class="login"><a href="#" data-toggle="modal" data-target="#login">login</a></li>
            	<li class="signup"><a href="#" data-toggle="modal" data-target="#signup" >signup</a></li>
                @else
                    <li><a href="/app/user/dashboard">My Dashboard</a></li>
                @endif
            </ul>
        </div>
        <div class="desktop-menu">
            <ul>
            	<li><a href="/about">about</a></li>
            	<li><a href="/features">features</a></li>
            	<li><a href="/pricing">pricing</a></li>
            	<li><a href="/blog">blog</a></li>
                @if(!\Auth::check())
            	<li class="login"><a href="#" data-toggle="modal" data-target="#login">login</a></li>
            	<li class="signup"><a href="#" data-toggle="modal" data-target="#signup">signup</a></li>
                @else
                    <li><a href="/app/user/dashboard">My Dashboard</a></li>
                @endif
            </ul>
        </div>
	</div>
</div>