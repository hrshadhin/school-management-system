<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Mail/SMS Template @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Mail/SMS Template
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Mail/SMS Template</li>
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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('administrator.template.mailsms.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                            <table id="listDataTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Name</th>
                                    <th width="10%">Type</th>
                                    <th width="10%">For</th>
                                    <th width="45%">Template</th>
                                    <th class="notexport" width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $template->name }}</td>
                                        <td>{{ $template->type }}</td>
                                        <td>{{ $template->role_id }}</td>
                                        <td>{{ $template->content }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a title="Edit" href="{{URL::route('administrator.template.mailsms.edit',$template->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                </a>
                                            </div>
                                            <!-- todo: have problem in mobile device -->
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('administrator.template.mailsms.destroy')}}">
                                                    @csrf
                                                    <input type="hidden" name="hiddenId" value="{{$template->id}}">
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
                                    <th width="20%">Name</th>
                                    <th width="10%">Type</th>
                                    <th width="10%">User</th>
                                    <th width="45%">Template</th>
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
            Administrator.templateMailSMSInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
