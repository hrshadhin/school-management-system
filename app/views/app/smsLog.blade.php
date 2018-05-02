@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
  @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
        @endif
  @if (count($smslogs)<1 && $foo=="1")
      <div class="alert alert-warning">

          <strong>There are no log between date range.</strong>

      </div>
  @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> SMS Logs</h2>

                </div>
                <div class="box-content">
                  <form  action="/smslog" method="post" enctype="multipart/form-data">

                  <div class="row">
                      <div class="col-md-12">

                          <div class="col-md-4">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="form-group ">
                                  <label for="dob">From Date</label>
                                  <div class="input-group">

                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                      <input type="text"   class="form-control datepicker" name="fromDate" required   data-date-format="yyyy-mm-dd">
                                  </div>


                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="dob">&nbsp;</label>
                                  <div class="input-group">

                                      <span class="input-group-addon"><i class="glyphicon glyphicon-resize-horizontal"></i> </span>

                                  </div>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group ">
                                  <label for="dob">To Date</label>
                                  <div class="input-group">


                                      <input type="text" class="form-control datepicker" name="toDate" required  data-date-format="yyyy-mm-dd">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                  </div>


                              </div>
                          </div>

                          <div class="col-md-2">
                              <div class="form-group ">
                                  <label for="dob">&nbsp;</label>
                                  <div class="input-group">

                                  <button class="btn btn-primary pull-right" id="btnPrint"><i class="glyphicon glyphicon-list"></i> Get List</button>
                              </div>
                                  </div>
                          </div>


                      </div>
                  </div>
                </form>
                  <div class="row">
                      <div class="col-md-12">
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
                  </div>
                </div>
                    <br><br>


                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
          $(".datepicker").datepicker( {

              autoclose:true

          });
            $('#smsList').dataTable();
        });
    </script>
@stop
