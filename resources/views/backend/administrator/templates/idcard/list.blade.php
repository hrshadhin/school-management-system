<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Idcard Template @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Idcard Template
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Idcard Template</li>
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
                            <a class="btn btn-info btn-sm" href="{{ URL::route('administrator.template.idcard.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                            <table id="listDataTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Name</th>
                                    <th width="10%">For</th>
                                    <th width="45%" class="notexport">Template</th>
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
                                        <td>{{$template->role_id}}</td>
                                        <td>
                                            <a title="Preview" href="#" data-id="{{$template->id}}" class="btn btn-info btn-sm btnIdcardPreview"><i class="fa fa-eye-slash"></i></a>

                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a title="Edit" href="{{URL::route('administrator.template.idcard.edit',$template->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                </a>
                                            </div>
                                            <!-- todo: have problem in mobile device -->
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('administrator.template.idcard.destroy')}}">
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
                                    <th width="30%">Name</th>
                                    <th width="10%">For</th>
                                    <th width="45%" class="notexport">Template</th>
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

    <!-- Preview Modal -->
    <div class="modal fade" id="modalIdcardPreview">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 500px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Idcard Template Preview</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.Preview Modal -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        window.templateGetURL = '{{URL::route('administrator.template.idcard.index')}}';
        window.templateUrl = "{{asset('example/template')}}";

        $(document).ready(function () {
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
            Administrator.templateIdcardPreview();

        });
    </script>
@endsection
<!-- END PAGE JS-->
