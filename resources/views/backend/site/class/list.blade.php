<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Class Profile @endsection
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
            <small>Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-picture-o"></i> Class Profile</a></li>

        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Profiles</h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('class_profile.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="profiles" class="table table-bordered table-striped list_view_table">
                            <thead>
                            <tr>
                                <th width="10%">Name</th>
                                <th width="30%">Description</th>
                                <th width="10%">Teacher</th>
                                <th width="10%">Room No</th>
                                <th width="10%">Capacity</th>
                                <th width="10%">Shift</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($profiles as $profile)
                                <tr>

                                    <td>{{ $profile->name }}</td>
                                    <td> {{ $profile->short_description }}</td>
                                    <td> {{ $profile->teacher }}</td>
                                    <td> {{ $profile->room_no }}</td>
                                    <td> {{ $profile->capacity }}</td>
                                    <td> {{ $profile->shift }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('class_profile.edit',$profile->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <form class="myAction" method="POST" action="{{URL::route('class_profile.destroy',$profile->id)}}">
                                                {{ method_field('DELETE') }}
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
                                <th width="10%">Name</th>
                                <th width="30%">Description</th>
                                <th width="10%">Teacher</th>
                                <th width="10%">Room No</th>
                                <th width="10%">Capacity</th>
                                <th width="10%">Shift</th>
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
    <script type="text/javascript">
        $(document).ready(function () {
            Site.classProfileInit();
            initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
