<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Settings @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form  id="settingsForm" action="{{URL::Route('site.settings')}}" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">Settings <span class="text-danger"> * Marks are required feild</span></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="name">School Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="HR High School" value="@if($info){{ $info->name }}@endif" maxlength="255" required />
                                <span class="fa fa-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="short_name">School Short Name<span class="text-danger">*</span></label>
                                <input type="text" name="short_name" class="form-control" placeholder="HRHS" value="@if($info){{ $info->short_name }}@endif" maxlength="255" required />
                                <span class="fa fa-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('short_name') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="logo">Logo<span class="text-danger">[82 X 72 exact size and max 1MB]</span></label>
                                <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo" placeholder="logo image">
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('logo') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="logo2x">Logo 2x<span class="text-danger">[162 X 142 exact size and max 1MB]</span></label>
                                <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo2x" placeholder="logo image">
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('logo2x') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="favicon">Favicon<span class="text-danger">[only .png image][32 X 32 exact size and max 512KB]</span></label>
                                <input  type="file" class="form-control" accept=".png" name="favicon" placeholder="favicon image">
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('favicon') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="facebook">Facebook Link</label>
                                <input  type="text" class="form-control" name="facebook"  placeholder="url" value="@if($info) {{ $info->facebook }} @endif" maxlength="500">
                                <span class="fa fa-facebook form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('facebook') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="instagram">Instagram Link</label>
                                <input  type="text" class="form-control" name="instagram"  placeholder="url" value="@if($info) {{ $info->instagram }} @endif" maxlength="500">
                                <span class="fa fa-instagram form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('instagram') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="twitter">Twitter Link</label>
                                <input  type="text" class="form-control" name="twitter"  placeholder="url" value="@if($info) {{ $info->twitter }} @endif" maxlength="500">
                                <span class="fa fa-twitter form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('twitter') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="youtube">Youtube Link</label>
                                <input  type="text" class="form-control" name="youtube"  placeholder="url" value="@if($info) {{ $info->youtube }} @endif" maxlength="500">
                                <span class="fa fa-youtube form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('youtube') }}</span>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('site.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>

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
        $(document).ready(function () {
            Site.settingsInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->

