<!-- Master page  -->
@extends('backend.layouts.front_master')

<!-- Page title -->
@section('pageTitle') Lock Screen @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') hold-transition lockscreen @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="/">
                <img src="@if(isset($appSettings['institute_settings']['logo'])) {{asset('storage/logo/'.$appSettings['institute_settings']['logo'])}} @else {{ asset('images/logo-sm.png') }} @endif" alt="">
            </a>
        </div>
        <!-- User name -->
        <div class="lockscreen-name">{{$name}}</div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img src="{{ asset('images/avatar.jpg') }}" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <form class="lockscreen-credentials" action="{{URL::route('login')}}" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <input autofocus type="password" name="password" class="form-control" placeholder="password" required>
                    <input  type="hidden" class="form-control" name="username" value="{{$username}}">
                    <input name="remember" type="hidden" value="1">

                    @csrf
                    <div class="input-group-btn">
                        <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                    </div>
                </div>
            </form>
            <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="text-center">
            <a href="{{URL::route('login')}}">Or sign in as a different user</a>
        </div>
        <div class="lockscreen-footer text-center">
            @if (Session::has('success') || Session::has('error') || Session::has('warning'))
                <div class="row">
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
            @endif
        </div>
    </div>
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        $(document).ready(function () {

        });

    </script>
@endsection
<!-- END PAGE JS-->
