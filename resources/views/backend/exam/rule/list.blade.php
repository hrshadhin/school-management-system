<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Exam Rules @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Exam Rules
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Exam Rules</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::select('class', $classes, $class_id , ['placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::select('exam', $exams, $exam_id , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'id' => 'exam_rule_list_filter', 'required' => 'true']) !!}
                            </div>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('exam.rule.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                            <table id="listDataTableOnlyPrint" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Subject</th>
                                    <th width="10%">Grade</th>
                                    <th width="10%">Combine Subject</th>
                                    <th width="30%">Marks Distribution</th>
                                    <th width="10%">Passing Rule</th>
                                    <th width="5%">Total Marks</th>
                                    <th width="5%">Pass Marks</th>
                                    <th class="notexport" width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rules as $rule)
                                    @php
                                        $distribution = json_decode($rule->marks_distribution);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $rule->subject->name }}</td>
                                        <td>{{ $rule->grade->name }}</td>
                                        <td>@if($rule->combineSubject){{ $rule->combineSubject->name }}@endif</td>
                                        <td>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        Type
                                                    </th>
                                                    <th>
                                                        Total Marks
                                                    </th>
                                                    <th>
                                                        Passing Marks
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($distribution as $dist)
                                                    <tr>
                                                        <td>
                                                            {{AppHelper::MARKS_DISTRIBUTION_TYPES[$dist->type]}}
                                                        </td>

                                                        <td>
                                                            {{$dist->total_marks}}
                                                        </td>
                                                        <td>
                                                            {{$dist->pass_marks}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            {{AppHelper::PASSING_RULES[$rule->passing_rule]}}
                                        </td>
                                        <td>
                                            {{$rule->total_exam_marks}}
                                        </td>
                                        <td>
                                            {{$rule->over_all_pass}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a title="Edit" href="{{URL::route('exam.rule.edit',$rule->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            </div>
                                            <!-- todo: have problem in mobile device -->
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('exam.rule.destroy')}}">
                                                    @csrf
                                                    <input type="hidden" name="hiddenId" value="{{$rule->id}}">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Subject</th>
                                    <th width="10%">Grade</th>
                                    <th width="10%">Combine Subject</th>
                                    <th width="30%">Marks Distribution</th>
                                    <th width="10%">Passing Rule</th>
                                    <th width="5%">Total Marks</th>
                                    <th width="5%">Pass Marks</th>
                                    <th class="notexport" width="10%">Action</th>
                                </tr>
                                </tfoot>
                            </table>
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
        $(document).ready(function () {
           Academic.examRuleInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
