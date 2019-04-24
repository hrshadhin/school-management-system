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
            <li class="active">Upload</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="entryForm" action="{{URL::Route('student_attendance.create_file')}}" method="post" enctype="multipart/form-data">

                        <div class="box-body">
                            @csrf
                            @if(count($errors->all()))
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> Posted data was invalid!.<br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="callout callout-danger">
                                        <h5 class="text-danger"><i class="glyphicon glyphicon-hand-right"></i> Sample text file.
                                            [<a href="{{asset('example/attendance_format_1.txt')}}" target="_blank">Download Sample 1</a>]
                                            [<a href="/example/attendance_format_2.txt" target="_blank">Download Sample 2</a>]
                                        </h5>
                                        <h5 class="text-danger"> <i class="glyphicon glyphicon-hand-right"></i> Please be carefull about file size.It must be less than or equal 1MB!</h5>
                                        <h5 class="text-danger"> <i class="glyphicon glyphicon-hand-right"></i> File should be text file and get from attendance machine.</h5>
                                        <h5 class="text-danger"> <i class="glyphicon glyphicon-hand-right"></i> Currently this system support 2 type of files, download the sample if you needed.</h5>
                                        <h5 class="text-danger"> <i class="glyphicon glyphicon-hand-right"></i> Log file found at <b>storage/logs/student-attendance-upload.log</b></h5>
                                    </div>
                                </div>
                            </div>
                            @if(!$isProcessingFile)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="file">Attendance Text File</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i> </span>
                                                <input type="file" accept="text/plain" required class="form-control" name="file">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkbox icheck">
                                            <label class="margin-top-20">
                                                <input type="checkbox" name="is_send_notification" class="notMe" @if($sendNotification) checked @endif> <span class="text-bold text-warning">Send Absent Notification?</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info keepIt progressDiv">
                                            {{--<span>File has been uploaded. Now need to process the data.</span>--}}
                                            {{--<a href="{{$queueFireUrl}}" class="btn btn-primary btn-link startBtn">Start Now</a>--}}
                                            <span id="spinnerspan"><i class="glyphicon glyphicon-refresh spinning"></i> Uploaded attendance is being proccessing...</span><br>
                                            <span id="statusMessage"></span>
                                        </div>
                                    </div>
                                </div>

                            @endif

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('student_attendance.index')}}" class="btn btn-default">Cancel</a>
                            @if(!$isProcessingFile)
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-upload"></i> Upload</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection


<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        window.fileUploadStatusURL = '{{URL::route('student_attendance.file_queue_status')}}';
        $(document).ready(function () {
            @if($isProcessingFile)
                Academic.attendanceFileUploadStatus();
            @endif

            $('input').not('.dont-style').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });

        });
    </script>
@endsection
<!-- END PAGE JS-->
