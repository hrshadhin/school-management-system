<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>{{Session::get('inNameShort')}} | School Manage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- The styles -->
    <link id="bs-css" href="<?php echo url(); ?>/css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?php echo url(); ?>/css/charisma-app.css" rel="stylesheet">
    <link href='<?php echo url(); ?>/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='<?php echo url(); ?>/bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>

    <link href='  <?php echo url(); ?>/bower_components/datatables/media/css/jquery.dataTables.css' rel='stylesheet'>

    <link href='<?php echo url(); ?>/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>

    <link href='<?php echo url(); ?>/css/jquery.noty.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/elfinder.min.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/uploadify.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/animate.min.css' rel='stylesheet'>
    <link href='<?php echo url(); ?>/css/app.css' rel='stylesheet'>

    @yield("style")
    <style media="screen">
   body {
       color: #154d88;
       background: rgba(233, 237, 241, 0.27);
       font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
       font-size: 13px;
       font-weight: 400;
       line-height: 1.471;
   }
   </style>
    <!-- jQuery -->
    <script src="<?php echo url(); ?>/bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <script>
      var hash = '{{Session::get('user_session_sha1')}}';
    </script>

</head>

<body>
<!-- topbar starts -->
<div class="navbar navbar-default" role="navigation">

    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <span class="iname">{{Session::get('inName')}}</span>

        <!-- user dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> {{Session::get('name')}}</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="/settings"><i class="glyphicon glyphicon-user"></i> Profile</a></li>
                <li class="divider"></li>
                <li><a href="/users/logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
            </ul>
        </div>
        <!-- Addmission dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                <i class="glyphicon glyphicon-th-large"></i><span class=""> Admission</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="/applicants"><i class="glyphicon glyphicon-th-list"></i> Applicant List</a></li>
                <li class="divider"></li>
                <li><a href="/regonline" target="_blank"><i class="glyphicon glyphicon-list-alt"></i> Online Registration</a></li>
                <li><a href="/admitcard" target="_blank"><i class="glyphicon glyphicon-print"></i> Print  Admitcard</a></li>





            </ul>
        </div>
        <!-- admission dropdown ends -->



        <!-- Library dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                <i class="glyphicon glyphicon-book"></i><span class=""> Library</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">

                <li><a href="/library/search"><i class="glyphicon glyphicon-search"></i> Book Search</a></li>
                <li><a href="/library/issuebook"><i class="glyphicon glyphicon-pencil"></i> Borrow Book</a></li>
                <li><a href="/library/issuebookview"><i class="glyphicon glyphicon-list"></i> Borrowd Book List</a></li>
                <li class="divider"></li>
                    <li><a href="/library/view-show"><i class="glyphicon glyphicon-list"></i> Book List</a></li>
                    <li><a href="/library/addbook"><i class="glyphicon glyphicon-pencil"></i> Book Entry</a></li>
                    <li><a href="/library/reports"><i class="glyphicon glyphicon-print"></i> Reports</a></li>
                    <li><a href="/library/reports/fine"><i class="glyphicon glyphicon-print"></i> Monthly Fine Reports</a></li>


            </ul>
        </div>
        <!-- Library dropdown ends -->
        <!-- Dormitory dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                <i class="glyphicon glyphicon-home"></i><span class=""> Dormitory</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">

                <li><a href="/dormitory"><i class="glyphicon glyphicon-home"></i> Dormitory</a></li>
                <li><a href="/dormitory/assignstd"><i class="glyphicon glyphicon-plus"></i> Assign Student</a></li>
                <li><a href="/dormitory/assignstd/list"><i class="glyphicon glyphicon-user"></i> Student List</a></li>
                <li class="divider"></li>
                    <li><a href="/dormitory/fee"><i class="glyphicon glyphicon-list"></i> Fee Collection</a></li>
                    <li><a href="/dormitory/report/std"><i class="glyphicon glyphicon-print"></i> Dormitory Report</a></li>
                    <li><a href="/dormitory/report/fee"><i class="glyphicon glyphicon-print"></i> Fee Reports</a></li>

            </ul>
        </div>
        <!-- Dormitory dropdown ends -->
        <!-- fees dropdown starts-->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                <i class="glyphicon glyphicon-list-alt"></i><span class=""> Fees</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="/fees/view"><i class="glyphicon glyphicon-search"></i> Student Fees</a></li>
                <li><a href="/fee/collection"><i class="glyphicon glyphicon-pencil"></i> Fees Collection</a></li>

                <li class="divider"></li>
                <li><a href="/fees/list"><i class="glyphicon glyphicon-list"></i> Fees List</a></li>
                <li><a href="/fees/setup"><i class="glyphicon glyphicon-cog"></i> Fees Setup</a></li>
                <li class="divider"></li>
                <li><a href="/fees/report"><i class="glyphicon glyphicon-print"></i> Fee Collection Report</a></li>

            </ul>
        </div>
        <!-- fees dropdown ends -->
      <!-- teacher dropdown starts-->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                <i class="glyphicon glyphicon-user"></i><span class=""> Employee</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="/teacher/create"><i class="glyphicon glyphicon-plus"></i> Add New</a></li>
                <li><a href="/teacher/list"><i class="glyphicon glyphicon-list-alt"></i> List</a></li>
                <li class="divider"></li>
                <li><a href="/leaves/create"><i class="glyphicon glyphicon-plus"></i> Add New Leave</a></li>
                <li><a href="/leaves"><i class="glyphicon glyphicon-list-alt"></i> Leave List</a></li>
                <li class="divider"></li>
                <li><a href="/workoutside/create"><i class="glyphicon glyphicon-plus"></i> Add New Work Outside</a></li>
                <li><a href="/workoutside"><i class="glyphicon glyphicon-list-alt"></i> Work Outside List</a></li>
                <li class="divider"></li>
                {{--<li><a href="/teacher-attendance/create"><i class="glyphicon glyphicon-plus"></i> Add Attendance</a></li>--}}
                <li><a href="/teacher-attendance/list"><i class="glyphicon glyphicon-list-alt"></i> Attendance List</a></li>
                <li><a href="/teacher-attendance/absenteeism-report"><i class="glyphicon glyphicon-print"></i> Absenteeism Report</a></li>
                <li><a href="/teacher-attendance/monthly-report"><i class="glyphicon glyphicon-print"></i> Monthly Attendance Report</a></li>
                <li><a href="/teacher-attendance/monthly-report-2"><i class="glyphicon glyphicon-print"></i> Monthly Attendance Report Two</a></li>

            </ul>
        </div>
        <!-- teacher dropdown ends -->

    </div>
</div>
<!-- topbar ends -->
<div class="ch-container">
    <div class="row">

        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Main</li>
                        <li><a class="ajax-link" href="/dashboard"><i class="glyphicon glyphicon-th-large"></i><span> Dashboard</span></a>
                        </li>

                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-home"></i><span> Class</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/class/create">Add New</a></li>
                                <li><a href="/class/list">Class List</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-book"></i><span> Subject</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/subject/create">Add New</a></li>
                                <li><a href="/subject/list">Subject List</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-user"></i><span> Student</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/student/create">Add New</a></li>
                                <li><a href="/student/list">Student List</a></li>

                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-pencil"></i><span> Attendance</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/attendance/create-file">Add from file</a></li>
                                <li><a href="/attendance/create">Add</a></li>
                                <li><a href="/attendance/list">View</a></li>


                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-list-alt"></i><span> Mark Manage</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/mark/create">Add New</a></li>
                                <li><a href="/mark/list">Marks List</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon  glyphicon glyphicon-list"></i><span> Result</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/result/generate">Generate</a></li>
                                <li><a href="/result/search">Search</a></li>
                                <li><a href="/results">Search Public</a></li>

                            </ul>
                        </li>
                        <li class="">
                            <a href="/promotion"><i class="glyphicon glyphicon-arrow-up"></i><span> Promotion</span></a>

                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon  glyphicon glyphicon-list-alt"></i><span> Accounting</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/accounting/sectors">Sectors</a></li>
                                <li><a href="/accounting/income">Add Income</a></li>
                                <li><a href="/accounting/incomelist">View Income</a></li>
                                <li><a href="/accounting/expence">Add Expence</a></li>
                                <li><a href="/accounting/expencelist">View Expence</a></li>

                            </ul>
                        </li>
                       <li class="accordion">

                          <a href="#"><i class="glyphicon glyphicon-envelope"></i><span> SMS</span></a>
                          <ul class="nav nav-pills nav-stacked">
                              <li><a href="/sms">SMS Formats</a></li>
                              <li><a href="/sms-bulk">Send Bulk SMS</a></li>
                              <li><a href="/smslog">SMS Log</a></li>

                          </ul>
                      </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-print"></i><span> Reports</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/gradesheet">Marksheet</a></li>
                                <li><a href="/attendance/report">Attendance</a></li>
                                <li><a href="/attendance/monthly-report">Monthly Attendance</a></li>
                                <li><a href="/tabulation">Tabulationsheet</a></li>
                                <li><a href="/accounting/report">Account By Type</a></li>
                                <li><a href="/accounting/reportsum">Account Balance</a></li>
                                 <li><a href="/barcode">Barcode Generate</a></li>


                            </ul>
                        </li>
                        @if (Session::get('userRole')=="Admin")
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-cog"></i><span> Settings</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/gpa">GPA Ruels</a></li>

                                <li><a href="/users">Users</a></li>
                                <li><a href="/holidays">Holidays</a></li>
                                <li><a href="/class-off">Class Off Days</a></li>
                                <li><a href="/institute">Institute</a></li>

                            </ul>
                        </li>
                          @endif
                    </ul>

                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            @if (isset($successmsg))
                <div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <strong>{{ $success }}.</strong>
                </div>
            @endif
            @if (isset($errormsg))
                <div class="alert alert-danger">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <strong>{{ $error }}.</strong>
                </div>
            @endif


            @yield('content')




            <!-- content ends -->
        </div><!--/#content.col-md-0-->
    </div><!--/fluid-row-->
    <div class="row">
        <div class="col-md-9 col-lg-9 col-xs-9 hidden-xs">



        </div>

    </div>

@include('layouts.footer')

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="<?php echo url(); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="<?php echo url(); ?>/js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='<?php echo url(); ?>/bower_components/moment/min/moment.min.js'></script>
<script src='<?php echo url(); ?>/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?php echo url(); ?>/bower_components/datatables/media/js/jquery.dataTables.js'></script>

<!-- select or dropdown enhancer -->
<script src="<?php echo url(); ?>/bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo url(); ?>/bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="<?php echo url(); ?>/js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="<?php echo url(); ?>/bower_components/responsive-tables/responsive-tables.js"></script>

<!-- star rating plugin -->
<script src="<?php echo url(); ?>/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo url(); ?>/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="<?php echo url(); ?>/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->

<script src="<?php echo url(); ?>/js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo url(); ?>/js/charisma.js"></script>

@yield('script')
</body>
</html>
