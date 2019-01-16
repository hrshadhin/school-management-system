<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') SMS Gateway @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            SMS Gateway
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> SMS Gateway</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header border">
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('settings.sms_gateway.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                            <table id="listDataTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Name</th>
                                    <th width="10%">Gateway Name</th>
                                    <th width="10%">Sender ID</th>
                                    <th width="10%">User / API Key</th>
                                    <th width="20%">Password / Secret key</th>
                                    <th width="20%">API URL</th>
                                    <th class="notexport" width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($smsGateways as $jsonValue)
                                    @php
                                        $gateway = json_decode($jsonValue->meta_value);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $gateway->name }}</td>
                                        <td>{{ AppHelper::SMS_GATEWAY_LIST[$gateway->gateway] }}</td>
                                        <td>{{ $gateway->sender_id }}</td>
                                        <td>{{ $gateway->user }}</td>
                                        <td>{{ $gateway->password }}</td>
                                        <td>{{ $gateway->api_url }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a title="Edit" href="{{URL::route('settings.sms_gateway.edit',$jsonValue->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                </a>
                                            </div>
                                            <!-- todo: have problem in mobile device -->
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('settings.sms_gateway.destroy')}}">
                                                    @csrf
                                                    <input type="hidden" name="hiddenId" value="{{$jsonValue->id}}">
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
                                    <th width="15%">Name</th>
                                    <th width="10%">Gateway Name</th>
                                    <th width="10%">Sender ID</th>
                                    <th width="10%">User / Key</th>
                                    <th width="20%">Password / Secret key</th>
                                    <th width="20%">API URL</th>
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
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->
