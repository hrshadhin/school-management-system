<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') HR Policy @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Policy Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Policy Settings</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form  id="entryForm" action="{{URL::Route('hrm.policy')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Leave Policy</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="total_casual_leave">Total Causal Leave<span class="text-danger">*</span></label>
                                        <input autofocus type="number" name="total_casual_leave" class="form-control" placeholder="11" value="@if(isset($metas['total_casual_leave'])){{ $metas['total_casual_leave'] }}@endif" min="0" required />
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('total_casual_leave') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="total_sick_leave">Total Sick Leave<span class="text-danger">*</span></label>
                                        <input type="number" name="total_sick_leave" class="form-control" placeholder="10" value="@if(isset($metas['total_sick_leave'])){{ $metas['total_sick_leave'] }}@endif" min="0" required />
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('total_sick_leave') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="total_maternity_leave">Total Maternity Leave<span class="text-danger">*</span></label>
                                        <input type="number" name="total_maternity_leave" class="form-control" placeholder="90" value="@if(isset($metas['total_maternity_leave'])){{ $metas['total_maternity_leave'] }}@endif" min="0" required />
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('total_maternity_leave') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label for="total_special_leave">Total Special Leave<span class="text-danger">*</span></label>
                                        <input type="number" name="total_special_leave" class="form-control" placeholder="5" value="@if(isset($metas['total_special_leave'])){{ $metas['total_special_leave'] }}@endif" min="0" required />
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('total_special_leave') }}</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box">
                        <div class="box-footer">
                            <a href="{{URL::route('user.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>
                        </div>
                    </div>

                </form>
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

