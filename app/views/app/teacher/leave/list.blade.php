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
                    <h2><i class="glyphicon glyphicon-book"></i> Leave List</h2>

                </div>
                <div class="box-content">
                    <form role="form" action="/leaves" method="get" enctype="multipart/form-data">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="gender">Leave Type</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <?php  $data2=[
                                                '0'=>'All',
                                                'CL'=>'Casual leave (CL)',
                                                'ML'=>'Sick leave (ML)',
                                            ];?>
                                            {{ Form::select('lType',$data2,$type,['class'=>'form-control'])}}

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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="gender">Status</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <?php  $data=[
                                                '0'=>'All',
                                                '1'=>'Pending',
                                                '2'=>'Approved',
                                                '3'=>'Rejected',
                                            ];?>
                                            {{ Form::select('status',$data,$status,['class'=>'form-control','required'=>'true'])}}

                                        </div>
                                    </div>
                                </div>

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
                                    <th width="15%">Employee No</th>
                                    <th width="20%">Name</th>
                                    <th width="5%">Type</th>
                                    <th width="15%">Description</th>
                                    <th width="10%">Paper</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leaves as $leave)
                                    <tr>
                                        <td>{{$leave->leaveDate->format('d/m/Y')}}</td>
                                        <td>{{$leave->regNo}}</td>
                                        <td>{{$leave->teacher->fullName}}</td>
                                        <td>{{$leave->lType}}</td>
                                        <td>{{$leave->description}}</td>
                                        <td>
                                            @if($leave->paper)
                                                <a target="_blank" href="{{url('/')}}/images/teachers/{{$leave->paper}}"><i class="glyphicon glyphicon-download-alt" style="font-size: 20px;"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($leave->status==1)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($leave->status==2)
                                                <span class="badge badge-success">Approved</span>
                                            @elseif($leave->status==3)
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            @if($leave->status==1)
                                            <a title='Approve' class='btn btn-sm btn-success' href='{{url("/leaves/update")}}/{{$leave->id}}/2'> <i class="glyphicon glyphicon-check icon-white"></i></a>&nbsp&nbsp
                                            <a title='Reject' class='btn btn-sm btn-warning' href='{{url("/leaves/update")}}/{{$leave->id}}/3'> <i class="glyphicon glyphicon-remove-circle icon-white"></i></a>&nbsp&nbsp
                                            <a title='Delete' class='btn btn-sm btn-danger' href='{{url("/leaves/delete")}}/{{$leave->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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
