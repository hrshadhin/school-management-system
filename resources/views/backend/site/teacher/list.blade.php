<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Teachers Profile @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Teachers
            <small>Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa icon-teacher"></i> Teachers Profile</a></li>

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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('teacher_profile.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="profiles" class="table table-bordered table-striped list_view_table">
                            <thead>
                            <tr>
                                <th width="9%">Photo</th>
                                <th width="10%">Name</th>
                                <th width="6%">Designation</th>
                                <th width="6%">Qualification</th>
                                <th width="15%">Description</th>
                                <th width="7%">Facebook</th>
                                <th width="7%">Instagram</th>
                                <th width="7%">Twitter</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($profiles as $profile)
                                <tr>
                                    <td>
                                        <img class="img-responsive center" style="max-height: 200px;" src="@if($profile->image ){{ asset('storage/teacher_profile')}}/{{ $profile->image }} @else {{ asset('images/avatar.jpg')}} @endif" alt="">
                                    </td>
                                    <td>{{ $profile->name }}</td>
                                    <td> {{ $profile->designation }}</td>
                                    <td> {{ $profile->qualification }}</td>
                                    <td> {{ $profile->description }}</td>
                                    <td>
                                        @if($profile->facebook)
                                        <a href="{{ $profile->facebook }}" target="_blank" class="link"><i class="fa fa-2x fa-facebook"></i></a>
                                            @endif

                                    </td>
                                    <td>
                                         @if($profile->instagram)
                                        <a href="{{ $profile->instagram }}" target="_blank" class="link"><i class="fa fa-2x fa-instagram"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                         @if($profile->twitter)
                                        <a href="{{ $profile->twitter }}" target="_blank" class="link"><i class="fa fa-2x fa-twitter"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('teacher_profile.edit',$profile->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>

                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <form class="myAction" method="POST" action="{{URL::route('teacher_profile.destroy',$profile->id)}}">
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
                                <th width="9%">Photo</th>
                                <th width="10%">Name</th>
                                <th width="6%">Designation</th>
                                <th width="6%">Qualification</th>
                                <th width="15%">Description</th>
                                <th width="7%">Facebook</th>
                                <th width="7%">Instagram</th>
                                <th width="7%">Twitter</th>
                                <th width="10%">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                        {{ $profiles->links() }}
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
            Site.teacherProfileInit();
            initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
