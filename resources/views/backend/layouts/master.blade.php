<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@if(isset($appSettings['institute_settings']['name'])){{$appSettings['institute_settings']['name']}}@else CloudSchool @endif">
    <meta name="keywords" content="school,college,management,result,exam,attendance,account,hrm,library,payroll,hostel,admission,events">
    <meta name="author" content="CloudSchool">
    <title>@if(isset($appSettings['institute_settings']['short_name'])){{$appSettings['institute_settings']['short_name']}}@else CloudSchool @endif | @yield('pageTitle')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon png -->
    <link rel="shortcut icon" href="@if(isset($appSettings['institute_settings']['favicon'])){{asset('storage/logo/'.$appSettings['institute_settings']['favicon'])}} @else{{ asset('images/favicon.png') }}@endif">
    <!-- Pace loading -->
    <script src="{{ asset(mix('/js/pace.js')) }}"></script>
    <link href="{{ asset(mix('/css/pace.css')) }}" rel="stylesheet" type="text/css">

    <!-- vendor libraries CSS -->
    <link href="{{ asset(mix('/css/vendor.css')) }}" rel="stylesheet" type="text/css">
    <!-- theme CSS -->
    <link href="{{ asset(mix('/css/theme.css')) }}" rel="stylesheet" type="text/css">
    <!-- app CSS -->
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet" type="text/css">

    <!-- print CSS -->
    <link href="{{ asset(mix('/css/print.css')) }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var hash = '{{session('user_session_sha1')}}';
        var institute_category = '{{$institute_category}}';
    </script>
   <!-- Child Page css goes here  -->
@yield("extraStyle")
<!-- Child Page css -->
</head>

<body class="hold-transition skin-blue sidebar-mini fixed @yield('bodyCssClass')">
{{--<div class="overlay-loader">--}}
{{--<div class="loader" ></div>--}}
{{--</div>--}}
<div class="ajax-loader">
    <img class="loader2" src="{{ asset('/images/loader.svg') }}" alt="">
</div>

<!-- Site wrapper -->
<div class="wrapper">
    <!-- page header -->
@include('backend.partial.header')
<!-- / page header -->

    <!-- page aside left side bar -->
@include('backend.partial.leftsidebar')
<!-- / page aside left side bar -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Message -->
        @if (Session::has('success') || Session::has('error') || Session::has('warning'))
            <div class="no-print alert custom_alert @if (Session::has('success')) alert-success @elseif(Session::has('error')) alert-danger @else alert-warning @endif alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                @if (Session::has('success'))
                    <h5><i class="icon fa fa-check"></i>{!! Session::get('success') !!} </h5>
                @elseif(Session::has('error'))
                    <h5><i class="icon fa fa-ban"></i>{!! Session::get('error') !!} </h5>
                @else
                    <h5><i class="icon fa fa-warning"></i>{!!  Session::get('warning') !!} </h5>
                    @endif
                    </h5>
            </div>
        @endif
        @if (Session::has('message'))
            <div class="alert  alert-success keepIt no-print">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5 style="font-weight: bold; font-size: large;"><i class="icon fa fa-check"></i>{!! Session::get('message') !!} </h5>
            </div>
    @endif
    <!-- ./Message -->
        <!-- BEGIN CHILD PAGE-->
    @yield('pageContent')
    <!-- END CHILD PAGE-->
    </div>
    <!-- /.content-wrapper -->

    <!-- footer -->
@include('backend.partial.footer')
<!-- / footer -->

    <!-- page aside right side bar -->
@include('backend.partial.rightsidebar')
<!-- / page aside right side bar -->

</div>
<!-- ./wrapper -->
<!-- webpack menifest js -->
<script src="{{ asset(mix('/js/manifest.js')) }}"></script>
<!-- vendor libaries js -->
<script src="{{ asset(mix('/js/vendor.js')) }}"></script>
<!-- theme js -->
<script src="{{ asset(mix('/js/theme.js')) }}"></script>
<!-- app js -->
<script src="{{ asset(mix('/js/app.js')) }}"></script>

<!-- Extra js from child page -->
@yield("extraScript")
<!-- END JAVASCRIPT -->
</body>

</html>