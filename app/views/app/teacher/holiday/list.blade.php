@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Holidays</h2>

                </div>
                <div class="box-content">
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

                        <form role="form" action="/holidays/create" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label for="holiDate">Date Start</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                <input type="text"  required  class="form-control datepicker" name="holiDate" value="{{date('d/m/Y')}}"   data-date-format="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label for="holiDateTo">Date End <span class="text-danger">[Optional]</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                <input type="text"  class="form-control datepicker" name="holiDateEnd"   data-date-format="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label for="holiDateTo">Description</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i> </span>
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">&nbsp;</label>
                                            <div>
                                                <button class="btn btn-primary pull-left" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>
                        </form>
                    <br>
                </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="holidayList" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($holidays as $day)

                                    <tr>
                                        <td>{{$day->holiDate->format('j M,Y')}}</td>
                                        <td>{{$day->description}}</td>
                                        <td>{{$day->createdAt->format('d/m/Y h:i:s a')}}</td>
                                        <td>
                                             <a title='Delete' class='btn btn-danger' href='{{url("/holidays/delete")}}/{{$day->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                        </td>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.datepicker').datepicker({autoclose:true,todayHighlight:true});

            $('#holidayList').dataTable();
        });
    </script>

@stop
