<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Academic Year @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Academic Year
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Academic Year</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('administrator.academic_year_create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                        <table id="listTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Title</th>
                                <th width="20%">Start Date</th>
                                <th width="20%">End Date</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($academicYears as $year)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>{{ $year->title }}</td>
                                    <td> {{ $year->start_date->format('d/m/Y') }}</td>
                                    <td> {{ $year->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        <!-- todo: have problem in mobile device -->
                                        <input class="statusChange" type="checkbox" data-pk="{{$year->id}}" @if($year->status) checked @endif data-toggle="toggle" data-on="<i class='fa fa-check-circle'></i>" data-off="<i class='fa fa-ban'></i>" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('administrator.academic_year_edit',$year->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            </a>
                                        </div>
                                        <!-- todo: have problem in mobile device -->
                                        <div class="btn-group">
                                            <form  class="myAction" method="POST" action="{{URL::route('administrator.academic_year_destroy')}}">
                                                @csrf
                                                <input type="hidden" name="hiddenId" value="{{$year->id}}">
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
                                <th width="5%">#</th>
                                <th width="35%">Title</th>
                                <th width="20%">Start Date</th>
                                <th width="20%">End Date</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="10%">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
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
            window.postUrl = '{{URL::Route("administrator.academic_year_status", 0)}}';
            Administrator.academicYearInit();
            initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
