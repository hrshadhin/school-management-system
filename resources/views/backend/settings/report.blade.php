<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Report Settings @endsection
<!-- End block -->
@section('extraStyle')
    <link href="{{ asset(mix('/css/colorpicker.css')) }}" rel="stylesheet" type="text/css">
@endsection
<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Report Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Report Settings</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form  id="entryForm" action="{{URL::Route('settings.report')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Global Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="logo">Logo<span class="text-danger">[max 1MB]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo" placeholder="logo image">
                                        @if(isset($metas['report_logo']) && strlen($metas['report_logo']))
                                            <input type="hidden" name="oldLogo" value="{{$metas['report_logo']}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="background_color">Background Color</label>
                                        <input type="text" class="form-control  my-colorpicker" name="background_color"
                                               placeholder="#ff0000" value="@if(isset($metas['report_background_color']) && strlen($metas['report_background_color'])){{ $metas['report_background_color'] }}@else{{old('background_color') }}@endif">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('background_color') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="logo">Background Image<span class="text-danger">[max 1MB]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="background_image" placeholder="background image">
                                        @if(isset($metas['report_background_image']) && strlen($metas['report_background_image']))
                                            <input type="hidden" name="oldBackgroundImage" value="{{$metas['report_background_image']}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="text_color">Text Color</label>
                                        <input type="text" class="form-control  my-colorpicker" name="text_color"
                                               placeholder="#ff0000" value="@if(isset($metas['report_text_color']) && strlen($metas['report_text_color'])){{ $metas['report_text_color'] }}@else{{old('text_color') }}@endif">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('text_color') }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box">
                        <div class="box-footer">
                            <a href="{{URL::route('user.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <!-- Color picker -->
    <script src="{{ asset(mix('/js/colorpicker.js')) }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Settings.reportInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->

