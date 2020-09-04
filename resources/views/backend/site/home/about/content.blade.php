<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') About Us @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            About Us
            <small>Content</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">About Us</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="AboutContentForm" action="{{URL::Route('site.about_content')}}" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">Content <span class="text-danger"> * Marks are required feild</span></h3>
                            <div class="box-tools pull-right">
                                <a class="btn btn-info btn-sm" href="{{ URL::route('site.about_content_image') }}"><i class="fa fa-photo"></i> Images</a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="why_content">Why We Are Better<span class="text-danger">*</span></label>
                                <textarea autofocus name="why_content" class="form-control" maxlength="500" required>@if($content) {{ $content->why_content }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('why_content') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_1_title">Key point 1 title<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="key_point_1_title" required placeholder="title" value="@if($content){{ trim($content->key_point_1_title) }}@endif" required minlength="5" maxlength="100">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_1_title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_1_content">Key point 1 Content<span class="text-danger">*</span></label>
                                <textarea name="key_point_1_content" class="form-control textarea"  required >@if($content){{ trim($content->key_point_1_content) }}@endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_1_content') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_2_title">Key point 2 title</label>
                                <input  type="text" class="form-control" name="key_point_2_title" placeholder="title" value="@if($content){{ trim($content->key_point_2_title) }}@endif" minlength="5" maxlength="100">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_2_title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_2_content">Key point 2 Content</label>
                                <textarea  name="key_point_2_content" class="form-control textarea" >@if($content){{ trim($content->key_point_2_content) }}@endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_2_content') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_3_title">Key point 3 title</label>
                                <input  type="text" class="form-control" name="key_point_3_title" placeholder="title" value="@if($content){{ trim($content->key_point_3_title) }}@endif" minlength="5"  maxlength="100">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_3_title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_3_content">Key point 3 Content</label>
                                <textarea  name="key_point_3_content" class="form-control textarea" >@if($content){{ trim($content->key_point_3_content) }}@endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_3_content') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_4_title">Key point 4 title</label>
                                <input  type="text" class="form-control" name="key_point_4_title" placeholder="title" value="@if($content){{ trim($content->key_point_4_title) }}@endif" minlength="5" maxlength="100">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_4_title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_4_content">Key point 4 Content</label>
                                <textarea  name="key_point_4_content" class="form-control textarea" >@if($content){{ trim($content->key_point_4_content) }}@endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_4_content') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_5_title">Key point 5 title</label>
                                <input  type="text" class="form-control" name="key_point_5_title" placeholder="title" value="@if($content){{ trim($content->key_point_5_title) }}@endif" minlength="5" maxlength="100">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_5_title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="key_point_5_content">Key point 5 Content</label>
                                <textarea  name="key_point_5_content" class="form-control textarea" >@if($content){{ trim($content->key_point_5_content) }}@endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('key_point_5_content') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="about_us">About Us<span class="text-danger">*</span></label>
                                <textarea  name="about_us" class="form-control" minlength="50" maxlength="500" required>@if($content) {{ $content->about_us }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('about_us') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="who_we_are">Who we are<span class="text-danger">*</span></label>
                                <textarea  name="who_we_are" class="form-control" minlength="100" maxlength="1000" required>@if($content) {{ $content->who_we_are }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('who_we_are') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="intro_video_embed_code">Introduction Video Embed Code<span class="text-danger">*</span> </label>
                                <input  type="text" class="form-control" name="intro_video_embed_code"  placeholder="codes" value="@if($content) {{ $content->intro_video_embed_code }} @endif" required>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('intro_video_embed_code') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="video_site_link">More Video Site Link</label>
                                <input  type="url" class="form-control" name="video_site_link"  placeholder="url" value="@if($content) {{ $content->video_site_link }} @endif" minlength="8" maxlength="500">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('video_site_link') }}</span>
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
    <!-- editor js -->
    <script>
        //editor jQuery Patch fixing
        jQuery = $;
    </script>
    <script src="{{ asset('/js/editor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Site.aboutInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->
