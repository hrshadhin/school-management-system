<!-- Master page  -->
@extends('backend.layouts.front_master')

<!-- Page title -->
@section('pageTitle') Reset Password @endsection
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
                <img src="{{ asset('images/logo.png') }}" alt="">
            </a>
        </div>        
        <div class="login-box-body">        
            <p class="login-box-msg">Fill up the form correctly</p>
            <form novalidate id="resetForm" action="{{URL::Route('login')}}" method="post" enctype="multipart/form-data">
            @csrf
                
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required minlength="6" maxlength="255">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="repassword" placeholder="Confirm Password" required minlength="6" maxlength="255">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <span class="text-danger">{{ $errors->first('repassword') }}</span>
                </div>
                
                <div class="row">                   
                <div class="col-xs-6">
                    <a href="{{URL::Route('login')}}" class="login-link">Let me login</a>                        
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-lg btn-block btn-flat login-button">RESET PASSWORD</button>
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
            Login.reset();            
        });

</script>
@endsection
<!-- END PAGE JS-->
