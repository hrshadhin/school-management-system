<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Gallery @endsection
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
            <small>Image</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('site.gallery')}}"><i class="fa fa-camera"></i> Gallery</a></li>
            <li class="active">Image</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Image</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12">
                                <form  action="{{URL::Route('site.gallery_image')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group has-feedback">
                                        <label for="image">Image <span class="text-danger">*</span> </label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="image" placeholder="image" required>
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-info pull-right"><i class="fa fa-upload"></i> Upload</button>
                                </form>

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

