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
                    <form novalidate id="entryForm" action="{{URL::Route('student_attendance.store')}}" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <div class="callout callout-danger">
                                <p><b>Note:</b> Fill up the form first, then it will shows student list.</p>
                            </div>
                        </div>
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
                            <p class="lead section-title-top-zero">Academic Info:</p>
                            <div class="row">
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
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="class_id">Class<span class="text-danger">*</span></label>
                                        {!! Form::select('class_id', $classes, null , ['placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                        <input type='text' class="form-control date_picker attendanceExistsChecker"  name="attendance_date" placeholder="date" value="{{date('d/m/Y')}}" required minlength="10" maxlength="11" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('attendance_date') }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="lead section-title-top-zero">Student List:</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="studentListTable" class="table table-bordered table-striped table-responsive attendance-add">
                                        <thead>
                                        <tr>
                                            <th width="60%">Name</th>
                                            <th width="10%">Roll No.</th>
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

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('student_attendance.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right" style="display: none;"><i class="fa fa-plus-circle"></i> Save</button>

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
        window.section_list_url = '{{URL::Route("academic.section")}}';
        window.getStudentAjaxUrl = '{{URL::route('student.list_by_fitler')}}';
        window.attendanceUrl = '{{route('student_attendance.index')}}';
        $(document).ready(function () {
            Academic.attendanceInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
