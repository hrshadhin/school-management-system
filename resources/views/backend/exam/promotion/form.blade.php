<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Promotion @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
           Student Promotion
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Promotion</li>
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
                            <p style="font-size: medium;">
                            <span class="fa fa-bullhorn text-red text-bold"> Note:</span> <span class="fa fa-bullhorn text-red"></span><br>
                            <span class="fa fa-hand-o-right"> This process can't be recoverable. So use this form with caution!</span><br>
                            <span class="fa fa-hand-o-right"> Fail students will re-admit in same class.</span><br>
                            <span class="fa fa-hand-o-right"> Only core subjects will be assigned to students that promoted to next class. For elective and selective subject update each student subject from edit student menu.</span>
                            </p>
                        </div>
                    </div>
                    <form novalidate id="entryForm" action="{{URL::Route('promotion.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            @if ($errors->any())
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="box box-warning">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Current Academic Information:</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label for="class_id">Academic Year
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                {!! Form::select('current_academic_year_id', $academic_years, null , ['placeholder' => 'Pick a year...', 'id' => 'current_year_change',  'class' => 'form-control select2', 'required' => 'true']) !!}
                                                                <span class="form-control-feedback"></span>
                                                                <span class="text-danger">{{ $errors->first('academic_year_id') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label for="class_id">Class Name
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                {!! Form::select('current_class_id', $classes, null , [ 'placeholder' => 'Pick a class...', 'id' => 'current_class_change', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                                <span class="form-control-feedback"></span>
                                                                <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label for="exam_id">Exam Name<span class="text-danger">*</span>
                                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Which exam merit position will use for promoting students?"></i>
                                                                </label>
                                                                {!! Form::select('exam_id', [], null , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                                <span class="form-control-feedback"></span>
                                                                <span class="text-danger">{{ $errors->first('exam_id') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label for="fail_count">Allow subject fail<span class="text-danger">*</span>
                                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="How many subject fail allow to promote student to next class?"></i>
                                                                </label>
                                                                {!! Form::select('fail_count', [], null , ['placeholder' => 'Pick a option...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                                <span class="form-control-feedback"></span>
                                                                <span class="text-danger">{{ $errors->first('fail_count') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="box box-success">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Promoting Academic Information:</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label for="class_id">Academic Year
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                {!! Form::select('promote_academic_year_id', [], null , ['placeholder' => 'Pick a year...', 'id' => 'promote_year_change',  'class' => 'form-control select2', 'required' => 'true']) !!}
                                                                <span class="form-control-feedback"></span>
                                                                <span class="text-danger">{{ $errors->first('academic_year_id') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label for="class_id">Class Name
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                {!! Form::select('promote_class_id', $classes, null , [ 'placeholder' => 'Pick a class...', 'id' => 'promote_class_change', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                                <span class="form-control-feedback"></span>
                                                                <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right"><i class="fa icon-promotion"></i> Promote</button>
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
        window.academicYearUrl = '{{URL::Route("public.get_promotional_year_list")}}';
        window.exam_list_url = '{{URL::Route("exam.index")}}';
        window.subject_count_url = '{{route("public.class_subject_count")}}';
        window.changeExportColumnIndex = -1;
        $(document).ready(function () {
            Academic.promotionInit();


        });
    </script>
@endsection
<!-- END PAGE JS-->
