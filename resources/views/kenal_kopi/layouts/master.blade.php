<?php
// session_start();
// include 'dbconnect.php';

?>

<!DOCTYPE html>
<html>
<head>
<title>Kenal Kopi</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Falenda Flora, Ruben Agung Santoso" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="{{asset('kenal_kopi/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
<link href="{{asset('kenal_kopi/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome icons -->
<link href="{{asset('kenal_kopi/css/font-awesome.css')}}" rel="stylesheet">
<!-- //font-awesome icons -->
<!-- js -->
<script src="{{asset('kenal_kopi/js/jquery-1.11.1.min.js')}}"></script>
<!-- //js -->
<link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="{{asset('kenal_kopi/js/move-top.js')}}'"></script>
<script type="text/javascript" src="{{asset('kenal_kopi/js/easing.js')}}'"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>

</head>

<body>
					<!-- top-header-->
					@includeIf('kenal_kopi.layouts.header')
					<!-- //top-header-->
					<!-- top banner-->
					@includeIf('kenal_kopi.layouts.banner')
					<!-- //top banner-->
					<!-- top-brands -->
					<!-- HOME = carts -->
					@yield('content')
					<!-- //top-brands -->
					<!-- footer -->
	        @includeIf('kenal_kopi.layouts.footer')
					<!-- //footer -->



<!-- Bootstrap Core JavaScript -->
<script src="{{asset('kenal_kopi/js/bootstrap.min.js')}}"></script>

<!-- top-header and slider -->
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {

				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 4000,
				easingType: 'linear'
				};

			$().UItoTop({ easingType: 'easeOutQuart' });

			});
	</script>
<!-- //here ends scrolling icon -->

<!-- main slider-banner -->
<script src="{{asset('kenal_kopi/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('kenal_kopi/js/skdslider.min.js')}}"></script>
<link href="{{asset('kenal_kopi/css/skdslider.css')}}" rel="stylesheet">
<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});

			jQuery('#responsive').change(function(){
			  $('#responsive_wrapper').width(jQuery(this).val());
			});

		});
</script>
<!-- //main slider-banner -->
    @stack('scripts')

</body>
</html>
