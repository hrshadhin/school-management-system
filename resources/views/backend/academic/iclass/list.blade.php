<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Class @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Class
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Class</li>
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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('academic.class_create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                        <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Name</th>
                                <th width="5%">Numeric Value</th>
                                <th width="8%">Order</th>
                                <th width="7%">Group</th>
                                <th width="5%">Duration</th>
                                <th width="5%">Have Selective</th>
                                <th width="5%">Max Selective</th>
                                <th width="5%">Have Elective</th>
                                <th width="10%">Note</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($iclasses as $iclass)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>{{ $iclass->name }}</td>
                                    <td>{{ $iclass->numeric_value }}</td>
                                    <td>{{ $iclass->order }}</td>
                                    <td>{{ $iclass->group }}</td>
                                    <td>
                                        {{$iclass->duration}} @if($iclass->duration > 1){{'years'}} @else {{'year'}}@endif
                                    </td>
                                    <td>
                                        @if($iclass->have_selective_subject)
                                            <span class="badge bg-green">Yes</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$iclass->max_selective_subject}}
                                    </td>
                                    <td>
                                        @if($iclass->have_elective_subject)
                                            <span class="badge bg-green">Yes</span>
                                        @endif
                                    </td>
                                    <td>{{ $iclass->note }}</td>
                                    <td>
                                        <!-- todo: have problem in mobile device -->
                                        <input class="statusChange" type="checkbox" data-pk="{{$iclass->id}}" @if($iclass->status) checked @endif data-toggle="toggle" data-on="<i class='fa fa-check-circle'></i>" data-off="<i class='fa fa-ban'></i>" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('academic.class_edit',$iclass->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            </a>
                                        </div>
                                        <!-- todo: have problem in mobile device -->
                                        <div class="btn-group">
                                            <form  class="myAction" method="POST" action="{{URL::route('academic.class_destroy')}}">
                                                @csrf
                                                <input type="hidden" name="hiddenId" value="{{$iclass->id}}">
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
                                <th width="25%">Name</th>
                                <th width="5%">Numeric Value</th>
                                <th width="8%">Order</th>
                                <th width="7%">Group</th>
                                <th width="5%">Duration</th>
                                <th width="5%">Have Selective</th>
                                <th width="5%">Max Selective</th>
                                <th width="5%">Have Elective</th>
                                <th width="10%">Note</th>
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
            window.postUrl = '{{URL::Route("academic.class_status", 0)}}';
            Academic.iclassInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
