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
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-orange-dark" href="#">
                        <div class="icon bg-orange-dark" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-student"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">{{$students}} </h3>
                            <p class="text-white">
                                Student </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-pink-light" href="#">
                        <div class="icon bg-pink-light" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-teacher"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                {{$teachers}}                  </h3>
                            <p class="text-white">
                                Teacher </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-teal-light" href="#">
                        <div class="icon bg-teal-light" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-subject"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                80                  </h3>
                            <p class="text-white">
                                Subject </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-purple-light" href="#">
                        <div class="icon bg-purple-light" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-subject"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                80                  </h3>
                            <p class="text-white">
                                Books </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
       <div class="row">
           <div class="col-md-12">
               <div class="box box-success">
                   <div class="box-header with-border x_title">
                       <h3>Accounting Report</h3>
                       <label class="total_bal">
                           Balance: 7022771.82
                       </label>

                   </div>
                   <!-- /.box-header -->
                   <div class="box-body">

                       <canvas id="accountChart" style="width: 821px; height: 136px;"></canvas>
                   </div>
                   <!-- /.box-body -->
               </div>
               <!-- /.box -->
           </div>
       </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-body" style="max-height: 342px;">
                        <canvas id="attendanceChart" style="width: 400px; height: 150px;"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>


    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script src="{{asset(mix('js/dashboard.js'))}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Dashboard.init();

        });

    </script>
@endsection
<!-- END PAGE JS-->
