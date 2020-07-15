<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Academic Year @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Academic Year
            <small>@if($academicYear) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('administrator.academic_year')}}"><i class="fa fa-calendar-plus-o"></i> Academic Year</a></li>
            <li class="active">@if($academicYear) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="@if($academicYear) {{URL::Route('administrator.academic_year_update', $academicYear->id)}} @else {{URL::Route('administrator.academic_year_store')}} @endif" method="post" enctype="multipart/form-data">

                    <div class="box-body">
                            @csrf

                        <div class="form-group has-feedback">
                            <label for="title">Year Title<span class="text-danger">*</span></label>
                            <input autofocus type="text" class="form-control" name="title" placeholder="title" value="@if($academicYear){{ $academicYear->title }}@else{{ old('tile') }} @endif" required minlength="4" maxlength="255">
                            <span class="fa fa-info form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="start_date">Start Date<span class="text-danger">*</span></label>
                            <input type='text' class="form-control date_picker"  readonly name="start_date" placeholder="date" value="@if($academicYear){{ $academicYear->start_date->format('d/m/Y') }}@else{{ old('start_date','01/01/'.date('Y')) }} @endif" required minlength="10" maxlength="255" />
                            <span class="fa fa-calendar form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="end_date">End Date<span class="text-danger">*</span></label>
                            <input type='text' class="form-control date_picker"  readonly name="end_date" placeholder="date" value="@if($academicYear){{ $academicYear->start_date->format('d/m/Y') }}@else{{ old('end_date','31/12/'.date('Y')) }} @endif" required minlength="10" maxlength="255" />
                            <span class="fa fa-calendar form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('end_date') }}</span>
                        </div>
                        <div class="form-group has-feedback hide">
                            <label for="have_selective_subject">Is open for Admission?
                                <div class="checkbox icheck">
                                    <input type="checkbox" name="is_open_for_admission" class="have_selective_subject" @if($is_open_for_admission) checked @endif>
                                </div>
                            </label>
                            <span class="text-danger">{{ $errors->first('is_open_for_admission') }}</span>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{URL::route('administrator.academic_year')}}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right"><i class="fa @if($academicYear) fa-refresh @else fa-plus-circle @endif"></i> @if($academicYear) Update @else Add @endif</button>

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
            Administrator.academicYearInit();
            $('input').not('.dont-style').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
