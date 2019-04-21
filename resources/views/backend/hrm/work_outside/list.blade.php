<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle')  Work Outside @endsection
<!-- End block -->



<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Work Outside
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Work Outside</li>
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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('hrm.work_outside.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
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
                                        <div class="col-md-2">
                                            <div class="form-group has-feedback">
                                                <input type='text' class="form-control date_picker_with_clear"  readonly name="work_date" placeholder="date" value="@if($work_date){{$work_date}} @endif" required minlength="10" maxlength="10" />
                                                <span class="fa fa-calendar form-control-feedback"></span>
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
                                    <th width="30%">Employee</th>
                                    <th width="10%">Date</th>
                                    <th class="notexport" width="5%">Document</th>
                                    <th width="30%">Note</th>
                                    <th class="notexport" width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($works as $work)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $work->employee->name }}</td>
                                        <td>{{ $work->work_date->format('d/m/Y') }}</td>
                                        <td>
                                            @if($work->document)
                                                <a target="_blank" href="{{asset('storage/work_outside/'.$work->document)}}" class="btn btn-link"> <i class="fa fa-2x fa-download"></i></a>
                                            @endif
                                        </td>
                                        <td>{{ $work->description }}</td>

                                        <td>
                                            <!-- todo: have problem in mobile device -->
                                                <div class="btn-group">
                                                    <a title="Edit"  href="{{URL::route('hrm.work_outside.edit',$work->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                    </a>
                                                </div>

                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('hrm.work_outside.destroy',$work->id)}}">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <input type="hidden" name="hiddenId" value="{{$work->id}}">
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
                                    <th width="30%">Employee</th>
                                    <th width="10%">Date</th>
                                    <th class="notexport" width="5%">Document</th>
                                    <th width="30%">Note</th>
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
            window.excludeFilterComlumns = [0,3,4,5];
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
