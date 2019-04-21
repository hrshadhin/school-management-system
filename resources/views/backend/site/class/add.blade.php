<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Class Profile @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Class
            <small>Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('class_profile.index')}}"><i class="fa fa-picture-o"></i> Class Profile</a></li>
            <li class="active">@if($profile) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="classProfileAddForm" action="@if($profile) {{URL::Route('class_profile.update', $profile->id)}} @else {{URL::Route('class_profile.store')}} @endif " method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">@if($profile) Update @else Add @endif Class Profile<span class="text-danger"> * Marks are required feild</span></h3>
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
                                <label for="image_sm">Image Small<span class="text-danger">[370 X 280 min size and max 2MB] @if(!$profile) * @endif</span></label>
                                <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="image_sm"  @if(!$profile) required @endif>
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('image_sm') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="image_lg">Image Large<span class="text-danger">[870 X 460 min size and max 2MB] @if(!$profile) * @endif</span></label>
                                <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="image_lg"  @if(!$profile) required @endif>
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('image_lg') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="teacher">Class Teacher<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="teacher" placeholder="teacher name" value="@if($profile){{ $profile->teacher }}@else{{ old('teacher') }} @endif" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('teacher') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="room_no">Room No<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="room_no" placeholder="number" value="@if($profile){{ $profile->room_no }}@else{{ old('room_no') }} @endif" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('room_no') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="capacity">Capacity<span class="text-danger">*</span></label>
                                <input  type="number" class="form-control" name="capacity" placeholder="40" value="@if($profile){{ $profile->capacity }}@else{{ old('capacity') }} @endif" required min="1">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('capacity') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="shift">Shift<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="shift" placeholder="morning/afternoon/evening" value="@if($profile){{ $profile->shift }}@else{{ old('shift') }} @endif" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('shift') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="short_description" placeholder="" value="@if($profile){{ $profile->short_description }}@else{{ old('short_description') }} @endif" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('short_description') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="description">Description</label>
                                <textarea  name="description" class="form-control textarea" >@if($profile){{ $profile->description }}@else{{ old('description') }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="outline">Outline/Syllabus/Structure</label>
                                <textarea  name="outline" class="form-control textarea" >@if($profile){{ $profile->outline }}@else{{ old('outline') }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('outline') }}</span>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('class_profile.index')}}" class="btn btn-default">Cancel</a>
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
    <!-- editor js -->
    <script>
        //editor jQuery Patch fixing
        jQuery = $;
    </script>
    <script src="{{ asset('/js/editor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Site.classProfileInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->