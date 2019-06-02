<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') ID Card Template @endsection
<!-- End block -->
@section('extraStyle')
    <link href="{{ asset(mix('/css/colorpicker.css')) }}" rel="stylesheet" type="text/css">
@endsection
<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            ID Card Template
            <small>@if($template) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('administrator.template.idcard.index')}}"><i class="fa icon-template"></i> Id Card Template</a></li>
            <li class="active">@if($template) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="callout callout-danger">
                            <p><b>Note:</b> Fist select format. Then if you need to change color then pick it. And add logo and signature before add the template. </p>
                        </div>
                    </div>
                    <form novalidate id="templateForm" action="@if($template) {{URL::Route('administrator.template.idcard.update', $template->id)}} @else {{URL::Route('administrator.template.idcard.store')}} @endif" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="3">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="name">Template Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" placeholder="template name" required value="@if($template){{ $template->name }}@else{{old('name')}}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="name">For<span class="text-danger">*</span></label>
                                                {!! Form::select('role_id', $roles, $role , ['placeholder' => 'Which for...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                <span class="form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="name">Template Format<span class="text-danger">*</span></label>
                                                {!! Form::select('format_id', ["1" => "Format 1", "2" => "Format 2", "3" => "Format 3"], $formatNo , ['placeholder' => 'Pick a format...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                <span class="form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('format_id') }}</span>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="bg_color">Background Color</label>
                                                <input type="text" class="form-control  my-colorpicker" name="bg_color" placeholder="#ff0000" value="@if($template){{ $content->bg_color }}@else{{old('bg_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('bg_color') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="border_color">Border Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="border_color" placeholder="#ff0000" value="@if($template){{ $content->border_color }}@else{{old('border_color')}}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('border_color') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="body_text_color">Body Text Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="body_text_color" placeholder="#ff0000" value="@if($template){{ $content->body_text_color }}@else{{old('body_text_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('body_text_color') }}</span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="fs_title_color">FS Title Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="fs_title_color" placeholder="#ff0000" value="@if($template){{ $content->fs_title_color }}@else{{old('fs_title_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('fs_title_color') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="picture_border_color">Picture Border Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="picture_border_color" placeholder="#ff0000" value="@if($template){{ $content->picture_border_color }}@else{{old('picture_border_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('picture_border_color') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="bs_title_color">BS Title Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="bs_title_color" placeholder="#ff0000" value="@if($template){{ $content->bs_title_color }}@else{{old('bs_title_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('bs_title_color') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="website_link_color">Website Link Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="website_link_color" placeholder="#ff0000" value="@if($template){{ $content->website_link_color }}@else{{old('website_link_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('website_link_color') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <div class="form-group has-feedback">
                                                    <label for="logo">Logo<span class="text-danger">@if(!$template) * @endif[100x116 | 200kb]</span></label>
                                                    <input id="logoUp"  type="file" class="form-control" accept=".jpeg, .jpg, .png"  @if(!$template) required @endif name="logo" placeholder="BG image">
                                                    <span class="text-danger">{{ $errors->first('logo') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <div class="form-group has-feedback">
                                                    <label for="signature">Signature<span class="text-danger">@if(!$template) * @endif[119x33 | 200kb]</span></label>
                                                    <input id="signatureUp" type="file" class="form-control" accept=".jpeg, .jpg, .png" @if(!$template) required @endif name="signature" placeholder="BG image">
                                                    <span class="text-danger">{{ $errors->first('signature') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row onlyFormat3" style="display: @if($template && $formatNo==3) block @else none @endif;">
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="fs_title_bg_color">FS Title BG Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="fs_title_bg_color" placeholder="#ff0000" value="@if($template){{ $content->fs_title_bg_color }}@else{{old('fs_title_bg_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('fs_title_bg_color') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="id_title_color">ID Title Color</label>
                                                <input type="text" class="form-control my-colorpicker" name="id_title_color" placeholder="#ff0000" value="@if($template){{ $content->id_title_color }}@else{{old('id_title_color') }}@endif">
                                                <span class="fa fa-info form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('id_title_color') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <div class="form-group has-feedback">
                                                    <label for="title_bg_image">ID Title Background Image<span class="text-danger">[320x92 | 200kb]</span></label>
                                                    <input id="titleBgUp" type="file" class="form-control" accept=".jpeg, .jpg, .png" name="title_bg_image" placeholder="BG image">
                                                    <span class="text-danger">{{ $errors->first('title_bg_image') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="col-md-6">
                                    <iframe id="idFrame" style="width: 100%; height: 350px;" src="" frameborder="0">

                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {{--<a href="{{URL::route('administrator.template.idcard.index')}}" class="btn btn-default pull-left ">Cancel</a>--}}
                            <button type="button" class="btn btn-danger pull-left btnReset"><i class="fa fa-refresh"></i> Reset</button>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa @if($template) fa-refresh @else fa-plus-circle @endif"></i> @if($template) Update @else Add @endif</button>
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
    <!-- Color picker -->
    <script src="{{ asset(mix('/js/colorpicker.js')) }}"></script>
    <script type="text/javascript">
        window.templateUrl = "{{asset('example/template')}}";
        window.liveChange = 1;
        @if($template)
            window.logoString = "data:image/png;base64,{{$content->logo}}";
            window.signatureDataImage = "data:image/png;base64,{{$content->signature}}";
            @if($formatNo == 3)
                window.titleBgDataImage = "data:image/png;base64,{{$content->title_bg_image}}";
            @endif
        @endif
        $(document).ready(function () {
            Administrator.templateIdcardInit();

            @if($template)
                setTimeout(function () {
                    window.liveChange = 0;
                    console.log(window.liveChange);
                    $('select[name="format_id"]').trigger('change');
                },1000);
            @endif
        });
    </script>
@endsection
<!-- END PAGE JS-->
