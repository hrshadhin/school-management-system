<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">

<head>
	<title>{{$siteInfo['short_name']}} | @yield('pageTitle')</title>
	<meta charset="utf-8">
	<meta name="description" content="{{$siteInfo['name']}}">
    <meta name="keywords" content="school,college,management,result,exam,attendace,hostel,admission,events">
    <meta name="author" content="H.R.Shadhin">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<!-- style -->
	<link rel="shortcut icon" href="@if($siteInfo['favicon']){{asset('storage/site/'.$siteInfo['favicon'])}} @else{{ asset('images/favicon.png') }}@endif">
   <link rel="stylesheet" href="{{ asset(mix('/css/libs.css', 'frontend')) }}">
    <!--styles -->

    <!-- Child Page css goes here  -->
    @yield("extraStyle")
     <!-- Child Page css -->	
</head>

<body>
    <!-- page header -->
    @include('frontend.partial.header')
    <!-- / page header -->
    
	<!-- BEGIN CHILD PAGE-->
	@yield('pageContent')
	<!-- END CHILD PAGE-->	


	<!-- footer -->
    @include('frontend.partial.footer')
	<!-- / footer -->

    <script src="{{ asset(mix('/js/jquery.min.js', 'frontend')) }}"></script>
    <script src="{{ asset(mix('/js/libs.js', 'frontend')) }}"></script>

    <!-- Extra js from child page -->
    @yield("extraScript")
    <!-- END JAVASCRIPT -->

</body>
</html>