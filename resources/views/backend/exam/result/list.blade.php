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
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Result</li>
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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('result.create') }}"><i class="fa fa-plus-circle"></i> Generate New</a>
                            @can('result.delete')
                                <a class="btn btn-danger btn-sm" href="{{ URL::route('result.delete') }}"><i class="fa fa-trash"></i> Delete Result</a>
                            @endcan
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend>Filters:</legend>
                                    <form novalidate id="entryForm" action="{{URL::Route('result.index')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('academic_year_id', $academic_years, $acYear , ['placeholder' => 'Pick a year...', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('class_id', $classes, $class_id , ['placeholder' => 'Pick a class...', 'id' => 'class_change', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('section_id', $sections, $section_id , ['placeholder' => 'Pick a section...','class' => 'form-control select2']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback">
                                                    {!! Form::select('exam_id', $exams, $exam_id , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Get List</button>
                                            </div>
                                        </div>

                                    </form>

                                </fieldset>
                            </div>
                        </div>
                        <hr>
                        @if($students)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Regi No.</th>
                                                <th>Roll No.</th>
                                                @if(!$section_id)
                                                    <th>Section</th>
                                                @endif
                                                <th>Grade</th>
                                                <th>Point</th>
                                                <th>Total Marks</th>
                                                <th class="notexport" width="10%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($students as $student)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$student->info->name}}</td>
                                                    <td>{{$student->regi_no}}</td>
                                                    <td>{{$student->roll_no}}</td>
                                                    @if(!$section_id)
                                                        <td>{{$student->section->name}}</td>
                                                    @endif
                                                    @if($student->result->first())
                                                    <td>{{$student->result->first()->grade}}</td>
                                                    <td>{{$student->result->first()->point}}</td>
                                                    <td>{{$student->result->first()->total_marks}}</td>
                                                    <td width="10%">
                                                        <div class="btn-group">
                                                            <a style="margin-left: 5px;" title="Marksheet" href="#0" data-regino="{{$student->regi_no}}" class="btn btn-primary btn-sm viewMarksheetPubBtn"><i class="fa fa-file-pdf-o"></i></a>
                                                        </div>
                                                    </td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm" title="This student didn't attend in exam!"><i class="fa fa-question-circle"></i></button>
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Regi No.</th>
                                                <th>Roll No.</th>
                                                @if(!$section_id)
                                                    <th>Section</th>
                                                @endif
                                                <th>Grade</th>
                                                <th>Point</th>
                                                <th>Total Marks</th>
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
        window.exam_list_url = '{{URL::Route("exam.index")}}';
        window.marksheetpub_url = '{{URL::Route("report.marksheet_pub")}}';
        $(document).ready(function () {
            Academic.resultInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
