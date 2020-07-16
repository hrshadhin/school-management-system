<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="CloudSchool">
    <meta name="keywords" content="school,college,management,result,exam,attendance,account,hrm,library,payroll,hostel,admission,events">
    <meta name="author" content="CloudSchool">
    <title>@yield('pageTitle')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
    <style>
        .content-wrapper, .main-footer {
             margin-left: 0px;
        }
    </style>

</head>

<body class="hold-transition hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- BEGIN CHILD PAGE-->
    @yield('pageContent')
    <!-- END CHILD PAGE-->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
</body>

</html>