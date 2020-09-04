<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') FAQ @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Timeline
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Timeline</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Timeline <span class="text-danger"> * Marks are required feild</span></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <form  id="timeLineForm" action="{{URL::Route('site.timeline')}}" method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="form-group has-feedback">
                                <label for="title">Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="type" value="{{old('title')}}" maxlength="255" required />
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="description">Description<span class="text-danger">*</span></label>
                                <textarea  name="description" class="form-control" required minlength="5" maxlength="500" >{{ old('description') }}</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                                <div class="form-group has-feedback">
                                    <label for="year">Year<span class="text-danger">*</span></label>
                                    <input type='text' class="form-control year"  readonly name="year" placeholder="2018" value="{{ old('year') }}" required minlength="4" maxlength="4" />
                                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('year') }}</span>
                                </div>
                            <div class="form-group">
                                <a href="{{URL::route('site.dashboard')}}" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>

                            </div>
                            <hr>
                    </form>
                            <table id="timeLineList" class="table table-bordered table-striped list_view_table">
                                <thead>
                                <tr>
                                    <th width="30%">Title</th>
                                    <th width="50%">Description</th>
                                    <th width="10%">Year</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($timeline as $line)
                                    @php
                                     $l = json_decode($line->meta_value);
                                    @endphp
                                    <tr>

                                        <td>{{ $l->t }}</td>
                                        <td>{{ $l->d }}</td>
                                        <td>{{ $l->y }}</td>

                                        <td>
                                            <div class="btn-group">
                                                <form class="myAction" method="POST" action="{{URL::route('site.timeline_delete',$line->id)}}">
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
                                    <th width="30%">Title</th>
                                    <th width="50%">Description</th>
                                    <th width="10%">Year</th>
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
    <!-- editor js -->

    <script type="text/javascript">
        $(document).ready(function () {
            Site.timeLineInit();
            initDeleteDialog();
            $(".year").datetimepicker({
                format: "YYYY",
                viewMode: 'years',
                ignoreReadonly: true,
                useCurrent: false
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->

