<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Sliders @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Sliders
            <small>Home page sliders</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Sliders</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">All sliders</h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('slider.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="sliders" class="table table-bordered table-striped list_view_table">
                            <thead>
                            <tr>
                                <th width="30%">Image</th>
                                <th width="30%">Title</th>
                                <th width="25%">Subtitle</th>
                                <th width="5%">Order</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>
                                        <img class="img-responsive" style="max-height: 200px;" src="{{ asset('storage/sliders')}}/{{ $slider->image }}" alt="">
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td> {{ $slider->subtitle }}</td>
                                    <td> {{ $slider->order }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('slider.edit',$slider->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <form class="myAction" method="POST" action="{{URL::route('slider.destroy',$slider->id)}}">
                                                {{ method_field('DELETE') }}
                                                @csrf
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
                                <th width="30%">Image</th>
                                <th width="30%">Title</th>
                                <th width="25%">Subtitle</th>
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
            Site.sliderInit();
            initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
