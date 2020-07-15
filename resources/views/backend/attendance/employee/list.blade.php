<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Employee Attendance @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Employee Attendance
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa icon-attendance"></i> Attendance</li>
            <li class="active">Employee</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="col-md-2">
                            <div class="form-group has-feedback">
                                {!! Form::select('employee_id', $employees, $employee_id , ['placeholder' => 'Pick a employee...','class' => 'form-control select2 emp_filter', 'required' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-feedback">
                                <div class="input-group">
                                <input type='text' class="form-control date_picker" readonly id="attendance_list_filter"  name="attendance_date" placeholder="date" value="{{$attendance_date}}" required minlength="10" maxlength="11" />
                                <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="box-tools pull-right">
                            @can('employee_attendance.create')
                                <a class="btn btn-info btn-sm" href="{{ URL::route('employee_attendance.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                            @endcan
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Name</th>
                                    <th width="10%">Card. No.</th>
                                    <th width="10%">Designation</th>
                                    <th width="15%">In Time</th>
                                    <th width="15%">Out Time</th>
                                    <th width="5%">Working Hours</th>
                                    <th width="15%">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{$attendance->employee->name}}</td>
                                        <td>{{$attendance->employee->id_card}}</td>
                                        <td>{{$attendance->employee->designation}}</td>
                                        <td>{{$attendance->in_time->format('d/m/y h:i a')}}</td>
                                        <td>{{$attendance->out_time->format('d/m/y h:i a')}}</td>
                                        <td>{{date('H\H i\M',strtotime($attendance->working_hour))}}</td>
                                        <td>
                                            <!-- todo: have problem in mobile device -->
                                            <input class="statusChange" type="checkbox" data-pk="{{$attendance->id}}" @if($attendance->getOriginal('present')) checked @endif data-toggle="toggle" data-on="Present" data-off="Absent" data-onstyle="success" data-offstyle="danger">
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Name</th>
                                    <th width="10%">Card. No.</th>
                                    <th width="10%">Designation</th>
                                    <th width="15%">In Time</th>
                                    <th width="15%">Out Time</th>
                                    <th width="5%">Working Hours</th>
                                    <th width="15%">Status</th>
                                </tr>
                                </tfoot>
                            </table>
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
            window.postUrl = '{{URL::Route("employee_attendance.status", 0)}}';
            HRM.attendanceInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
