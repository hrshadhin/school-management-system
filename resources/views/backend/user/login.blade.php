<!-- Master page  -->
@extends('backend.layouts.front_master')

<!-- Page title -->
@section('pageTitle') Login @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') login-page @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')

    @if (Session::has('success') || Session::has('error') || Session::has('warning'))
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert @if (Session::has('success')) alert-success @elseif(Session::has('error')) alert-danger @else alert-warning @endif alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @if (Session::has('success'))
                        <h5><i class="icon fa fa-check"></i>{{ Session::get('success') }}</h5>
                    @elseif(Session::has('error'))
                        <h5><i class="icon fa fa-ban"></i>{{ Session::get('error') }}</h5>
                    @else
                        <h5><i class="icon fa fa-warning"></i>{{ Session::get('warning') }}</h5>
                        @endif
                        </h5>
                </div>
            </div>
        </div>
    @endif
    <div class="login-box">
        <div class="login-logo">
            <a href="/">
                <img src="@if(isset($appSettings['institute_settings']['logo'])) {{asset('storage/logo/'.$appSettings['institute_settings']['logo'])}} @else {{ asset('images/logo-lg.png') }} @endif" alt="">
            </a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg text-danger">Use your username and password to Login</p>
            <form novalidate id="loginForm" action="{{URL::Route('login')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group has-feedback">
                    <input autofocus type="text" class="form-control" name="username" placeholder="username" required minlength="5" maxlength="255">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" required minlength="6" maxlength="255">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <span class="text-danger">{{ $errors->first('password') }}</span>

                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="checkbox icheck">
                            <label>
                                <input name="remember" type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <a href="{{URL::Route('forgot')}}" class="forgot-link">Forgot Password</a>
                    </div>
                    <!-- /.col -->
                </div>
                <br>
                <button type="submit" class="btn btn-lg btn-block btn-flat login-button">SIGN IN</button>
            </form>


        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        $(document).ready(function () {
            Login.init();
        });

    </script>
@endsection
<!-- END PAGE JS-->
