<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Subject @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Subject
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Subject</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    @notrole('Student')
                    <div class="box-header">
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::select('class_id', $classes, $iclass , ['placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true', 'id' => 'class_id_filter']) !!}
                            </div>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('academic.subject_create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    @endnotrole
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                        <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Name</th>
                                <th width="10%">Code</th>
                                <th width="5%">Type</th>
                                <th width="15%">Class</th>
                                <th width="20%">Teacher</th>
                                <th width="5%">Order</th>
                                @notrole('Student')
                                <th width="5%" title="Exclude In Result">EIR</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="10%">Action</th>
                                @endnotrole
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ $subject->type }}</td>
                                    <td>{{ $subject->class->name }}</td>
                                    <td class="text-capitalize">
                                        {{ implode(',', $subject->teachers->pluck('name')->toArray()) }}
                                    </td>
                                    <td>{{ $subject->order }}</td>
                                    @notrole('Student')
                                    <td>
                                        @if($subject->exclude_in_result)
                                            <i class="fa fa-2x fa-check-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- todo: have problem in mobile device -->
                                        <input class="statusChange" type="checkbox" data-pk="{{$subject->id}}" @if($subject->status) checked @endif data-toggle="toggle" data-on="<i class='fa fa-check-circle'></i>" data-off="<i class='fa fa-ban'></i>" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('academic.subject_edit',$subject->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            </a>
                                        </div>
                                        <!-- todo: have problem in mobile device -->
                                        <div class="btn-group">
                                            <form  class="myAction" method="POST" action="{{URL::route('academic.subject_destroy')}}">
                                                @csrf
                                                <input type="hidden" name="hiddenId" value="{{$subject->id}}">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                    @endnotrole
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Name</th>
                                <th width="10%">Code</th>
                                <th width="5%">Type</th>
                                <th width="15%">Class</th>
                                <th width="20%">Teacher</th>
                                <th width="5%">Order</th>
                                @notrole('Student')
                                <th width="5%" title="Exclude In Result">EIR</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="10%">Action</th>
                                @endnotrole
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
            window.postUrl = '{{URL::Route("academic.subject_status", 0)}}';
            Academic.subjectInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
