<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Gallery @endsection
<!-- End block -->

<!-- Page Extra CSS -->
@section('extraStyle')
    <style>
        .thumbnail img {
            opacity: 1;
            display: block;
            width: 100%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
            max-height: 300px;
            min-height: 300px;
        }
        .thumbnail .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }
        .thumbnail:hover img {
            opacity: 0.3;
        }
        .thumbnail:hover .middle {
            opacity: 1;
        }
        .thumbnail:hover .middle .remove-image {
            color: #ff0000;
        }
    </style>
@endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Gallery
            <small>Images</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-camera"></i> Gallery</a></li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Images</h3>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('site.gallery_image') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($images as $image)
                                    <div class="col-xs-6 col-md-3 thumbnail">
                                        <img class="img-responsive" src="{{asset('storage/gallery/'.$image->meta_value)}}" alt="image">
                                        <div class="middle">
                                            <a href="#0" data-id="{{$image->id}}" class="remove-image" title="Delete Image" ><i class="fa fa-5x fa-remove"></i> </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        {{ $images->links() }}
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
            window.postUrl = '{{URL::Route("site.gallery_image_delete", 0)}}';
            Site.galleryInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->
