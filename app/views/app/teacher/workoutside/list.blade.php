@extends('layouts.master')
@section('style')
    <style>
        #leaveList th,#leaveList td{
            text-align: center;
        }

        .badge-warning {
            background-color: #f89406;
        }

        .badge-success {
            background-color: #468847;
        }

        .badge-danger {
            background-color: #ff0000;
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
    @if (Session::get('error'))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong> {{ Session::get('error')}}</strong>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Work Outside List</h2>

                </div>
                <div class="box-content">
                    <form role="form" action="/workoutside" method="get" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="class">Employee</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                                            {{ Form::select('employee',$teachers,$employee,['class'=>'form-control','id'=>'class',])}}
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-md-2">--}}
                                {{--<div class="form-group ">--}}
                                {{--<label for="dob">From Date <span class="text-danger">*</span></label>--}}
                                {{--<div class="input-group">--}}
                                {{--<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>--}}
                                {{--<input type="text" class="form-control datepicker" name="dateFrom" required  data-date-format="yyyy/mm/dd" value="{{$dateFrom}}">--}}
                                {{--</div>--}}


                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-2">--}}
                                {{--<div class="form-group ">--}}
                                {{--<label for="dob">To Date <span class="text-danger">*</span></label>--}}
                                {{--<div class="input-group">--}}
                                {{--<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>--}}
                                {{--<input type="text"  class="form-control datepicker" name="dateTo" required  data-date-format="yyyy/mm/dd" value="{{$dateTo}}">--}}
                                {{--</div>--}}


                                {{--</div>--}}
                                {{--</div>--}}


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    {{--<button class="btn btn-primary" id="btnPrint"  type="button"><i class="glyphicon glyphicon-print"></i> Print List</button>--}}
                                    {{--&nbsp--}}
                                    <button class="btn btn-primary"  type="submit"><i class="glyphicon glyphicon-th"></i> Get List</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="leaveList" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="10%">Date</th>
                                    <th width="20%">Employee No</th>
                                    <th width="30%">Name</th>
                                    <th width="15%">Description</th>
                                    <th width="10%">Paper</th>
                                    <th width="15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($workOutsides as $work)
                                    <tr>
                                        <td>{{$work->workDate->format('d/m/Y')}}</td>
                                        <td>{{$work->regNo}}</td>
                                        <td>{{$work->teacher->fullName}}</td>
                                        <td>{{$work->description}}</td>
                                        <td>
                                            @if($work->paper)
                                                <a target="_blank" href="{{url('/')}}/images/teachers/{{$work->paper}}"><i class="glyphicon glyphicon-download-alt" style="font-size: 20px;"></i></a>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            @if($work->status==1)
                                         <a title='Delete' class='btn btn-sm btn-danger' href='{{url("/workoutside/delete")}}/{{$work->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                                @endif
                                        </td>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>


                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#leaveList').dataTable({"aaSorting": []});
        });
    </script>
@stop
