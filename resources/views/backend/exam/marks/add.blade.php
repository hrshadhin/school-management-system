<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Marks @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Marks
            <small>Add</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('marks.index')}}"><i class="fa icon-markmain"></i> Marks</a></li>
            <li class="active"> Marks Add</li>
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
                                <fieldset>
                                    <legend>Filters:</legend>
                                    <form novalidate id="entryForm" action="{{URL::Route('marks.create')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            @if(AppHelper::getInstituteCategory() == 'college')
                                                <div class="col-md-3">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::select('academic_year_id', $academic_years, $acYear , ['placeholder' => 'Pick a year...', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('class_id', $classes, $class_id , ['placeholder' => 'Pick a class...', 'id' => 'class_change', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('section_id', $sections, $section_id , ['placeholder' => 'Pick a section...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('subject_id', $subjects, $subject_id , ['placeholder' => 'Pick a subject...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('exam_id', $exams, $exam_id , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Entry Marks</button>
                                            </div>

                                        </div>
                                    </form>

                                </fieldset>
                            </div>
                        </div>
                        <hr>
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
                        @endif
                        @if(count($students))
                            <div class="row">
                                <div class="col-md-12">
                                    <form novalidate id="markForm" action="{{URL::Route('marks.store')}}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="academic_year_id" value="{{$acYear}}">
                                        <input type="hidden" name="class_id" value="{{$class_id}}">
                                        <input type="hidden" name="section_id" value="{{$section_id}}">
                                        <input type="hidden" name="subject_id" value="{{$subject_id}}">
                                        <input type="hidden" name="exam_id" value="{{$exam_id}}">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped list_view_table display responsive no-wrap haveForm" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student Name</th>
                                                    <th>Roll No.</th>
                                                    @php
                                                        $marksDistributions = json_decode($examRule->marks_distribution);
                                                    @endphp
                                                    @foreach($marksDistributions as $distribution)
                                                        <th>{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</th>
                                                    @endforeach
                                                    <th>Total Marks</th>
                                                    <th>Absent</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($students as $student)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <span class="text-bold">{{$student->info->name}} [{{$student->regi_no}}]</span>
                                                            <input type="hidden" value="{{$student->id}}" name="registrationIds[]">
                                                        </td>
                                                        <td>
                                                            {{$student->roll_no}}
                                                        </td>
                                                        @foreach($marksDistributions as $distribution)
                                                            <td>
                                                                <input type="number" class="form-control" name="type[{{$student->id}}][{{$distribution->type}}]" value="" required max="{{$distribution->total_marks}}" min="0">
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            <input type="text" readonly class="form-control totalMarks" value="0">
                                                        </td>
                                                        <td>
                                                            <div class="checkbox icheck inline_icheck">
                                                                <input type="checkbox" name="absent[{{$student->id}}]">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student Name</th>
                                                    <th>Roll No.</th>
                                                    @foreach($marksDistributions as $distribution)
                                                        <th>{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</th>
                                                    @endforeach
                                                    <th>Total Marks</th>
                                                    <th>Absent</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Marks</button>

                                    </form>
                                </div>
                            </div>
                        @endif
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
        window.section_list_url = '{{URL::Route("academic.section")}}';
        window.subject_list_url = '{{URL::Route("academic.subject")}}';
        window.exam_list_url = '{{URL::Route("exam.index")}}';
        window.changeExportColumnIndex = -1;
        $(document).ready(function () {
            Academic.marksInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->
