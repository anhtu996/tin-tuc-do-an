<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="News - Clean HTML5 and CSS3 responsive template">
<meta name="author" content="LuongTu">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>@yield('title')</title>
<base href="{{asset('')}}">

<link rel="shortcut icon" href="client_css/img/sms-4.ico" />

<!-- STYLES -->
<link rel="stylesheet" type="text/css" href="client_css/css/superfish.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="client_css/css/fontello/fontello.css" />
<link rel="stylesheet" type="text/css" href="client_css/css/flexslider.css" media="screen" />
<link rel="stylesheet" type="text/css" href="client_css/css/ui.css" />
<link rel="stylesheet" type="text/css" href="client_css/css/base.css" />
<link rel="stylesheet" type="text/css" href="client_css/css/style.css" />
<link rel="stylesheet" type="text/css" href="client_css/css/960.css" />
<link rel="stylesheet" type="text/css" href="client_css/css/devices/1000.css" media="only screen and (min-width: 768px) and (max-width: 1000px)" />
<link rel="stylesheet" type="text/css" href="client_css/css/devices/767.css" media="only screen and (min-width: 480px) and (max-width: 767px)" />
<link rel="stylesheet" type="text/css" href="client_css/css/devices/479.css" media="only screen and (min-width: 200px) and (max-width: 479px)" />
<link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
<!--[if lt IE 9]> <script type="text/javascript" src="client_css/js/customM.js"></script> <![endif]-->


</head>

<body>

<!-- Body Wrapper -->
<div class="body-wrapper">
	<div class="controller">
    <div class="controller2">

        <!-- Header -->
        @include('client.layout.header')
        <!-- /Header -->
        
        <!-- Content -->
        @yield('content')
        <!-- / Content -->
        
        <!-- Footer -->
        @include('client.layout.footer')
        <!-- / Footer -->
    </div>
	</div>
</div>
<!-- / Body Wrapper -->


<!-- SCRIPTS -->
<script type="text/javascript" src="client_css/js/jquery.js"></script>
<script type="text/javascript" src="client_css/js/easing.min.js"></script>
<script type="text/javascript" src="client_css/js/1.8.2.min.js"></script>
<script type="text/javascript" src="client_css/js/ui.js"></script>
<script type="text/javascript" src="client_css/js/carouFredSel.js"></script>
<script type="text/javascript" src="client_css/js/superfish.js"></script>
<script type="text/javascript" src="client_css/js/customM.js"></script>
<script type="text/javascript" src="client_css/js/flexslider-min.js"></script>
<script type="text/javascript" src="client_css/js/jtwt.min.js"></script>
<script type="text/javascript" src="client_css/js/jflickrfeed.min.js"></script>
<script type="text/javascript" src="client_css/js/mobilemenu.js"></script>

<!--[if lt IE 9]> <script type="text/javascript" src="client_css/js/html5.js"></script> <![endif]-->
<script type="text/javascript" src="client_css/js/mypassion.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ad1fd7ead5287f7"></script>

</body>
</html>
