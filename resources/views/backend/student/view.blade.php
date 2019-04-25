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
        <div class="btn-group">
            <a href="#"  class="btn-ta btn-sm-ta btn-print btnPrintInformation"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="btn-group">
            <a href="{{URL::route('student.show',$student->id)}}?print_idcard=1" target="_blank" class="btn-ta btn-sm-ta"><i class="fa fa-id-card"></i> ID Card</a>


        </div>
        <div class="btn-group">
            <a href="{{URL::route('student.edit',$student->id)}}" class="btn-ta btn-sm-ta"><i class="fa fa-edit"></i> Edit</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('student.index')}}"><i class="fa icon-student"></i> Student</a></li>
            <li class="active">View</li>
        </ol>
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
                                <img class="profile-user-img img-responsive img-circle" src="@if($student->student->photo ){{ asset('storage/student')}}/{{ $student->class_id }}/{{ $student->student->photo }} @else {{ asset('images/avatar.jpg')}} @endif">
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
                        {{--<li><a href="#routine" data-toggle="tab">Routine</a></li>--}}
                        <li><a href="#attendance" id="tabAttendance" data-pk="{{$student->id}}" data-toggle="tab">Attendance</a></li>
                        {{--<li><a href="#mark" data-toggle="tab">Mark</a></li>--}}
                        {{--<li><a href="#invoice" data-toggle="tab">Invoice</a></li>--}}
                        {{--<li><a href="#payment" data-toggle="tab">Payment</a></li>--}}
                        {{--<li><a href="#document" data-toggle="tab">Document</a></li>--}}
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="information">
                            <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Personal Info:</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Full Name</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->student->name}}</p>
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
                                @if($student->fourth_subject)
                                <div class="col-md-3">
                                    <label for="">Fourth Subject</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$fourthSubject}}</p>
                                </div>
                                @endif

                                @if($student->alt_fourth_subject)
                                <div class="col-md-3">
                                    <label for="">Alternative Fourth Subject</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$altfourthSubject}}</p>
                                </div>
                                @endif

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
                        {{--<div class="tab-pane" id="routine">--}}
                        {{--</div>--}}
                        <div class="tab-pane" id="attendance">
                            <table id="attendanceTable" class="table table-responsive table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                <tbody>

                                </tbody>
                                </thead>
                            </table>
                        </div>
                        {{--<div class="tab-pane" id="mark">--}}

                        {{--</div>--}}
                        {{--<div class="tab-pane" id="invoice">--}}

                        {{--</div>--}}
                        {{--<div class="tab-pane" id="payment">--}}

                        {{--</div>--}}
                        {{--<div class="tab-pane" id="document">--}}
                            {{--<input class="btn btn-success btn-sm" style="margin-bottom: 10px" type="button" value="Add Document" data-toggle="modal" data-target="#documentupload">--}}
                            {{--<div id="hide-table">--}}
                            {{--<table class="table table-striped table-bordered table-hover">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                            {{--<th>#</th>--}}
                            {{--<th>Title</th>--}}
                            {{--<th>Date</th>--}}
                            {{--<th>Action</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--<tr>--}}
                            {{--<td data-title="#">--}}
                            {{--1                                                    </td>--}}

                            {{--<td data-title="Title">--}}
                            {{--Computer                                                    </td>--}}

                            {{--<td data-title="Date">--}}
                            {{--05 Jun 2018                                                    </td>--}}
                            {{--<td data-title="Action">--}}
                            {{--<a href="" class="btn btn-success btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Download"><i class="fa fa-download"></i></a>--}}
                            {{--<a href="" onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" class="btn btn-danger btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>  --}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--</tbody>--}}
                            {{--</table>--}}
                            {{--</div>--}}
                        {{--</div>--}}

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
        window.attendanceUrl = '{{route('student_attendance.index')}}';
        $(document).ready(function () {
           Academic.studentProfileInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
