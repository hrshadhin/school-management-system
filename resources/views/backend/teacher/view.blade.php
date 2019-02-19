<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Teacher Profile @endsection
<!-- End block -->

<!-- Page body extra css -->
@section('extraStyle')
    <style>
        @media print {
            @page {
                size:  A4 landscape;
                margin-top: 10mm;
                margin-left: 0.10in;
                margin-right: 0;
                margin-bottom: 0;
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
            <a  href="{{URL::route('teacher.show',$teacher->id)}}?print_idcard=1" class="btn-ta btn-sm-ta" target="_blank"><span class="fa fa-floppy-o"></span> ID Card </a>
        </div>
        <div class="btn-group">
            <a href="{{URL::route('teacher.edit',$teacher->id)}}" class="btn-ta btn-sm-ta"><i class="fa fa-edit"></i> Edit</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('teacher.index')}}"><i class="fa icon-teacher"></i> Teacher</a></li>
            <li class="active">View</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content main-contents">
        <div class="row">
            <div class="col-md-12">
                <div id="printableArea">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="box box-info">
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="@if($teacher->photo ){{ asset('storage/employee')}}/{{ $teacher->photo }} @else {{ asset('images/avatar.jpg')}} @endif">
                                    <h3 class="profile-username text-center">{{$teacher->name}}</h3>
                                    <p class="text-muted text-center">{{$teacher->designation}}</p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item" style="background-color: #FFF">
                                            <b>ID Card No.</b> <a class="pull-right">{{$teacher->id_card}}</a>
                                        </li>
                                        <li class="list-group-item" style="background-color: #FFF">
                                            <b>Phone</b> <a class="pull-right">{{$teacher->phone_no}}</a>
                                        </li>
                                        <li class="list-group-item" style="background-color: #FFF">
                                            <b>Email</b> <a class="pull-right">{{$teacher->email}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Profile</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <strong><i class="fa fa-info margin-r-5"></i> Gender</strong>
                                    <p class="text-muted">{{$teacher->gender}}</p>

                                    <hr>
                                    <strong><i class="fa fa-clock-o margin-r-5"></i> Date of Birth</strong>
                                    <p class="text-muted">{{$teacher->dob}}</p>

                                    <hr>
                                    <strong><i class="fa fa-book margin-r-5"></i> Qualification</strong>
                                    <p class="text-muted">{{$teacher->qualification}}</p>

                                    <hr>

                                    <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                                    <p class="text-muted">{{$teacher->address}}</p>

                                    <hr>

                                    <strong><i class="fa fa-info margin-r-5"></i> Religion</strong>
                                    <p class="text-muted">{{$teacher->religion}}</p>

                                    <hr>

                                    <strong><i class="fa fa-calendar margin-r-5"></i> Join Date</strong>
                                    <p class="text-muted">{{$teacher->joining_date}}</p>

                                    <hr>
                                    <strong><i class="fa fa-sign-in margin-r-5"></i> Username</strong>
                                    <p class="text-muted">{{$teacher->user->username}}</p>

                                    <hr>
                                    <strong><i class="fa fa-pencil margin-r-5"></i> Signature</strong>
                                    @if($teacher->signature )
                                        <img class="img-responsive" src="{{ asset('storage/employee/signature')}}/{{ $teacher->signature }}">
                                    @endif

                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>

                        <div class="col-sm-9">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    {{--<li><a href="#routine" data-toggle="tab">Routine</a></li>--}}
                                    <li class="active"><a href="#classList" data-toggle="tab">Class & Section</a></li>
                                    <li><a href="#subjects" data-toggle="tab">Subjects</a></li>
                                </ul>

                                <div class="tab-content">
                                    {{--<div class="tab-pane" id="routine">--}}
                                    {{--</div>--}}

                                    <div class="tab-pane active" id="classList">
                                        <table class="table table-responsive table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Class</th>
                                                <th class="text-center">Section</th>
                                            </tr>
                                            <tbody>
                                            @foreach($sections as $section)
                                                <tr>
                                                    <td class="text-center">
                                                        {{$section->class->name}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$section->name}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="subjects">
                                        <table class="table table-responsive table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Class</th>
                                                <th class="text-center">Subject</th>
                                            </tr>
                                            <tbody>
                                            @foreach($subjects as $subject)
                                                <tr>
                                                    <td class="text-center">
                                                        {{$subject->class->name}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$subject->name}}[{{$subject->code}}]
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            </thead>
                                        </table>
                                    </div>

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
        $(document).ready(function () {
            $('.btnPrintInformation').click(function () {
                window.print();
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
