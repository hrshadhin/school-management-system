<!-- Master page  -->
@extends('backend.layouts.error_master')

<!-- Page title -->
@section('pageTitle') 500 @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">500</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
                <p>
                    We will work on fixing that right away.<br>
                    Meanwhile, you may <a href="/">return to home</a>
                </p>
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- ./content -->
@endsection
<!-- END PAGE CONTENT-->

