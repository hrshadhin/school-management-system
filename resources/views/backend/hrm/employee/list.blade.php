<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Employee @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Employee
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Employee</li>
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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('hrm.employee.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                        <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th class="notexport" width="10%">Photo</th>
                                <th width="10%">ID Card</th>
                                <th width="25%">Name</th>
                                <th width="10%">Phone No</th>
                                <th width="10%">Type</th>
                                <th width="5%">Order</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>

                                    <td>
                                        <img class="img-responsive center" style="height: 35px; width: 35px;" src="@if($employee->photo ){{ asset('storage/employee')}}/{{ $employee->photo }} @else {{ asset('images/avatar.jpg')}} @endif" alt="">
                                    </td>
                                    <td>{{ $employee->id_card }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->phone_no }}</td>
                                    <td>{{ $employee->role->name }}</td>
                                    <td>{{$employee->order}}</td>
                                    <td>
                                        @if($employee->role->id == AppHelper::USER_TEACHER)
                                            <input disabled="disabled" type="checkbox" @if($employee->status) checked @endif data-toggle="toggle" data-on="<i class='fa fa-check-circle'></i>" data-off="<i class='fa fa-ban'></i>" data-onstyle="success" data-offstyle="danger">

                                        @else
                                        <!-- todo: have problem in mobile device -->
                                        <input class="statusChange" type="checkbox" data-pk="{{$employee->id}}" @if($employee->status) checked @endif data-toggle="toggle" data-on="<i class='fa fa-check-circle'></i>" data-off="<i class='fa fa-ban'></i>" data-onstyle="success" data-offstyle="danger">
                                        @endif
                                    </td>
                                    <td>
                                        
                                        <div class="btn-group">
                                            <a title="Details"  href="{{URL::route('hrm.employee.show',$employee->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                        @if($employee->role->id != AppHelper::USER_TEACHER)
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('hrm.employee.edit',$employee->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            </a>
                                        </div>
                                        <!-- todo: have problem in mobile device -->
                                        <div class="btn-group">
                                            <form  class="myAction" method="POST" action="{{URL::route('hrm.employee.destroy', $employee->id)}}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">#</th>
                                <th class="notexport" width="10%">Photo</th>
                                <th width="10%">ID Card</th>
                                <th width="25%">Name</th>
                                <th width="10%">Phone No</th>
                                <th width="10%">Type</th>
                                <th width="5%">Order</th>
                                <th width="10%">Status</th>
                                <th class="notexport" width="15%">Action</th>
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
            window.postUrl = '{{URL::Route("hrm.employee.status", 0)}}';
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
