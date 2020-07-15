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
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Marks</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('marks.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            <fieldset>
                                <legend>Filters:</legend>
                                <form novalidate id="entryForm" action="{{URL::Route('marks.index')}}" method="post" enctype="multipart/form-data">
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
                                        <div class="col-md-6">
                                            <div class="btn-toolbar">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Get Marks</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>

                            </fieldset>
                        </div>
                        </div>
                        <hr>
                        @if($marks)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="listDataTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Regi No.</th>
                                            <th>Roll No.</th>
                                            @php
                                                $marksDistributions = json_decode($examRule->marks_distribution);
                                            @endphp
                                            @foreach($marksDistributions as $distribution)
                                                <th>{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</th>
                                            @endforeach
                                            <th>Total Marks</th>
                                            <th>Grade</th>
                                            <th>Point</th>
                                            <th>Status</th>
                                            <th class="notexport" width="5%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($marks as $studentMark)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$studentMark->student->info->name}}</td>
                                                    <td>{{$studentMark->student->regi_no}}</td>
                                                    <td>{{$studentMark->student->roll_no}}</td>
                                                    @php
                                                        $achivemarks = json_decode($studentMark->marks, true);
                                                    @endphp
                                                    @foreach($marksDistributions as $distribution)
                                                        <td>
                                                            {{$achivemarks[$distribution->type]}}
                                                        </td>
                                                    @endforeach
                                                    <td>{{$studentMark->total_marks}}</td>
                                                    <td>{{$studentMark->grade}}</td>
                                                    <td>{{$studentMark->point}}</td>
                                                    <td>
                                                        @if($studentMark->present == 0)
                                                            <span class="badge bg-red">Absent</span>
                                                        @else
                                                            <span class="badge bg-green">Present</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($editMode)
                                                        <div class="btn-group">
                                                            <a title="Edit" href="{{URL::route('marks.edit', $studentMark->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Regi No.</th>
                                            <th>Roll No.</th>
                                            @foreach($marksDistributions as $distribution)
                                                <th>{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</th>
                                            @endforeach
                                            <th>Total Marks</th>
                                            <th>Grade</th>
                                            <th>Point</th>
                                            <th>Status</th>
                                            <th class="notexport" width="5%">Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
