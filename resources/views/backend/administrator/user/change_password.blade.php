<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Reset User Password @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Main content -->
    <section class="content-header">
        <h1>
            Reset User Password
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Reset User Password</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- Change password -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reset Password</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form novalidate id="changePasswordForm" action="{{URL::route('administrator.user_password_reset')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="role_id">User
                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Set a user"></i>
                                </label>
                                {!! Form::select('user_id', $users, null , ['placeholder' => 'Pick a user...','class' => 'form-control select2', 'required' => 'true']) !!}
                                <span class="form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('user_id') }}</span>
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
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> Reset</button>
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
            Login.resetPassword();
            $('.select2').select2();
        });
    </script>
@endsection
<!-- END PAGE JS-->
