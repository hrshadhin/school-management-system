<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Analytics @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Analytics
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Analytics</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form  id="analyTicsSettingForm" action="{{URL::Route('site.analytics')}}" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">Google Analytics <span class="text-danger"> * Marks are required feild</span></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="ga_tracking_id">Tracking Id<span class="text-danger">*</span></label>
                                <input type="text" name="ga_tracking_id" class="form-control" placeholder="" value="@if($info->ga_tracking_id){{ $info->ga_tracking_id }}@endif" maxlength="255" required />
                                <span class="fa fa-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('ga_tracking_id') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="ga_report_id">Report View Id<span class="text-danger">*</span></label>
                                <input type="text" name="ga_report_id" class="form-control" placeholder="" value="@if($info->ga_id){{ $info->ga_id }}@endif" maxlength="255" required />
                                <span class="fa fa-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('ga_report_id') }}</span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="ga_key_file">Service Account Json Key File<span class="text-danger">*</span></label>
                                <input  type="file" class="form-control" accept=".json" name="ga_key_file" required>
                                <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('ga_key_file') }}</span>
                                @if($info->key_file) <span class="text-info">{{ $info->key_file }}</span> @endif

                            </div>



                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('site.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>

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
            Site.AnalyticsInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->

