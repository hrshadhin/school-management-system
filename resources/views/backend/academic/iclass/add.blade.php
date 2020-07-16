<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Class @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Class
            <small>@if($iclass) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('academic.class')}}"><i class="fa fa-sitemap"></i> Class</a></li>
            <li class="active">@if($iclass) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="@if($iclass) {{URL::Route('academic.class_update', $iclass->id)}} @else {{URL::Route('academic.class_store')}} @endif" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group has-feedback">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" name="name" placeholder="name" value="@if($iclass){{ $iclass->name }}@else{{ old('name') }}@endif" required minlength="2" maxlength="255">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="numeric_value">Numeric Value<span class="text-danger">*</span></label>
                                        <input  type="number" class="form-control" name="numeric_value" placeholder="1,2,3,5" @if($iclass) readonly @endif value="@if($iclass){{ $iclass->numeric_value }}@else{{ old('numeric_value') }}@endif" required>
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('numeric_value') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="group">Group
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Set group"></i>
                                        </label>
                                        {!! Form::select('group', ['None' => 'None', 'Science' => 'Science', 'Humanities' => 'Humanities', 'Business Studies' => 'Business Studies' ], $group , ['placeholder' => 'Pick a group...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('group') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="order">Order sequence<span class="text-danger">*</span></label>
                                        <input  type="number" class="form-control" name="order" placeholder="1,2,3,5"  value="@if($iclass){{ $iclass->order }}@else{{ old('order') }}@endif" min="0" required>
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="duration">Course duration(In Year)<span class="text-danger">*</span></label>
                                        <input  type="number" class="form-control" name="duration" placeholder="1,2,3,4" value="@if($iclass){{ $iclass->duration }}@else{{ old('duration', 1) }}@endif" required>
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('duration') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="have_selective_subject">Have Selective Subject?
                                            <div class="checkbox icheck">
                                                <input type="checkbox" name="have_selective_subject" class="have_selective_subject" @if($have_selective_subject) checked @endif>
                                            </div>
                                        </label>
                                        <span class="text-danger">{{ $errors->first('have_selective_subject') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3" id="max_selective" @if(!$have_selective_subject) style="display: none;" @endif>
                                    <div class="form-group has-feedback">
                                        <label for="max_selective_subject">Max Selective Subject<span class="text-danger">*</span></label>
                                        <input  type="number" class="form-control" name="max_selective_subject" placeholder="1,2,3,4" value="@if($iclass){{ $iclass->max_selective_subject }}@else{{ old('max_selective_subject') }}@endif" required>
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('max_selective_subject') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="have_elective_subject">Have Elective Subject?
                                            <div class="checkbox icheck">
                                                <label>
                                                    {!! Form::checkbox('have_elective_subject', $have_elective_subject, $have_elective_subject) !!}
                                                </label>
                                            </div>
                                        </label>
                                        <span class="text-danger">{{ $errors->first('have_elective_subject') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 hide">
                                    <div class="form-group has-feedback">
                                        <label for="have_selective_subject">Is Open for Admission?
                                            <div class="checkbox icheck">
                                                <input type="checkbox" name="is_open_for_admission" @if($is_open_for_admission) checked @endif>
                                            </div>
                                        </label>
                                        <span class="text-danger">{{ $errors->first('is_open_for_admission') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label for="note">Note</label>
                                        <textarea name="note" class="form-control"  maxlength="500" >@if($iclass){{ $iclass->note }}@endif</textarea>
                                        <span class="fa fa-location-arrow form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('note') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('academic.class')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa @if($iclass) fa-refresh @else fa-plus-circle @endif"></i> @if($iclass) Update @else Add @endif</button>

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
            Academic.iclassInit();
            $('.have_selective_subject').on('ifChecked ifUnchecked', function(event) {
                if (event.type == 'ifChecked') {
                    $('#max_selective').show();
                } else {
                    $('#max_selective').hide();
                }
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
