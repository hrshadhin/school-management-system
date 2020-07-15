<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Profile @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Main content -->
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">User profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/avatar.jpg') }}" alt="User profile picture">
                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                        <p class="text-muted text-center">{{$userRole->name}}</p>

                        @if($user->is_super_admin)
                            <blockquote class="blockquote text-center bg-warning">
                                <p class="mb-0">You Are Super Admin!</p>
                                <footer class="blockquote-footer"><cite>With great power comes great responsibility</cite></footer>
                            </blockquote>
                        @endif
                        <strong><i class="fa fa-user margin-r-5"></i>Username</strong>
                        <p class="text-muted">{{$user->username}}</p>

                        <hr>
                        <strong><i class="fa fa-info-circle margin-r-5"></i>Full name</strong>
                        <p class="text-muted">
                            {{$user->name}}
                        </p>

                        <hr>
                        <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
                        <p class="text-muted">{{$user->email}}</p>

                        <hr>
                        <strong><i class="fa fa-phone margin-r-5"></i> Phone no</strong>
                        <p class="text-muted">{{$user->phone_no}}</p>

                        <hr>

                        <strong><i class="fa fa-clock-o margin-r-5"></i>Created At</strong>
                        <p class="text-muted">{{date('F j,Y', strtotime($user->created_at))}}</p>
                        <a href="#" class="btn btn-primary btn-block btnUpdate"><b>Update</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- About Me Box -->
                <div class="box box-primary" @if(!$isPost)style="display: none;" @endif id="profileUpdate">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form novalidate id="profileUpdateForm" action="{{URL::Route('profile')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group has-feedback">
                                <input autofocus  type="text" class="form-control" value="{{$user->name}}" name="name" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info-sign form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <input  type="email" class="form-control" value="{{$user->email}}" name="email" required maxlength="255">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                                <div class="form-group has-feedback">
                                    <input  type="text" class="form-control" name="phone_no" placeholder="phone or mobile number" value="{{$user->phone_no}}" maxlength="15">
                                    <span class="fa fa-phone form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                </div>

                            <div class="form-group has-feedback">
                                <input  type="text" class="form-control" value="{{$user->username}}" name="username" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            </div>


                            <br>
                            <a href="#" class="btn btn-default btnCancel">Cancel</a>
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
            Login.profileUpdate();
        });
    </script>
@endsection
<!-- END PAGE JS-->
