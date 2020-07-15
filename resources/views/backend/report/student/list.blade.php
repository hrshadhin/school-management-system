<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Student List @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Student List
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa fa-file-pdf-o"></i> Report</li>
            <li><i class="fa icon-studentreport"></i> Student</li>
            <li><i class="fa icon-student"></i> List</li>
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
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li @if($activeTab == 1)class="active"@endif><a href="#searchByClass" data-toggle="tab">By Class</a></li>
                                <li @if($activeTab == 2)class="active"@endif><a href="#searchByFilters"  data-toggle="tab">By Filters</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane @if($activeTab == 1) active @endif" id="searchByClass">
                                    <form novalidate class="reportForm" target="_blank" action="{{URL::Route('report.student_list')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="form_name" value="class">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback">
                                                    <label for="academic_year">Academic Year<span class="text-danger">*</span></label>
                                                    {!! Form::select('academic_year', $academic_years, $default_academic_year , ['placeholder' => 'Pick a year...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group has-feedback">
                                                    <label for="class_id">Class<span class="text-danger">*</span></label>
                                                    {!! Form::select('class_id', $classes, null , ['placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    <label for="section_id">Section</label>
                                                    {!! Form::select('section_id', [], null , ['placeholder' => 'Pick a section...','class' => 'form-control select2']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('section_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-info pull-left margin-top-24"><i class="fa fa-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane @if($activeTab == 2) active @endif" id="searchByFilters">
                                    <form novalidate class="reportForm" target="_blank" action="{{URL::Route('report.student_list')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="form_name" value="filters">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback">
                                                    <label for="academic_year">Academic Year<span class="text-danger">*</span></label>
                                                    {!! Form::select('academic_year', $academic_years, $default_academic_year , ['placeholder' => 'Pick a year...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    <label for="gender">Gender
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select gender type"></i>
                                                    </label>
                                                    {!! Form::select('gender', ['0' => 'All'] + AppHelper::GENDER, 0 , ['class' => 'form-control select2']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    <label for="religion">Religion
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select religion type"></i>
                                                    </label>
                                                    {!! Form::select('religion', ['0' => 'All'] + AppHelper::RELIGION, null , ['class' => 'form-control select2']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('religion') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    <label for="blood_group">Blood Group
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select blood group type"></i>
                                                    </label>
                                                    {!! Form::select('blood_group', ['0' => 'All'] + AppHelper::BLOOD_GROUP, 0 , ['class' => 'form-control select2']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('blood_group') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-info pull-left margin-top-24"><i class="fa fa-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        window.section_list_url = '{{URL::Route("public.section")}}';
        $(document).ready(function () {
            Reports.commonJs();
        });
    </script>
@endsection
<!-- END PAGE JS-->
