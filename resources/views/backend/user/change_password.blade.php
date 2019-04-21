<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Change Password @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Main content -->
    <section class="content-header">
        <h1>
            Change Password
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- Change password -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Password</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form novalidate id="changePasswordForm" action="{{URL::Route('change_password')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" name="old_password" placeholder="Old Password" required minlength="6" maxlength="50">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('old_password') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required minlength="6" maxlength="50">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required minlength="6" maxlength="50">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            </div>

                            <br>
                            <a href="{{URL::route('user.dashboard')}}" class="btn btn-default btnCancel">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> Update</button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
                <div class="col-md-3"></div>

                <!-- /.box -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        $(document).ready(function () {
            Login.changePassword();
        });
    </script>
@endsection
<!-- END PAGE JS-->
