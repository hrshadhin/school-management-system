<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') student Profile @endsection
<!-- End block -->

<!-- Page body extra css -->
@section('extraStyle')
    <style>
        @media print {
            @page {
                size:  A4 landscape;
                margin: 0;
            }
        }
    </style>
@endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        @notrole('Student')
        <div class="btn-group">
            <a href="#"  class="btn-ta btn-sm-ta btn-print btnPrintInformation"><i class="fa fa-print"></i> Print</a>
        </div>
        @if($student->is_promoted == '0')
            <div class="btn-group">
                <a href="{{URL::route('student.edit',$student->id)}}" class="btn-ta btn-sm-ta"><i class="fa fa-edit"></i> Edit</a>
            </div>
        @endif

        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('student.index')}}"><i class="fa icon-student"></i> Student</a></li>
            <li class="active">View</li>
        </ol>
        @endnotrole
        @role('Student')
        <h1>
            Academic Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Academic</li>
        </ol>
        @endrole
    </section>

    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="box box-info">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="@if($student->student->photo ){{ asset('storage/student')}}/{{ $student->student->photo }} @else {{ asset('images/avatar.jpg')}} @endif">
                                <h3 class="profile-username text-center">{{$student->student->name}}</h3>
                                <p class="text-muted text-center">{{$student->class->name}}</p>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>Registration No.</b> <a class="pull-right">{{$student->regi_no}}</a>
                                    </li>
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>ID Card No.</b> <a class="pull-right">{{$student->card_no}}</a>
                                    </li>
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>Phone</b> <a class="pull-right">{{$student->student->phone_no}}</a>
                                    </li>
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>Email</b> <a class="pull-right">{{$student->student->email}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#information" data-toggle="tab">Profile</a></li>
                        <li><a href="#subject" id="tabSubject" data-pk="{{$student->id}}" data-toggle="tab">Subjects</a></li>
                        <li><a href="#attendance" id="tabAttendance" data-pk="{{$student->id}}" data-toggle="tab">Attendance</a></li>
                        <li><a href="#marks" id="tabMakrs" data-pk="{{$student->id}}" data-toggle="tab">Marks & Result</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="information">
                            <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Personal Info:</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Full Name</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->name}} @if(strlen($student->student->nick_name))[{{$student->student->nick_name}}]@endif</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Date of Birth</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->dob}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Gender</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->gender}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Religion</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->religion}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Blood Group</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->blood_group}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Nationality</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->nationality}}</p>
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-md-3">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->email}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->phone_no}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Extra Curricular Activities </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->extra_activity}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Note</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->note}}</p>
                                </div>
                            </div>
                            <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Parents Info:</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Father Name </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->father_name}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Father Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->father_phone_no}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Mother Name </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->mother_name}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Mother Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->mother_phone_no}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Guardian Name </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->guardian}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Guardian Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->guardian_phone_no}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Present Address </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->present_address}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Permanent Address</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->permanent_address}}</p>
                                </div>
                            </div>
                            <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Academic Info:</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Academic Year</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->acYear->title}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Registraton No </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->regi_no}}</p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Class</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->class->name}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Section </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->section->name}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Roll No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->roll_no}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Shift</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->shift}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Board Registration No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->board_regi_no}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Card No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->card_no}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Notification SMS No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{AppHelper::STUDENT_SMS_NOTIFICATION_NO[$student->student->sms_receive_no]}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Siblings</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->siblings}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Username</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$username}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Status</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">:
                                        @if($student->status)
                                            <span class="bg-green badge">Active</span>
                                        @else
                                            <span class="bg-warning badge">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane" id="subject">
                            <table id="subjectTable" class="table table-responsive table-bordered table-hover table-td-center">
                                <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Type</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="attendance">
                            <table id="attendanceTable" class="table table-responsive table-bordered table-hover table-td-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                        <div class="tab-pane" id="marks">

                        </div>

                    </div>
                </div>
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
        window.attendanceUrl = '{{route('public.get_student_attendance')}}';
        window.marksUrl = '{{route('public.get_student_result')}}';
        window.subjectUrl = '{{route('public.get_student_subject')}}';
        $(document).ready(function () {
           Academic.studentProfileInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
