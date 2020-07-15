<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Student Attendance @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Student Attendance
            <small>Add New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa icon-attendance"></i> Attendance</li>
            <li><a href="{{URL::route('student_attendance.index')}}"><i class="fa icon-student"></i>Student</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                        <div class="box-body">
                            @if(count($errors->all()))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(!count($students))
                            <p class="lead section-title-top-zero">Academic Info:</p>
                            <div class="row">
                                <form novalidate id="entryForm" action="{{URL::Route('student_attendance.create')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                @if(AppHelper::getInstituteCategory() == 'college')
                                    <div class="col-md-3">
                                        <div class="form-group has-feedback">
                                            <label for="academic_year">Academic Year<span class="text-danger">*</span></label>
                                            {!! Form::select('academic_year', $academic_years, null , ['placeholder' => 'Pick a year...','class' => 'form-control select2', 'required' => 'true']) !!}
                                            <span class="form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="class_id">Class<span class="text-danger">*</span></label>
                                        {!! Form::select('class_id', $classes, null , ['placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="section_id">Section<span class="text-danger">*</span></label>
                                        {!! Form::select('section_id', [], null , ['placeholder' => 'Pick a section...','class' => 'form-control select2', 'id' => 'section_id_filter', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('section_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="attendance_date">Date<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control date_picker attendanceExistsChecker" readonly  name="attendance_date" placeholder="date" value="{{$attendance_date}}" required minlength="10" maxlength="11" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('attendance_date') }}</span>
                                    </div>
                                </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info margin-top-20"><i class="fa fa-filter"></i> Entry Attendance</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                            <p class="lead section-title-top-zero">Student List:</p>
                                <div class="row">
                                <div class="col-md-12">
                                    @if(count($students))
                                        <div class="well text-center" style="padding: 0; margin: 0; font-size: 20px;">
                                            <span class="text-info">Attendance Entry for {{$attendance_date}}</span><br>
                                            @if(AppHelper::getInstituteCategory() == 'college')
                                            <span class="text-info">Academic Year: {{$academic_year}}</span><br>
                                            @endif
                                            <span class="text-info">Class: {{$class_name}}</span><br>
                                            <span class="text-info">Section: {{$section_name}}</span>

                                        </div>
                                    <form novalidate id="entryForm" action="{{URL::Route('student_attendance.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="academic_year" value="{{$acYear}}">
                                        <input type="hidden" name="class_id" value="{{$class_id}}">
                                        <input type="hidden" name="section_id" value="{{$section_id}}">
                                        <input type="hidden" name="attendance_date" value="{{$attendance_date}}">
                                    <table id="studentListTable" class="table table-bordered table-striped table-responsive attendance-add">
                                        <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="55%">Name</th>
                                            <th width="10%">Roll No.</th>
                                            {{--<th width="15%">In Time</th>--}}
                                            {{--<th width="15%">Out Time</th>--}}
                                            {{--<th width="5%">Staying Hours</th>--}}
                                            <th width="30%">
                                                Is Present?
                                                <div class="checkbox icheck inline_icheck">
                                                    <label>
                                                        <input type="checkbox" id="toggleCheckboxes" class="dont-style-notMe"> <span class="text-bold">Select or Deselect All</span>
                                                    </label>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                <span class="text-bold">{{$student->info->name}} [{{$student->regi_no}}]</span>
                                                <input type="hidden" value="{{$student->id}}" name="registrationIds[]">
                                            </td>
                                            <td>
                                                {{$student->roll_no}}
                                            </td>
                                            <td>
                                                <div class="checkbox icheck inline_icheck">
                                                    <input type="checkbox" name="present[{{$student->id}}]">
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> Add Attendance</button>
                                    </form>
                                    @endif
                                </div>
                            </div>



                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('student_attendance.index')}}" class="btn btn-default">Cancel</a>
                        </div>
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
        window.section_list_url = '{{URL::Route("academic.section")}}';
        window.attendanceUrl = '{{route('student_attendance.index')}}';
        $(document).ready(function () {
            Academic.attendanceInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
