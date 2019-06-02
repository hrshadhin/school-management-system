<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Mail/SMS Template @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Mail/SMS Template
            <small>@if($template) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('administrator.template.mailsms.index')}}"><i class="fa icon-template"></i> Mail/SMS Template</a></li>
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
                        <p><b>Note:</b> Select a option in for feild then some keyword will appear in tags box. You can click those any of tags for inserting into content field. if you insert [name] tag then when you send
                            email/sms it will represent student/employee/user name on that place.</p>
                    </div>

                   </div>
                    <form novalidate id="templateForm" action="@if($template) {{URL::Route('administrator.template.mailsms.update', $template->id)}} @else {{URL::Route('administrator.template.mailsms.store')}} @endif" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                @if(!$template)
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Type<span class="text-danger">*</span></label>
                                        <div>
                                            <label>
                                                <input type="radio" name="type" value="1" class="minimal" checked> SMS
                                            </label>
                                            <label>
                                                <input type="radio" name="type" value="2" class="minimal"> EMAIL
                                            </label>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
                                    </div>
                                </div>
                                    @else
                                    <div class="hide">
                                        <input type="radio" name="type" value="{{$template->getOriginal('type')}}" class="minimal" checked>
                                    </div>
                                @endif

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" name="name" placeholder="title" value="@if($template){{ $template->name }}@else{{ old('name') }}@endif" required minlength="4" maxlength="255">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">For<span class="text-danger">*</span></label>
                                        {!! Form::select('role_id', AppHelper::TEMPLATE_USERS, $role , ['placeholder' => 'which for...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name">Tags</label>
                                <div class="border" id="email_tags">
                                    @foreach(AppHelper::TEMPLATE_USERS as $key => $user)
                                        <div class="emailtagdiv" id="email_{{$key}}" style="display: @if($role==$key) block; @else none; @endif">
                                            @if($key == AppHelper::USER_STUDENT)
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{class}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{section}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{regi_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{roll_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{name}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{dob}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{gender}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{religion}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{email}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{father_name}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{father_phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{mother_name}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{mother_phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{guardian}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{guardian_phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{present_address}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{permanent_address}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{date}}">
                                            @elseif($key == AppHelper::USER_TEACHER)
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{name}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{designation}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{dob}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{gender}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{religion}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{email}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{address}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{joining_date}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{username}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{date}}">
                                            @elseif($key == AppHelper::USER_PARENTS)
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{class}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{section}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{regi_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{roll_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{name}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{dob}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{gender}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{religion}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{email}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{date}}">
                                            @elseif($key == 0)
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{name}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{email}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{phone_no}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{username}}">
                                                <input class="btn bg-black btn-xs keyword_tag" type="button" value="@{{date}}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="emailContent" style="display: @if($template and $template->getOriginal('type') == 2) block; @else none; @endif">
                                <label for="description">Content<span class="text-danger">*</span></label>
                                <textarea id="textareaEditor"  name="content_email" class="form-control" @if($template and $template->getOriginal('type') == 2) required @endif minlength="5" >@if($template){{ $template->content }}@else{{ old('content') }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('content_email') }}</span>
                            </div>
                            <div class="form-group has-feedback" id="smsContent" style="display: @if($template and $template->getOriginal('type') == 1) block; @elseif(!$template) block @else none; @endif">
                                <label for="description">Content<span class="text-danger">*</span></label>
                                <textarea id="smsContentArea"  name="content" class="form-control" @if($template and $template->getOriginal('type') == 1) required @elseif(!$template) required @endif minlength="5" >@if($template){{ $template->content }}@else{{ old('content') }} @endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('content') }}</span>
                            </div>



                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('administrator.template.mailsms.index')}}" class="btn btn-default">Cancel</a>
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
    <!-- editor js -->
    <script>
        //editor jQuery Patch fixing
        jQuery = $;
    </script>
    <script src="{{ asset('/js/editor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Administrator.templateMailSMSInit();
            // bootstrap WYSIHTML5 - text editor
            $('#textareaEditor').wysihtml5();
        });
    </script>
@endsection
<!-- END PAGE JS-->
