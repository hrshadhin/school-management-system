<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Settings @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Institute Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Institute Settings</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form  id="entryForm" action="{{URL::Route('settings.institute')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if(AppHelper::getInstituteCategory() != 'college')
                        <div class="callout callout-danger">
                            <p><b>Note:</b> Create academic year if not have any.</p>
                        </div>
                    @endif
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Application Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Institute Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" name="name" class="form-control" placeholder="HR High School" value="@if($info){{ $info->name }}@endif" maxlength="255" required />
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="short_name">Institute Short Name<span class="text-danger">*</span></label>
                                        <input type="text" name="short_name" class="form-control" placeholder="HRHS" value="@if($info){{ $info->short_name }}@endif" minlength="3" maxlength="255" required />
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('short_name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="establish">Establish<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control year_picker" readonly  name="establish" placeholder="year" value="@if($info){{ $info->establish }}@else{{ old('establish',date('Y')) }} @endif" required minlength="4" maxlength="255" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('establish') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="logo">Logo<span class="text-danger">[230 X 50 max size and max 1MB]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo" placeholder="logo image">
                                        @if($info && isset($info->logo))
                                            <input type="hidden" name="oldLogo" value="{{$info->logo}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group has-feedback">
                                        <label for="logo_small">Logo Small<span class="text-danger">[50 X 50 max size and max 512kb]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo_small" placeholder="logo image">
                                        @if($info && isset($info->logo_small))
                                            <input type="hidden" name="oldLogoSmall" value="{{$info->logo_small}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('logo_small') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="favicon">Favicon<span class="text-danger">[only .png image][32 X 32 exact size and max 512KB]</span></label>
                                        <input  type="file" class="form-control" accept=".png" name="favicon" placeholder="favicon image">
                                        @if($info && isset($info->favicon))
                                            <input type="hidden" name="oldFavicon" value="{{$info->favicon}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('favicon') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="website_link">Website Link</label>
                                        <input  type="text" class="form-control" name="website_link"  placeholder="url" value="@if($info) {{ $info->website_link }} @endif" maxlength="500">
                                        <span class="fa fa-link form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('website_link') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="email">Email</label>
                                        <input  type="email" class="form-control" name="email"  placeholder="email address" value="@if($info) {{ $info->email }} @endif" maxlength="255">
                                        <span class="fa fa-envelope form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="phone_no">Phone/Mobile No.<span class="text-danger">*</span></label>
                                        <input  type="text" class="form-control" name="phone_no" required placeholder="phone or mobile number" value="@if($info) {{ $info->phone_no }}@endif" minlength="8" maxlength="255">
                                        <span class="fa fa-phone form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="address">Address<span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" required maxlength="500" required>@if($info){{ $info->address }}@endif</textarea>
                                        <span class="fa fa-location-arrow form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="attendance_notification">Institute Type
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select institute type"></i>
                                        </label>
                                        {!! Form::select('institute_type', [1 => "Boys", 2 => "Girls", 3 => "Boys & Girls"], $institute_type , ['class' => 'form-control select2']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('institute_type') }}</span>
                                    </div>
                                </div>
                                {{--<div class="col-md-4">--}}
                                    {{--<div class="form-group has-feedback">--}}
                                        {{--<label for="language">Default Language--}}
                                            {{--<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Set application language"></i>--}}
                                        {{--</label>--}}
                                        {{--{!! Form::select('language', $languages, $language, ['class' => 'form-control select2', 'required' => 'true']) !!}--}}
                                        {{--<span class="fa fa-language form-control-feedback"></span>--}}
                                        {{--<span class="text-danger">{{ $errors->first('language') }}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                @if(AppHelper::getInstituteCategory() != 'college')
                                <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label for="academic_year">Default Academic Year
                                                <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Set default academic year"></i>
                                            </label>
                                            {!! Form::select('academic_year', $academic_years, $academic_year, ['placeholder' => 'Pick a year...','class' => 'form-control select2', 'required' => 'true']) !!}
                                            <span class="form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                        </div>

                                </div>
                                @endif

                            </div>

                            <div class="row">
                                <div class="col-md-2" style="display: none;">
                                    <div class="form-group has-feedback">
                                        <label for="disable_language">Disable Language
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Check for disable language in top section"></i>
                                            <div class="checkbox icheck">
                                                <label>
                                                    {!! Form::checkbox('disable_language', $disable_language, $disable_language) !!}
                                                </label>
                                            </div>
                                        </label>
                                        <span class="text-danger">{{ $errors->first('disable_language') }}</span>
                                    </div>

                                </div>

                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="frontend_website">Frontend Website
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enable/Disable frontend website"></i>
                                            <div class="checkbox icheck">
                                                <label>
                                                    {!! Form::checkbox('frontend_website', $frontend_website, $frontend_website) !!}
                                                </label>
                                            </div>
                                        </label>
                                        <span class="text-danger">{{ $errors->first('frontend_website') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Institute Working Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="weekends">Weekends</label>
                                        {!! Form::select('weekends[]', AppHelper::weekDays, $weekends, ['class' => 'form-control select2', 'required' => 'true','multiple' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('weekends') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="morning_start">Morning Shift Start</label>
                                        <input type='text' class="form-control time_picker"  readonly name="morning_start" placeholder="time" value="@if(isset($metas['shift_data'])){{$metas['shift_data']['Morning']['start']}}@else{{'12:00 am'}}@endif" required minlength="7" maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('morning_start') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="morning_end">Morning Shift End</label>
                                        <input type='text' class="form-control time_picker"  readonly name="morning_end" placeholder="time" value="@if(isset($metas['shift_data'])){{$metas['shift_data']['Morning']['end']}}@else{{'12:00 am'}}@endif" required minlength="7" maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('morning_end') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="day_start">Day Shift Start</label>
                                        <input type='text' class="form-control time_picker"  readonly name="day_start" placeholder="time" value="@if(isset($metas['shift_data'])){{$metas['shift_data']['Day']['start']}}@else{{'12:00 am'}}@endif" required minlength="7" maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('day_start') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="day_end">Day Shift End</label>
                                        <input type='text' class="form-control time_picker"  readonly name="day_end" placeholder="time" value="@if(isset($metas['shift_data'])){{$metas['shift_data']['Day']['end']}}@else{{'12:00 am'}}@endif" required  minlength="7"  maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('day_end') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="evening_start">Evening Shift Start</label>
                                        <input type='text' class="form-control time_picker"  readonly name="evening_start" placeholder="time" value="@if(isset($metas['shift_data'])){{$metas['shift_data']['Evening']['start']}}@else{{'12:00 am'}}@endif" required   minlength="7" maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('evening_start') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="evening_end">Evening Shift End</label>
                                        <input type='text' class="form-control time_picker" readonly  autocomplete="off" name="evening_end" placeholder="time" value="@if(isset($metas['shift_data'])){{$metas['shift_data']['Evening']['end']}}@else{{'12:00 am'}}@endif" required  minlength="7"  maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('evening_end') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                            <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Attendance Notification Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="student_attendance_notification">Student Attendance Notification Type
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select attendance notificaton type"></i>
                                        </label>
                                        {!! Form::select('student_attendance_notification', [0 => "None", 1 => "SMS", 2 => "Email"], $student_attendance_notification , ['class' => 'form-control select2']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('student_attendance_notification') }}</span>
                                    </div>
                                </div>
                                <div id="divSmsGateWayList_St" class="col-md-4 @if(!$student_attendance_notification || $student_attendance_notification != 1) hide @endif">

                                </div>
                                <div id="divTemplateList_St" class="col-md-4 @if(!$student_attendance_notification) hide @endif">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="employee_attendance_notification">Employee Attendance Notification Type
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select attendance notificaton type"></i>
                                        </label>
                                        {!! Form::select('employee_attendance_notification', [0 => "None", 1 => "SMS", 2 => "Email"], $employee_attendance_notification , ['class' => 'form-control select2']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('employee_attendance_notification') }}</span>
                                    </div>
                                </div>
                                <div id="divSmsGateWayList_Emp" class="col-md-4 @if(!$employee_attendance_notification || $employee_attendance_notification != 1) hide @endif">

                                </div>
                                <div id="divTemplateList_Emp" class="col-md-4 @if(!$employee_attendance_notification) hide @endif">

                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Default Idcard templates</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="student_idcard_template">Student Idcard template
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select idcard template for student"></i>
                                        </label>
                                        {!! Form::select('student_idcard_template', $studentIdcardTemplates, $student_idcard_template , ['class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('student_idcard_template') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="employee_idcard_template">Employee Idcard template
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select idcard template for Employee"></i>
                                        </label>
                                        {!! Form::select('employee_idcard_template', $employeIdcardTemplates, $employee_idcard_template , ['class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('employee_idcard_template') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Result Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="result_default_grade_id">Result Default Grade System
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select grade system"></i>
                                        </label>
                                        {!! Form::select('result_default_grade_id', $grades, $grade_id , ['class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('result_default_grade_id') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script type="text/javascript">
        window.smsGatewayListURL = '{{URL::route('settings.sms_gateway.index')}}';
        window.templateListURL = '{{URL::route('administrator.template.mailsms.index')}}';

        window.gatewaySt = @if(isset($metas['student_attendance_gateway'])) {{$metas['student_attendance_gateway']}}; @else 0; @endif
        window.templateSt = @if(isset($metas['student_attendance_template'])) {{$metas['student_attendance_template']}}; @else 0; @endif
        window.gatewayEmp = @if(isset($metas['employee_attendance_gateway'])) {{$metas['employee_attendance_gateway']}}; @else 0; @endif
        window.templateEmp = @if(isset($metas['employee_attendance_template'])) {{$metas['employee_attendance_template']}}; @else 0; @endif

        $(document).ready(function () {
            Settings.instituteInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->

