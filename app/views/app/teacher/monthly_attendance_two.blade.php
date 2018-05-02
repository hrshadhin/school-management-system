@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
    <style>
        #attendanceList th,#attendanceList td{
            text-align: center;
        }

        .badge-warning {
            background-color: #f89406;
        }
        .badge-warning:hover {
            background-color: #c67605;
        }
        .badge-success {
            background-color: #468847;
        }
        .badge-success:hover {
            background-color: #356635;
        }

    </style>
@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
        </div>
    @endif
    @if (Session::get('noresult'))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>{{ Session::get('noresult')}}</strong>

        </div>
    @endif
    @if (isset($noResult))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>{{$noResult['noresult']}}</strong>

        </div>
    @endif



    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Monthly Attendance Report Two</h2>

                </div>
                <div class="box-content">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form role="form" action="/teacher-attendance/monthly-report-2" method="get" enctype="multipart/form-data">
                        <input type="hidden" name="print_view" value="0">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label for="dob">Month <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text" class="form-control datepicker" name="yearMonth" required  data-date-format="yyyy-mm" value="{{$yearMonth}}">
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button class="btn btn-primary" id="btnPrint"  type="button"><i class="glyphicon glyphicon-print"></i> Print List</button>

                                        </div>
                                   </div>
                                </div>

                            </div>
                        </div>
                    </form>
                        <br>



                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">


        $( document ).ready(function() {

            $(".datepicker").datepicker({
                autoclose:true,
                format:"yyyy-mm",
                changeMonth: true,
                changeYear: true,
                viewMode: "months",
                minViewMode: "months",

            });

            $("#btnPrint" ).click(function() {
                $('input[name="print_view"]').val(1);
                var qstring = $( "form" ).serialize();
                var url =  window.location.origin+"/teacher-attendance/monthly-report-2?"+qstring;
                window.open(url, '_blank');
                window.focus();
            });


        });

    </script>
@stop
