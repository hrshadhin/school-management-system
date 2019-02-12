<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Holiday @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Holiday
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-lightbulb-o"></i> Holiday</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">
                        <fieldset>
                            <legend>Add Form</legend>
                            <form novalidate id="entryForm" action="{{URL::Route('academic.holiday')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @if(AppHelper::getInstituteCategory() == 'college')
                                        <div class="col-md-3">
                                            <div class="form-group has-feedback">
                                                <label for="academic_year">Academic Year<span class="text-danger">*</span></label>
                                                {!! Form::select('academic_year_id', $academic_years, null , ['placeholder' => 'Pick a year...','class' => 'form-control select2', 'required' => 'true']) !!}
                                                <span class="form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-2">
                                        <div class="form-group has-feedback">
                                            <label for="holi_date">Holiday Date Start<span class="text-danger">*</span></label>
                                            <input type='text' class="form-control date_picker"  readonly name="holi_date" placeholder="date" value="" required minlength="10" maxlength="10" />
                                            <span class="fa fa-calendar form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('holi_date') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group has-feedback">
                                            <label for="holi_date_end">Holiday Date end</label>
                                            <input type='text' class="form-control date_picker"  readonly name="holi_date_end" placeholder="date" value="" required minlength="10" maxlength="10" />
                                            <span class="fa fa-calendar form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('holi_date_end') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group has-feedback">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control" minlength="5" maxlength="500"></textarea>
                                            <span class="fa fa-location-arrow form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> Add</button>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                        <fieldset>
                            <legend>List</legend>
                                @if(AppHelper::getInstituteCategory() == 'college')
                                <form id="filterForm" action="" method="get" enctype="multipart/form-data">
                                <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group has-feedback">
                                                <label for="academic_year">Academic Year<span class="text-danger">*</span></label>
                                                {!! Form::select('academic_year_id', $academic_years, $academic_year , ['placeholder' => 'Pick a year...','class' => 'form-control select2 academic_year_filter', 'required' => 'true']) !!}
                                                <span class="form-control-feedback"></span>
                                                <span class="text-danger">{{ $errors->first('academic_year') }}</span>
                                            </div>
                                        </div>
                                </div>
                                </form>
                                    @endif

                            <div class="table-responsive">
                                <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Date</th>
                                        <th width="65%">Description</th>
                                        <th class="notexport" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($holidays as $holiday)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>{{ $holiday->holi_date->format('d/m/Y') }}</td>
                                            <td>{{ $holiday->description }}</td>
                                            <td>
                                                <!-- todo: have problem in mobile device -->
                                                <div class="btn-group">
                                                    <form  class="myAction" method="POST" action="{{URL::route('academic.holiday_destroy',$holiday->id)}}">
                                                        @csrf
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
                                        <th width="20%">Date</th>
                                        <th width="65%">Description</th>
                                        <th class="notexport" width="10%">Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>

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
        window.excludeFilterComlumns = [0,2,3];
        $(document).ready(function () {
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
            $('select.academic_year_filter').change(function () {
               $('#filterForm').submit();
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
