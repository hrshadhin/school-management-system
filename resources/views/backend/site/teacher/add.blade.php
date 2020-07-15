<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Teacher Profile @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Teacher
            <small>Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('teacher_profile.index')}}"><i class="fa icon-teacher"></i> Teachers Profile</a></li>
            <li class="active">@if($profile) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="teacherProfileForm" action="@if($profile) {{URL::Route('teacher_profile.update', $profile->id)}} @else {{URL::Route('teacher_profile.store')}} @endif " method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">@if($profile) Update @else Add @endif Teacher Profile<span class="text-danger"> * Marks are required feild</span></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @csrf
                            @if($profile) {{ method_field('PATCH') }} @endif
                            <div class="form-group has-feedback">
                                <label for="name">Name<span class="text-danger">*</span></label>
                                <input autofocus type="text" class="form-control" name="name" placeholder="name" value="@if($profile){{ $profile->name }}@else{{ old('name') }} @endif" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="image">Image<span class="text-danger">[210 X 220 min size and max 2MB]</span></label>
                                <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="image"  >
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="designation">Designation<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="designation" placeholder="write here" value="@if($profile){{ $profile->designation }}@else{{ old('designation') }} @endif" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('designation') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="qualification">Education Qualification<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="qualification" placeholder="write here" value="@if($profile && $profile->qualification){{ $profile->qualification }}@else{{ old('qualification') }} @endif" required minlength="1" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('qualification') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="description">Description</label>
                                <textarea  name="description" class="form-control" >@if($profile){{ $profile->description }}@else{{ old('description') }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="facebook">Facebook link</label>
                                <input  type="text" class="form-control" name="facebook" placeholder="https://facebook.com/mr.jamil00003" value="@if($profile){{ $profile->facebook }}@else{{ old('facebook') }} @endif" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('facebook') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="instagram">Instagram link</label>
                                <input  type="text" class="form-control" name="instagram" placeholder="https://instagram.com/mr.jamil00003" value="@if($profile){{ $profile->instagram }}@else{{ old('instagram') }} @endif" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('instagram') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="twitter">Twitter link</label>
                                <input  type="text" class="form-control" name="twitter" placeholder="https://twitter.com/mr.jamil00003" value="@if($profile){{ $profile->twitter }}@else{{ old('twitter') }} @endif" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('twitter') }}</span>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('teacher_profile.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa @if($profile) fa-refresh @else fa-plus-circle @endif"></i> @if($profile) Update @else Add @endif</button>

                        </div>
                        {{--@if (count($errors) > 0)--}}
                            {{--<div class="error">--}}
                                {{--<ul>--}}
                                    {{--@foreach ($errors->all() as $error)--}}
                                        {{--<li>{{ $error }}</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--@endif--}}
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
            Site.teacherProfileInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->