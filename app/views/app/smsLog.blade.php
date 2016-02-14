@extends('layouts.master')
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
        </div>

    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> SMS Logs</h2>

                </div>
                <div class="box-content">
                    <table id="smsList" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Sender</th>
                            <th>Recipient</th>
                            <th>Message</th>
                            <th>Date Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($smslogs as $smsLog)
                            <tr>
                                <td>{{$smsLog->type}}</td>
                                <td>{{$smsLog->sender}}</td>
                                <td>{{$smsLog->recipient}}</td>
                                <td>{{$smsLog->message}}</td>
                                <td>{{$smsLog->created_at->format('d/m/Y h:i:s A')}}</td>
                                <td>{{$smsLog->status}}</td>

                                <td>
                                   <a title='Delete' class='btn btn-danger' href='{{url("/smslog/delete")}}/{{$smsLog->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                    <br><br>


                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#smsList').dataTable();
        });
    </script>
@stop
