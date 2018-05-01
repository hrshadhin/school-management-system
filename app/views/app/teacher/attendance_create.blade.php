@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/teacher-attendance/list">View List</a><br>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Attendance Entry</h2>

                </div>
                <div class="box-content">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your file.Please download example file and see it.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form role="form" action="/teacher-attendance/create" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="alert alert-warning">
                                <h5 class="text-danger"><i class="glyphicon glyphicon-hand-right"></i> Example/Sample Excel/CSV file.[<a href="/example/teacher_attendance.csv" target="_blank">Download CSV</a>][<a href="/example/teacher_attendance.xlsx" target="_blank">Download Excel</a>]
                          </h5>
                                <h5 class="text-danger"> <i class="glyphicon glyphicon-hand-right"></i> Please be care about file size.It must be less than 8MB!</h5>
                                <h5 class="text-danger"> <i class="glyphicon glyphicon-hand-right"></i> If it is a excel file then make sure cells value are formated as "text"!</h5>                      </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group ">
                                <label for="file">Excel/CSV File</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i> </span>
                                    <input type="file"  required="true" class="form-control" name="fileUpload">
                                </div>
                            </div>

                                </div>
                            </div>
                        <!--button save -->
                        <div class="row">
                            <div class="col-md-12">

                                <button class="btn btn-primary pull-right" id="btnsave" type="submit">
                                    <i class="glyphicon glyphicon-arrow-up"></i> Upload</button>
                              </div>
                          </div>
                    </form>

        </div>
    </div>
    </div>
@stop
@section('script')
@stop
