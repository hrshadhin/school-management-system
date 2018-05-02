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
                    <h2><i class="glyphicon glyphicon-book"></i> Attendance List</h2>

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

                    <form role="form" action="/teacher-attendance/list" method="get" enctype="multipart/form-data">
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        <input type="hidden" name="print_view" value="0">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="gender">Search type</label>
                                        <div>
                                            <label style="display: inline;" for="t1">
                                                <input type="radio" id="t1" name="searchType" value="1" @if($searchType=="1") checked @endif> By Type
                                            </label>
                                            <label style="display: inline;" for="t2">
                                                <input type="radio" id="t2" name="searchType" value="2" @if($searchType=="2") checked @endif> By Employee
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div id="byType" class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="gender">Employee type</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <?php  $data=[
                                                '0'=>'All',
                                                'Teacher'=>'Teacher',
                                                'Staff'=>'Staff',
                                            ];?>
                                            {{ Form::select('egroup',$data,$egroup,['class'=>'form-control','required'=>'true'])}}

                                        </div>
                                    </div>
                                </div>
                                <div id="byEmployee" class="col-md-5" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label" for="class">Employee</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                                            {{ Form::select('teacher',$teachers,$regNo,['class'=>'form-control','id'=>'class',])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="dob">From Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text" class="form-control datepicker" name="dateFrom" required  data-date-format="yyyy/mm/dd" value="{{$dateFrom}}">
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="dob">To Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text"  class="form-control datepicker" name="dateTo" required  data-date-format="yyyy/mm/dd" value="{{$dateTo}}">
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button class="btn btn-primary" id="btnPrint"  type="button"><i class="glyphicon glyphicon-print"></i> Print List</button>
                                    &nbsp
                                    <button class="btn btn-primary"  type="submit"><i class="glyphicon glyphicon-th"></i> Get List</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    @if($attendance)
                        <div class="row">
                            <div class="col-md-12">
                                <table id="attendanceList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Employee Type</th>
                                        <th>Employee No</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>dIN_TIME</th>
                                        <th>dOUT_TIME</th>
                                        <th>nWorking_HOUR</th>
                                        <th>vSTATUS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($regNo)
                                        @define $totalDay = 0
                                        @define $totalHour = 0
                                    @endif

                                    @foreach($attendance as $atd)
                                        <tr>
                                            <td>{{$atd->teacher->egroup}}</td>
                                            <td>{{$atd->regNo}}</td>
                                            <td>{{$atd->teacher->fullName}}</td>
                                            <td>{{$atd->date->format('d/m/Y')}}</td>
                                            <td>
                                                @if($atd->dIN_TIME!="00:00:00")
                                                    {{date('h:i:s a', strtotime($atd->dIN_TIME))}}
                                                @else
                                                    {{$atd->dIN_TIME}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($atd->dOUT_TIME!="00:00:00")
                                                    {{date('h:i:s a', strtotime($atd->dOUT_TIME))}}
                                                @else
                                                    {{$atd->dOUT_TIME}}
                                                @endif
                                            </td>
                                            <td>
                                                {{SmsHelper::clockalize($atd->nWorkingHOUR)}}
                                            </td>
                                            <td>
                                                @if($atd->vSTATUS=="A")
                                                    @if(isset($holiDays[$atd->date->format('Y-m-d')]))
                                                        <span class="badge badge-success">H</span>
                                                    @elseif(isset($empWorks[$atd->regNo]) && isset($empWorks[$atd->regNo][$atd->date->format('Y-m-d')]))
                                                        <span class="badge badge-success">WO</span>
                                                    @else
                                                        <span class="badge badge-warning">A</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-success">P</span>
                                                @endif

                                            </td>
                                            @if($regNo)
                                                @define $totalDay += 1
                                                @define $totalHour += $atd->nWorkingHOUR
                                        @endif
                                    @endforeach
                                    </tbody>

                                    @if($regNo)
                                        <tfoot>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td>{{$totalDay}}(Days)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                {{SmsHelper::clockalize($totalHour)}}
                                            </td>
                                            <td></td>

                                        </tr>
                                        </tfoot>
                                    @endif

                                </table>
                            </div>

                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">

        function changeFilter(value){
            if (value == '1') {
                $('#byEmployee').hide();
                $('[name="teacher"]').prop('disabled',true);
                $('#byType').show();
                $('[name="egroup"]').prop('disabled',false);
            }
            else if (value == '2') {
                $('#byType').hide();
                $('[name="egroup"]').prop('disabled',true);
                $('#byEmployee').show();
                $('[name="teacher"]').prop('disabled',false);
            }
        }
        $( document ).ready(function() {

            $(".datepicker").datepicker( {
                autoclose:true,
                format:"yyyy-mm-dd",
                todayHighlight: true

            });

            $('#attendanceList').dataTable({"aaSorting": []});

            $("#btnPrint" ).click(function() {
                $('input[name="print_view"]').val(1);
                var qstring = $( "form" ).serialize();
                var url =  window.location.origin+"/teacher-attendance/list?"+qstring;
                window.open(url, '_blank');
                window.focus();
            });

            $('[name="searchType"]').change(function() {
                changeFilter(this.value);
            });
            changeFilter('{{$searchType}}');

        });

    </script>
@stop
