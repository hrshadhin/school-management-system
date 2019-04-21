<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Dashboard @endsection
<!-- End block -->

@section('extraStyle')
    <link type="text/css" rel="stylesheet" href="{{ asset(mix('/css/site-dashboard.css')) }}" />
@endsection

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Subscribers</span>
                        <span class="info-box-number">{{$subscribers}}<small></small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-bullhorn"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Events</span>
                        <span class="info-box-number">{{$events}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-camera"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Photograph</span>
                        <span class="info-box-number">{{$photos}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Visitors</span>
                        <span class="info-box-number totalVisitors"></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
                <!-- MAP & BOX PANE -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Google Analytics Report</h3>
                        <div class="box-tools pull-right">
                            <div id="active-users-container"></div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($googleToken['token'])
                        <div class="row">
                            <div class="col-md-6">
                                <div class="Chartjs">
                                    <header class="Titles">
                                        <h1 class="Titles-main">This Week vs Last Week</h1>
                                        <div class="Titles-sub">By sessions</div>
                                    </header>
                                    <figure class="Chartjs-figure" id="chart-1-container"></figure>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="Chartjs">
                                    <header class="Titles">
                                        <h1 class="Titles-main">This Year vs Last Year</h1>
                                        <div class="Titles-sub">By users</div>
                                    </header>
                                    <figure class="Chartjs-figure" id="chart-2-container"></figure>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="Chartjs">
                                    <header class="Titles">
                                        <h1 class="Titles-main">Top Browsers</h1>
                                        <div class="Titles-sub">By pageview</div>
                                    </header>
                                    <figure class="Chartjs-figure" id="chart-3-container"></figure>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="Chartjs">
                                    <header class="Titles">
                                        <h1 class="Titles-main">Top Countries This Year</h1>
                                        <div class="Titles-sub">By user</div>
                                    </header>
                                    <figure class="Chartjs-figure" id="chart-4-container"></figure>
                                </div>
                            </div>
                        </div>
                            @else
                            <div class="alert alert-danger keepIt">
                                <h3>{{$googleToken['message']}}</h3>
                            </div>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@if($googleToken['token'])
@section('extraScript')
    <script>
        (function(w,d,s,g,js,fs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
            js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
        }(window,document,'script'));
    </script>
    <script src="{{asset(mix('js/site-dashboard.js'))}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            window.gid = '{{$gaId}}';
            window.gtok = "{{$googleToken['token']}}";
            GoogleAnaylytics.init();
        });

    </script>
@endsection
@endif
<!-- END PAGE JS-->
