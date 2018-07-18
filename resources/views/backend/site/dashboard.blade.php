<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Dashboard @endsection
<!-- End block -->

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
                <span class="info-box-number">2,000</span>
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
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                 <div style="min-height:300px;">
                     <h4 class="text-info text-center">Analytics Chart goes here</h4>
                 </div>
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
@section('extraScript')
    <script type="text/javascript">
        $(document).ready(function () {

        });

    </script>
@endsection
<!-- END PAGE JS-->
