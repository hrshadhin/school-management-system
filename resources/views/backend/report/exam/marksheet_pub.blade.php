<!-- Master page  -->
@extends('backend.layouts.front_master')

<!-- Page title -->
@section('pageTitle') Online Result Search @endsection
<!-- End block -->
<!-- Page body extra class -->
@section('bodyCssClass') public_marksheet_form_body_color @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    @if (Session::has('success') || Session::has('error') || Session::has('warning'))
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert @if (Session::has('success')) alert-success @elseif(Session::has('error')) alert-danger @else alert-warning @endif alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @if (Session::has('success'))
                        <h5><i class="icon fa fa-check"></i>{{ Session::get('success') }}</h5>
                    @elseif(Session::has('error'))
                        <h5><i class="icon fa fa-ban"></i>{{ Session::get('error') }}</h5>
                    @else
                        <h5><i class="icon fa fa-warning"></i>{{ Session::get('warning') }}</h5>
                        @endif
                        </h5>
                </div>
            </div>
        </div>
    @endif
    <div class="public_marksheet_form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header border">
                        <h2 class="text-info text-bold text-center">Online Result Search</h2>
                    </div>
                    <form novalidate id="entryForm" action="{{URL::Route('report.marksheet_pub')}}" method="post"  enctype="multipart/form-data">
                        <div class="box-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="academic_year">Academic Year<span class="text-danger">*</span></label>
                                        {!! Form::select('academic_year', $academic_years, null , ['placeholder' => 'Pick a year...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="class_id">Class Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        {!! Form::select('class_id', $classes, null , [ 'placeholder' => 'Pick a class...', 'id' => 'class_change', 'class' => 'form-control select2 notFireAjax', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="class_id">Exam Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        {!! Form::select('exam_id', $exams, null , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('exam_id') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="regi_no">Student Registration/Roll No.<span class="text-danger">*</span></label>
                                        <input type='text'  class="form-control" name="regi_no" placeholder="registration number" value="" required />
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('regi_no') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        @captcha
                                        <input type='text' style="width: 180px;"  class="form-control" id="captcha" name="captcha" placeholder="enter captcha code here" value="" required />
                                        <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="{{route('report.marksheet_pub')}}"  class="btn btn-warning"><i class="fa fa-refresh"></i> Reset</a>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-search"></i> Search </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <!-- theme js -->
    <script src="{{ asset(mix('/js/theme.js')) }}"></script>
    <script type="text/javascript">
        window.exam_list_url = '{{route('public.exam_list')}}';
        window.initPageJs = 1;
        $(document).ready(function () {
            Generic.initMarksheetPublic();

        });

    </script>
@endsection
<!-- END PAGE JS-->
