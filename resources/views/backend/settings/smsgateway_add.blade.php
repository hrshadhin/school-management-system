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
            <small>@if($gateway) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('settings.sms_gateway.index')}}"><i class="fa fa-external-link"></i> SMS Gateway</a></li>
            <li class="active">@if($gateway) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="@if($gateway) {{URL::Route('settings.sms_gateway.update', $gateway->id)}} @else {{URL::Route('settings.sms_gateway.store')}} @endif" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="box-body">

                            @if($gateway)
                                @php
                                  $values = json_decode($gateway->meta_value);
                                @endphp
                            @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label for="name">Gateway<span class="text-danger">*</span></label>
                                    {!! Form::select('gateway', $gateways, $gateway_id , ['placeholder' => 'Pick a gateway...','class' => 'form-control select2', 'required' => 'true']) !!}
                                    <span class="form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('gateway') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="title" value="@if($gateway){{ $values->name }}@else{{ old('name') }}@endif" required minlength="4" maxlength="255">
                                    <span class="fa fa-info form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label for="sender_id">Sender ID</label>
                                    <input  type="text" class="form-control" name="sender_id" placeholder="sender_id" value="@if($gateway){{ $values->sender_id }}@else{{ old('sender_id') }}@endif">
                                    <span class="fa fa-id-card form-control-feedback"></span>
                                    <span class="text-danger">{{ $errors->first('sender_id') }}</span>
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="user">User / API Key<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="user" placeholder="user" value="@if($gateway){{ $values->user }}@else{{ old('user') }}@endif" required  maxlength="255">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('user') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="password">Password / Secret Key</label>
                                        <input  type="text" class="form-control" name="password" placeholder="password" value="@if($gateway){{ $values->password }}@else{{ old('password') }}@endif" maxlength="255">
                                        <span class="fa fa-user-secret form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="api_url">API URL<span class="text-danger">*</span></label>
                                        <input  type="url" class="form-control" name="api_url" placeholder="url" value="@if($gateway){{ $values->api_url }}@else{{ old('api_url') }}@endif" required>
                                        <span class="fa fa-link form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('api_url') }}</span>
                                    </div>
                                </div>
                            </div>



                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{URL::route('settings.sms_gateway.index')}}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right"><i class="fa @if($gateway) fa-refresh @else fa-plus-circle @endif"></i> @if($gateway) Update @else Add @endif</button>
                    </div>
                    </form>
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
        });
    </script>
@endsection
<!-- END PAGE JS-->
