<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') 500 @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Internal Server Error
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="#"><i class="fa fa-warning"></i> 500</a></li>
        </ol>
    </section>
    <!-- ./header -->

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">500</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
                <p>
                    We will work on fixing that right away.<br>
                    Meanwhile, you may <a href="{{URL::route('user.dashboard')}}">return to dashboard</a>
                </p>
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- ./content -->
@endsection
<!-- END PAGE CONTENT-->

