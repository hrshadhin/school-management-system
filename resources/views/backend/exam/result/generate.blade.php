<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Result @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Result
            <small>Generate</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('result.index')}}"><i class="fa icon-markpercentage"></i> Result</a></li>
            <li class="active"> Generate</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form novalidate id="entryForm" action="{{URL::Route('result.create')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        @if(AppHelper::getInstituteCategory() == 'college')
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback">
                                                    <label for="class_id">Academic Year
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    {!! Form::select('academic_year_id', $academic_years, null , ['placeholder' => 'Pick a year...',  'class' => 'form-control select2', 'required' => 'true']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('academic_year_id') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label for="class_id">Class Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                {!! Form::select('class_id', $classes, null , [ 'placeholder' => 'Pick a class...', 'id' => 'class_change', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                <span class="form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group has-feedback">
                                                <label for="class_id">Exam Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                {!! Form::select('exam_id', $exams, null , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                <span class="form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('exam_id') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group has-feedback">
                                                <label for="publish_date">Result Publish Date<span class="text-danger">*</span></label>
                                                <input type='text' class="form-control date_picker" readonly  name="publish_date" placeholder="date" value="{{date('d/m/Y')}}" required minlength="10" maxlength="11" />
                                                <span class="fa fa-calendar form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('publish_date') }}</span>
                                            </div>
                                        </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-info margin-top-20"><i class="fa fa-check-circle"></i> Generate</button>
                                            </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
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
        window.exam_list_url = '{{URL::Route("exam.index")}}';
        window.changeExportColumnIndex = -1;
        window.generatePage = 1;
        $(document).ready(function () {
            Academic.resultInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->
