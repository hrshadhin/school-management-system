@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

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
                    <h2><i class="glyphicon glyphicon-book"></i> Employee List</h2>

                </div>
                <div class="box-content">


                    <div class="row">
                        <div class="col-md-12">
                            <table id="teacherList" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="5%">Type</th>
                                    <th width="10%">Employee No</th>
                                    <th width="15%">Name</th>
                                    <th width="10%">Gender</th>
                                    <th width="10%">Religion</th>
                                    <th width="15%">Mobile No</th>
                                    <th width="15%">Present Address</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{$teacher->egroup}}</td>
                                        <td>{{$teacher->regNo}}</td>
                                        <td>{{$teacher->fullName}}</td>
                                        <td>{{$teacher->gender}}</td>
                                        <td>{{$teacher->religion}}</td>
                                        <td>{{$teacher->cellNo }}</td>
                                        <td>{{$teacher->presentAddress}}</td>
                                        <td style="text-align: right;">
                                            <a title='Attendance' class='btn btn-sm btn-info' href='{{url("/teacher-attendance/list?teacher=")}}{{$teacher->regNo}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>&nbsp&nbsp <a title='Details' class='btn btn-sm btn-success' href='{{url("/teacher/view")}}/{{$teacher->regNo}}'> <i class="glyphicon glyphicon-zoom-in icon-white"></i></a>&nbsp&nbsp<a title='Edit' class='btn btn-sm btn-info' href='{{url("/teacher/edit")}}/{{$teacher->regNo}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-sm btn-danger' href='{{url("/teacher/delete")}}/{{$teacher->regNo}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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
            $('#teacherList').dataTable({"aaSorting": []});
        });
    </script>
@stop
