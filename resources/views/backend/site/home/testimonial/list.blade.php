<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Testimonials @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Testimonials
            <small>Testimonial List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Testimonials</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">All Testimonials</h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('site.testimonial_create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="testimonials" class="table table-bordered table-striped list_view_table">
                            <thead>
                            <tr>
                                <th width="15%">Photo</th>
                                <th width="20%">Writer</th>
                                <th width="50%">Comments</th>
                                <th width="5%">Order</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($testimonials as $test)
                                <tr>
                                    <td>
                                        <img class="img-responsive center" style="max-height: 200px;" src="@if($test->photo ){{ asset('storage/testimonials')}}/{{ $test->photo }} @else {{ asset('images/avatar.jpg')}} @endif" alt="">
                                    </td>
                                    <td>{{ $test->writer }}</td>
                                    <td> {{ $test->comments }}</td>
                                    <td> {{ $test->order }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <form  class="myAction" method="POST" action="{{URL::route('site.testimonial')}}">
                                                @csrf
                                                <input type="hidden" name="hiddenId" value="{{$test->id}}">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="15%">Photo</th>
                                <th width="20%">Writer</th>
                                <th width="50%">Comments</th>
                                <th width="5%">Order</th>
                                <th width="10%">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
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
            Site.testimonialInit();
            initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
