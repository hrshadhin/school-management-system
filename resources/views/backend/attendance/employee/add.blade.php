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
            <small>Add New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa icon-attendance"></i> Attendance</li>
            <li><a href="{{URL::route('employee_attendance.index')}}"><i class="fa icon-student"></i>Employee</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="{{URL::Route('employee_attendance.store')}}" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            @csrf
                            @if(count($errors->all()))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="attendance_date">Date<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control date_picker attendanceExistsChecker" readonly  name="attendance_date" placeholder="date" value="{{date('d/m/Y')}}" required minlength="10" maxlength="10" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('attendance_date') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table id="employeeListTable" class="table table-bordered table-striped table-responsive attendance-add">
                                        <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="25%">Name</th>
                                            <th width="10%">Card No.</th>
                                            <th width="15%">In Time</th>
                                            <th width="15%">Out Time</th>
                                            <th width="5%">Working Hours</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employees as $employee)
                                                <tr>
                                                    <td>
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td>
                                                        <span>{{$employee->name}}</span>
                                                        <input type="hidden" name="employeeIds[]" value="{{$employee->id}}">
                                                    </td>
                                                    <td>
                                                        {{$employee->id_card}}
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type='text' class="form-control date_time_picker inTime" readonly  name="inTime[{{$employee->id}}]" placeholder="date time" value="{{date('d/m/Y')}} 00:00 am" required minlength="15" maxlength="19" />
                                                            <span class="fa fa-calendar form-control-feedback"></span>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                        <input type='text' class="form-control date_time_picker outTime" readonly  name="outTime[{{$employee->id}}]" placeholder="date time" value="{{date('d/m/Y')}} 00:00 am" required minlength="18" maxlength="19" />
                                                        <span class="fa fa-calendar form-control-feedback"></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-bold workingHour">00:00</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('employee_attendance.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> Save</button>

                        </div>
                    </form>
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
        window.attendanceUrl = '{{route('employee_attendance.index')}}';
        $(document).ready(function () {
            HRM.attendanceInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
