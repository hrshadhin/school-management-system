<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Statistic @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Statistic
            <small>Content</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Statistic</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form  id="serviceContentForm" action="{{URL::Route('site.statistic')}}" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">Statistic <span class="text-danger"> * Marks are required feild</span></h3>

                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="student">Students<span class="text-danger">*</span></label>
                                <input type="number" autofocus name="student" class="form-control" required min="1" required value="@if($content){{ $content->student }}@endif"></input>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('student') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="teacher">Teachers<span class="text-danger">*</span></label>
                                <input type="number" autofocus name="teacher" class="form-control" required min="1" required value="@if($content){{ $content->teacher }}@endif"></input>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('teacher') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="graduate">Passing To College<span class="text-danger">*</span></label>
                                <input type="number" autofocus name="graduate" class="form-control" required min="1" required value="@if($content){{ $content->graduate }}@endif"></input>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('graduate') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="books">Books In Library<span class="text-danger">*</span></label>
                                <input type="number" autofocus name="books" class="form-control" required min="1" required value="@if($content){{ $content->books }}@endif"></input>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('books') }}</span>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('site.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

