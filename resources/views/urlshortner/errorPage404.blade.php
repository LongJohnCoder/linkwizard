
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow" />
	<meta name="viewport" content="width=device-width,maximum-scale=1,user-scalable=no,minimal-ui">
	<title>404 Not Found</title>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800&amp;subset=latin,latin-ext">
	<link rel="stylesheet" type="text/css" media="all" href="https://cdn.travel.sygic.com/7272dd83d529/css/__v2/error.css">
</head>
<body>
	<script type="text/javascript">
		/* <![CDATA[ */
		var _gaq=_gaq||[];
		_gaq.push(
			['_setAccount',"UA-48316513-1"]
				,['_trackPageview',"http-error\/404\/?page=https:\/\/travel.sygic.com\/404&referer=http:\/\/www.bypeople.com\/atacama-404-page\/"]
		);

		(function(){
			var ga=document.createElement('script');
			ga.type='text/javascript';
			ga.async=true;
			ga.src=('https:'==document.location.protocol?'https://ssl':'http://www')+'.google-analytics.com/ga.js';
			var s=document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga,s);
		})();
		/* ]]> */
	</script>


	<div class="stars"></div>

	<div class="sun-moon">
		<div class="sun"></div>
		<div class="moon"></div>
	</div>

	<div id="js-hills" class="background hills"></div>
	<div id="js-country" class="background country"></div>
	<div id="js-foreground" class="background foreground"></div>

	<div class="error-content">
			Sorry, that Url does not exists!<br>
			
	</div>

	<a href="{{route('getIndex')}}" class="button">Go home</a>

		<div class="code">
			<span>4</span>
			<span>0</span>
			<span>4</span>
		</div>

<!--
	<script type="text/javascript">
	var mouse = { x: 0, y: 0 },
		gyro = { x: 0, y: 0 },
		updateGyro = false,
		updateMouse = false,
		customEvent = null,
		hills = document.getElementById('js-hills'),
		country = document.getElementById('js-country'),
		foreground = document.getElementById('js-foreground'),
		windowWidth = window.innerWidth,
		isiPad = navigator.userAgent.match(/iPad/i) != null;

	if (windowWidth > 1024) {
		document.addEventListener('mousemove', function(e){
			updateMouse = true;
			customEvent = e;
		}, false);
	}

	if (isiPad) {
		window.addEventListener('deviceorientation', function(e){
			updateGyro = true;
			customEvent = e;
		}, false);
	}

	setInterval(function(){
		if (updateGyro) {
			updateGyro = false;
			updateOnGyroscope(customEvent);
		}
		if (updateMouse) {
			updateMouse = false;
			updateOnMouse(customEvent);
		}
	}, 50)

	function updateOnMouse(e) {
		mouse.x = (Math.round( 200 * (e.clientX || e.pageX) / window.innerWidth) - 100) / 100;
		mouse.y = (Math.round( 200 * (e.clientY || e.pageY) / window.innerHeight) - 100) / 100;
		hills.style.transform      = "translate3d(" + mouse.x * 10  + "px, " + mouse.y * 10  + "px, 0)";
		country.style.transform    = "translate3d(" + mouse.x * -5 + "px, " + mouse.y * -5 + "px, 0)";
		foreground.style.transform = "translate3d(" + mouse.x * -10  + "px, " + mouse.y * -10  + "px, 0)";
	}

	function updateOnGyroscope(e) {
		gyro.x = Math.round((e.beta % 90) * 10 / 9) / 100;
		gyro.y = Math.round((e.gamma % 90) * 10 / 9) / 100;
		hills.style.transform      = "translate3d(" + gyro.x * 20  + "px, " + gyro.y * 20  + "px, 0)";
		country.style.transform    = "translate3d(" + gyro.x * -10 + "px, " + gyro.y * -10 + "px, 0)";
		foreground.style.transform = "translate3d(" + gyro.x * -20 + "px, " + gyro.y * -20 + "px, 0)";
		hills.style.webkitTransform      = "translate3d(" + gyro.x * 20  + "px, " + gyro.y * 20  + "px, 0)";
		country.style.webkitTransform    = "translate3d(" + gyro.x * -10 + "px, " + gyro.y * -10 + "px, 0)";
		foreground.style.webkitTransform = "translate3d(" + gyro.x * -20 + "px, " + gyro.y * -20 + "px, 0)";
	}
	</script>
-->

	<!-- Server: 10.1.1.39 -->
</body>
<!-- #TB_MON#CHSET#7272dd83d529#AWSID#10.1.1.39#TB_MON# -->
</html>
