<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Testimonial @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Testimonial
            <small>add new testimonial</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('site.testimonial')}}"><i class="fa fa-picture-o"></i> Testimonial</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="testimonialAddForm" action="{{URL::Route('site.testimonial_create')}}" method="post" enctype="multipart/form-data">
                    <div class="box-header">
                        <h3 class="box-title">Add new testimonial</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="writer">Writer<span class="text-danger">*</span></label></label>
                                <input autofocus type="text" class="form-control" name="writer" placeholder="name of the person who comments" value="{{ old('writer') }}" required minlength="5" maxlength="255">
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('writer') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="subtitle">Comments<span class="text-danger">*</span></label></label>
                                <textarea  name="comments" class="form-control" required >{{ old('comments') }}</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('comments') }}</span>
                            </div>
                        <div class="form-group has-feedback">
                            <label for="photo">Photo<span class="text-danger">[94 X 94 size and max 2MB]</span></label></label>
                            <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="photo" placeholder="image">
                            <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('photo') }}</span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="order">Order</label>
                            <input  type="number" class="form-control" name="order" placeholder="0,1,5" value="{{ old('order',0) }}" required min="0">
                            <span class="glyphicon glyphicon-info form-control-feedback"></span>
                            <span class="text-danger">{{ $errors->first('order') }}</span>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{URL::route('site.testimonial')}}" class="btn btn-default">Cancel</a>
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
            Site.testimonialInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
