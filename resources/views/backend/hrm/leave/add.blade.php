<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Leave @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Leave
            <small>@if($leave) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('hrm.leave.index')}}"><i class="fa fa-bed"></i> Leave</a></li>
            <li class="active">@if($leave) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="@if($leave) {{URL::Route('hrm.leave.update', $leave->id)}} @else {{URL::Route('hrm.leave.store')}} @endif" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <div class="callout callout-danger">
                                <p><b>Note:</b> Create a employee before create new leave.</p>
                            </div>
                        </div>
                        <div class="box-body">
                            @csrf
                            @if($leave)  {{ method_field('PATCH') }} @endif
                            <div class="row">
                                @if(!$leave)
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="employee_id">Employee<span class="text-danger">*</span></label>
                                        {!! Form::select('employee_id', $employees, null , ['placeholder' => 'Pick a employee...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="leave_type">Leave Type<span class="text-danger">*</span></label>
                                        {!! Form::select('leave_type', AppHelper::LEAVE_TYPES, $leave_type , ['placeholder' => 'Pick a type...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                                    </div>
                                </div>
                                <div class=" @if(!$leave)col-md-2 @else col-md-4 @endif">
                                    <div class="form-group has-feedback">
                                        <label for="leave_date">Leave Date @if(!$leave)Start @endif<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control date_picker"  readonly name="leave_date" placeholder="date" value="@if($leave){{$leave->leave_date->format('d/m/Y')}}@else{{old('leave_date') }}@endif" required minlength="10" maxlength="10" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('leave_date') }}</span>
                                    </div>
                                </div>
                                    @if(!$leave)
                                    <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="leave_date_end">Leave Date end</label>
                                        <input type='text' class="form-control date_picker_with_clear"  readonly name="leave_date_end" placeholder="date" value="" minlength="10" maxlength="10" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('leave_date_end') }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="document">Document <span class="text-black">[max 2mb]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png, .pdf, .doc, .docx, .txt" name="document" placeholder="Leave paper">
                                        @if($leave && isset($leave->document))
                                            <input type="hidden" name="oldDocument" value="{{$leave->document}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback" style="top:25px;"></span>
                                        <span class="text-danger">{{ $errors->first('document') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-feedback">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control"  maxlength="500">@if($leave){{ $leave->description }}@endif</textarea>
                                        <span class="fa fa-location-arrow form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('hrm.leave.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa @if($leave) fa-refresh @else fa-plus-circle @endif"></i> @if($leave) Update @else Add @endif</button>

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
            Generic.initCommonPageJS();
        });
    </script>
@endsection
<!-- END PAGE JS-->
