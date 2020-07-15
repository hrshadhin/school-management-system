<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Leave @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Leave
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Leave</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header border">
                        <h3 class="text-info" style="margin-left: 10px;">Filters</h3>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('hrm.leave.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get" enctype="multipart/form-data">
                                    <input type="hidden" name="filter" value="1">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group has-feedback">
                                                {!! Form::select('employee_id', $employees, $employee , ['class' => 'form-control select2']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group has-feedback">
                                                {!! Form::select('leave_type', array_merge([0 => "All"] , AppHelper::LEAVE_TYPES), $leave_type , ['class' => 'form-control select2',]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group has-feedback">
                                                <input type='text' class="form-control date_picker_with_clear"  readonly name="leave_date" placeholder="date" value="@if($leave_date){{$leave_date}} @endif" required minlength="10" maxlength="10" />
                                                <span class="fa fa-calendar form-control-feedback"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group has-feedback">
                                                {!! Form::select('status', [0=> "All", 1=> 'Pending', 2 => 'Aprroved', 3=> 'Rejected' ], $status , ['class' => 'form-control select2',]) !!}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-list"></i> Get List</button>

                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Employee</th>
                                    <th width="10%">Type</th>
                                    <th width="10%">Date</th>
                                    <th class="notexport" width="5%">Document</th>
                                    <th width="20%">Note</th>
                                    <th width="5%">Status</th>
                                    <th class="notexport" width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leaves as $leave)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $leave->employee->name }}</td>
                                        <td>{{ $leave->leave_type }}</td>
                                        <td>{{ $leave->leave_date->format('d/m/Y') }}</td>
                                        <td>
                                            @if($leave->document)
                                                <a target="_blank" href="{{asset('storage/leave/'.$leave->document)}}" class="btn btn-link"> <i class="fa fa-2x fa-download"></i></a>
                                            @endif
                                        </td>
                                        <td>{{ $leave->description }}</td>
                                        <td>
                                            @if($leave->status ==1)
                                                <span class="badge bg-yellow">Pending</span>
                                            @elseif($leave->status == 2)
                                                <span class="badge bg-green">Approved</span>
                                            @else
                                                <span class="badge bg-red">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- todo: have problem in mobile device -->
                                            @if($leave->status == 1)
                                                <div class="btn-group">
                                                    <form  class="" method="POST" action="{{URL::route('hrm.leave.update',$leave->id)}}">
                                                        @csrf
                                                        {{ method_field('PATCH') }}
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="update_status" value="1">
                                                        <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                            <i class="fa fa-fw fa-check"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="btn-group">
                                                    <form  class="" method="POST" action="{{URL::route('hrm.leave.update',$leave->id)}}">
                                                        @csrf
                                                        {{ method_field('PATCH') }}
                                                        <input type="hidden" name="status" value="3">
                                                        <input type="hidden" name="update_status" value="1">
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                                            <i class="fa fa-fw fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="btn-group">
                                                    <a title="Edit"  href="{{URL::route('hrm.leave.edit',$leave->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('hrm.leave.destroy',$leave->id)}}">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <input type="hidden" name="hiddenId" value="{{$leave->id}}">
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
                                    <th width="25%">Employee</th>
                                    <th width="10%">Type</th>
                                    <th width="10%">Date</th>
                                    <th class="notexport" width="5%">Document</th>
                                    <th width="20%">Note</th>
                                    <th width="5%">Status</th>
                                    <th class="notexport" width="20%">Action</th>
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
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
