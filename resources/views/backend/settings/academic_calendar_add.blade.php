<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Academic Calendar @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Academic Calendar
            <small>Add</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('settings.academic_calendar.index')}}"><i class="fa fa-lightbulb-o"></i> Academic Calendar</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="@if($calendar) {{URL::Route('settings.academic_calendar.update', $calendar->id)}} @else{{URL::Route('settings.academic_calendar.store')}}@endif" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="box-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label for="title">Title<span class="text-danger">*</span></label>
                                            <input type='text' class="form-control"  name="title" placeholder="" value="@if($calendar){{$calendar->title}}@endif" required minlength="1" maxlength="255" />
                                            <span class="fa fa-info form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group has-feedback">
                                            <label for="date_from">Date From<span class="text-danger">*</span></label>
                                            <input type='text' class="form-control date_picker_with_disable_days"  readonly name="date_from" placeholder="date" value="@if($calendar){{$calendar->date_from->format('d/m/Y')}}@endif" required minlength="10" maxlength="10" />
                                            <span class="fa fa-calendar form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('date_from') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group has-feedback">
                                            <label for="date_upto">Date Upto</label>
                                            <input type='text' class="form-control date_picker_with_disable_days"  readonly name="date_upto" placeholder="date" value="@if($calendar){{$calendar->date_upto->format('d/m/Y')}}@endif"  minlength="10" maxlength="10" />
                                            <span class="fa fa-calendar form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('date_upto') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group has-feedback">
                                            <label for="is_holiday">Is Holiday?
                                                <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="If its holiday then check it."></i>
                                                <div class="checkbox icheck">
                                                    <label>
                                                        {!! Form::checkbox('is_holiday', $is_holiday, $is_holiday) !!}
                                                    </label>
                                                </div>
                                            </label>
                                            <span class="text-danger">{{ $errors->first('is_holiday') }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group has-feedback">
                                                <label for="is_exam">Is Exam?
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="If its exam then check it."></i>
                                                    <div class="checkbox icheck">
                                                        <label>
                                                            {!! Form::checkbox('is_exam', $is_exam, $is_exam) !!}
                                                        </label>
                                                    </div>
                                                </label>
                                                <span class="text-danger">{{ $errors->first('is_exam') }}</span>
                                            </div>
                                        </div>
                                        @if(AppHelper::getInstituteCategory() == 'college')
                                            <div class="col-md-3" >
                                                <div class="form-group has-feedback">
                                                    <label for="class_id">Class</label>
                                                    {!! Form::select('class_id[]', $classes, $class_id , ['class' => 'form-control select2', 'multiple'=>'true']) !!}
                                                    <span class="form-control-feedback"></span>
                                                    <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                        <div class="row">
                                    <div class="col-md-12">
                                            <div class="form-group has-feedback">
                                                <label for="description">Description</label>
                                                <textarea name="description" class="form-control" minlength="5" maxlength="500">@if($calendar){{$calendar->description}}@endif</textarea>
                                                <span class="fa fa-location-arrow form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                            </div>
                                    </div>
                                </div>

                    </div>
                    <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('settings.academic_calendar.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa @if($calendar) fa-refresh @else fa-plus-circle @endif"></i> @if($calendar) Update @else Add @endif</button>
                        </div>
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
        window.disableWeekDays = @php echo $weekends @endphp;
        $(document).ready(function () {
            Generic.initCommonPageJS();
            if(institute_category == 'college') {
                $('input[name="is_exam"]').on('ifChecked ifUnchecked', function (event) {
                    if (event.type == 'ifChecked') {
                        $('select[name="class_id[]"]').prop('required', true);
                    } else {

                        $('select[name="class_id[]"]').prop('required', false);
                        $('select[name="class_id[]"]').val('').trigger('change');
                    }
                });
            }
        });
    </script>
@endsection
<!-- END PAGE JS-->
