<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Slider Add @endsection
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
            <small>Home page slider</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('slider.index')}}"><i class="fa fa-picture-o"></i> Sliders</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="sliderAddForm" action="{{URL::Route('slider.store')}}" method="post" enctype="multipart/form-data">
                    <div class="box-header">
                        <h3 class="box-title">Add slider<span class="text-danger"> * Marks are required feild</span></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="title">Title<span class="text-danger">*</span></label>
                                <input autofocus type="text" class="form-control" name="title" placeholder="title" value="{{ old('title') }}" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="subtitle">Sub Title<span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" name="subtitle" placeholder="subtitle" value="{{ old('subtitle') }}" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('subtitle') }}</span>
                            </div>
                        <div class="form-group has-feedback">
                            <label for="image">Image<span class="text-danger">[1900 X 1200 min size and max 2MB] *</span></label>
                            <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="image" placeholder="image" required>
                            <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="order">Order<span class="text-danger">*</span></label>
                            <input  type="number" class="form-control" name="order" placeholder="0,1,5" value="{{ old('order',0) }}" required min="0">
                            <span class="glyphicon glyphicon-info form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('order') }}</span>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{URL::route('slider.index')}}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> Add</button>

                    </div>
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
            Site.sliderInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
