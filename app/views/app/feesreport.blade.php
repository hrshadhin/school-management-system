@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

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

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Fee Collection Report</h2>

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


                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="dob">From Date</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text" id="fdate"  class="form-control datepicker" name="sDate"   data-date-format="yyyy-mm-dd">
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="dob">To Date</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text" id="tdate" class="form-control datepicker" name="eDate"   data-date-format="yyyy-mm-dd">
                                        </div>


                                    </div>
                                </div>




                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary pull-right" id="btnPrint"><i class="glyphicon glyphicon-print"></i> Print</button>

                            </div>
                        </div>




                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>


    <script type="text/javascript">
        $( document ).ready(function() {
            $(".datepicker").datepicker( {
                autoclose:true,
                todayHighlight: true
            });

            $( "#btnPrint" ).click(function() {
                var fdate = $('#fdate').val();
                var tdate =  $('#tdate').val();

                if(fdate!="" && tdate !="") {
                    var getUrl = window.location;
                    var baseUrl = getUrl .protocol + "//" + getUrl.host;
                    var url =baseUrl+"/fees/report/"+fdate+"/"+tdate;

                    var win = window.open(url, '_blank');
                   win.focus();
                }
                else
                {
                    alert('Fill up inputs feilds correclty!!!');
                }
            });

        });

    </script>
@stop
