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
            <small>@if($rule) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('exam.rule.index')}}"><i class="fa fa-bar-chart"></i> Exam Rules</a></li>
            <li class="active">@if($rule) Update @else Add @endif</li>
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
                            <p><b>Note:</b> Create class,subejct,exam and grade before add exam rule.</p>
                        </div>
                    </div>
                    <form novalidate id="entryForm" action="@if($rule) {{URL::Route('exam.rule.update', $rule->id)}} @else {{URL::Route('exam.rule.store')}} @endif" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="box-body">

                        <div class="row">
                            @if(!$rule)
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label for="class_id">Class Name<span class="text-danger">*</span></label>
                                        {!! Form::select('class_id', $classes, null , ['id' => 'exam_rules_add_class_change', 'placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3">
                                @php
                                    $readonly = [];
                                    if($rule){
                                        $readonly = ['readonly' => true];
                                     }
                                @endphp
                                <div class="form-group has-feedback">
                                    <label for="subject_id">Subject<span class="text-danger">*</span></label>
                                    {!! Form::select('subject_id', $subjects, $subject_id , ['placeholder' => 'Pick a subject...', 'class' => 'form-control select2', 'required' => 'true'] + $readonly) !!}
                                    <span class="fa form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('subject_id') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label for="exam_id">Exam<span class="text-danger">*</span></label>
                                    {!! Form::select('exam_id', $exams, $exam_id , ['placeholder' => 'Pick a exam...','class' => 'form-control select2', 'required' => 'true']) !!}
                                    <span class="fa form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('exam_id') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label for="grade_id">Marks Grading<span class="text-danger">*</span></label>
                                    {!! Form::select('grade_id', $grades, $grade_id , ['placeholder' => 'Pick a grade...','class' => 'form-control select2', 'required' => 'true']) !!}
                                    <span class="fa form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('grade_id') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label for="combine_subject_id">Combine Subject
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="If this subject pair with other subject then select one. Or leave it blank."></i>
                                    </label>
                                    {!! Form::select('combine_subject_id', $subjects, $combine_subject , ['placeholder' => 'Pick a subject...','class' => 'form-control select2']) !!}
                                    <span class="fa form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('combine_subject_id') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label for="passing_rule">Passing Rule<span class="text-danger">*</span></label>
                                    {!! Form::select('passing_rule', AppHelper::PASSING_RULES, $passing_rule , ['placeholder' => 'Pick a rule...','class' => 'form-control select2', 'required' => 'true']) !!}
                                    <span class="form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('passing_rule') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Total Exam Marks</label>
                                    <input type="number" name="total_exam_marks" value="@if($rule){{$rule->total_exam_marks}}@endif" min="0" required readonly class="form-control total_mark">
                                    <span class="form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-3 overAllPassDiv" @if($passing_rule==2) style="display: none;"@endif>
                                <div class="form-group has-feedback">
                                    <label for="over_all_pass">Over All Pass Marks<span class="text-danger">*</span></label>
                                    <input  type="number" readonly class="form-control" name="over_all_pass" required  placeholder="" value="@if($rule){{$rule->over_all_pass}}@endif"  min="0">
                                    <span class="form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('over_all_pass') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label>Marks Distribution<span class="text-danger">*</span> </label>
                                    <table id="distributionTypeTable" class="table table-striped table-bordered haveForm">
                                        <thead>
                                        <tr>
                                            <th>
                                                Type
                                            </th>
                                            <th>
                                                Total Marks
                                            </th>
                                            <th>
                                                Pass Marks
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @if($rule)
                                              @php
                                                  $distribution = json_decode($rule->marks_distribution);
                                              @endphp
                                              @foreach($distribution as $dist)
                                                  <tr>
                                                      <td>
                                                          <span>{{AppHelper::MARKS_DISTRIBUTION_TYPES[$dist->type]}}</span>
                                                          <input type="hidden" name="type[]" value="{{$dist->type}}">
                                                      </td>

                                                      <td>
                                                          <input type="number" class="form-control" name="total_marks[]" value="{{$dist->total_marks}}" required min="0">
                                                      </td>
                                                      <td>
                                                          <input type="number" class="form-control" name="pass_marks[]" value="{{$dist->pass_marks}}" required min="0">
                                                      </td>
                                                  </tr>
                                              @endforeach
                                          @endif
                                        </tbody>
                                    </table>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                    <span class="text-danger">{{ $errors->first('total_marks') }}</span>
                                    <span class="text-danger">{{ $errors->first('pass_marks') }}</span>
                                </div>
                            </div>


                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{URL::route('exam.rule.index')}}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right"><i class="fa @if($rule) fa-refresh @else fa-plus-circle @endif"></i> @if($rule) Update @else Add @endif</button>
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
        window.subject_list_url = '{{URL::Route("academic.subject")}}';
        window.exam_details_url = '{{URL::Route("exam.index")}}';
        window.grade_details_url = '{{URL::Route("exam.grade.index")}}';
        window.exam_list_url = '{{URL::Route("exam.index")}}';
        $(document).ready(function () {
            Academic.examRuleInit();
            @if($rule)
                $('select[name="subject_id"]').prop('readonly', true);
            @endif
        });
    </script>
@endsection
<!-- END PAGE JS-->
