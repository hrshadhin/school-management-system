<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@if(isset($appSettings['institute_settings']['name'])){{$appSettings['institute_settings']['name']}}@else CloudSchool @endif">
    <meta name="keywords" content="school,college,management,result,exam,attendance,account,hrm,library,payroll,hostel,admission,events">
    <meta name="author" content="CloudSchool">
    <title>@if(isset($appSettings['institute_settings']['short_name'])){{$appSettings['institute_settings']['short_name']}} @else CloudSchool @endif | @yield('pageTitle')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon png -->
    <link rel="icon" href="@if(isset($appSettings['institute_settings']['favicon'])){{asset('storage/logo/'.$appSettings['institute_settings']['favicon'])}} @else{{ asset('images/favicon.png') }}@endif" type="image/png">
    <!-- Pace loading -->
    <script src="{{ asset(mix('/js/pace.js')) }}"></script>
    <link href="{{ asset(mix('/css/pace.css')) }}" rel="stylesheet" type="text/css">
    <!-- vendor libraries CSS -->
    <link href="{{ asset(mix('/css/vendor.css')) }}" rel="stylesheet" type="text/css">
    <!-- theme CSS -->
    <link href="{{ asset(mix('/css/theme.css')) }}" rel="stylesheet" type="text/css">
    <!-- app CSS -->
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Child Page css goes here  -->
    @yield("extraStyle")
    <!-- Child Page css -->	

</head>

<body class="hold-transition @yield('bodyCssClass')">
<div class="overlay-loader">
    <div class="loader" ></div>
</div>
    <!-- BEGIN CHILD PAGE-->
    @yield('pageContent')
	<!-- END CHILD PAGE-->	

    <!-- webpack menifest js -->
    <script src="{{ asset(mix('/js/manifest.js')) }}"></script>
     <!-- vendor libaries js -->
    <script src="{{ asset(mix('/js/vendor.js')) }}"></script>
     <!-- app js -->
    <script src="{{ asset(mix('/js/app.js')) }}"></script>

     <!-- Extra js from child page -->
     @yield("extraScript")
    <!-- END JAVASCRIPT -->
</body>

</html>