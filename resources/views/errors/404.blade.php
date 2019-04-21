<!-- Master page  -->
@extends('backend.layouts.error_master')

<!-- Page title -->
@section('pageTitle') 404 @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow">404</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                <p>
                    We could not find the page you were looking for.<br>
                    Meanwhile, you may <a href="/">return to home</a>
                </p>
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- ./content -->
@endsection
<!-- END PAGE CONTENT-->