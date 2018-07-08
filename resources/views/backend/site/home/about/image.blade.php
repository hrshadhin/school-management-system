<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') About Us @endsection
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
            About Us
            <small>Images</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('site.about_content')}}"><i class="fa fa-info"></i> About Us</a></li>
            <li class="active">Images</li>
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
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12">
                                <form  action="{{URL::Route('site.about_content_image')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group has-feedback">
                                        <label for="image">Image</label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="image" placeholder="image" required>
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="order">Order</label>
                                        <input  type="number" class="form-control" name="order" placeholder="0,1,5" value="{{ old('order',0) }}" required min="0">
                                        <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-info pull-right"><i class="fa fa-upload"></i> Upload</button>
                                </form>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($images as $image)
                                    <div class="col-xs-6 col-md-3 thumbnail">
                                        <img src="{{asset('storage/about/'.$image->image)}}" alt="image">
                                        <div class="middle">
                                            <a href="#0" data-id="{{$image->id}}" class="remove-image" title="Delete Image" ><i class="fa fa-5x fa-remove"></i> </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->

                    </form>
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
            window.postUrl = '{{URL::Route("site.about_content_image_delete", 0)}}';
            Site.aboutInit();


        });
    </script>
@endsection
<!-- END PAGE JS-->
