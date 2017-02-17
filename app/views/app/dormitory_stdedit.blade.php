@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/dormitory/assignstd/list">View List</a><br>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Student Info Update for Dormitory</h2>

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
                    @if(isset($student))
                    <form role="form" action="/dormitory/assignstd/update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $student->id }}">

                        <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="dormitory">Dormitory</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                              {{ Form::select('dormitory',$dormitories,$student->dormitory,['class'=>'form-control','required'=>'true'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="roomNo">Room No.</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <input type="text"  name="roomNo" class="form-control" required="true" value="{{$student->roomNo}}" />

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="monthlyFee">Monthly Fee</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <input type="text"  name="monthlyFee" class="form-control" required="true" value="{{$student->monthlyFee}}" />

                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-2">
                                      <div class="form-group ">
                                          <label for="leaveDate">Leave Date</label>
                                          <div class="input-group">

                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                              <input type="text"   class="form-control datepicker" name="leaveDate"   data-date-format="yyyy-mm-dd">
                                          </div>


                                      </div>
                                  </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label" for="isActive">Is Active</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>

                                                {{ Form::select('isActive',['Yes'=>'Yes','No'=>'No'],$student->isActive,['class'=>'form-control','required'=>'true'])}}

                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>
                        <!--button save -->
                        <div class="row">
                            <div class="col-md-12">

                                <button class="btn btn-primary pull-right" id="btnsave" type="submit"><i class="glyphicon glyphicon-refresh"></i> Update</button>
                              </div>
                          </div>
                    </form>
                  @else
                          <div class="alert alert-danger">
                              <strong>Whoops!</strong>There is no such Student!<br><br>

                          </div>
                @endif

        </div>
    </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">

        $( document ).ready(function() {

            $(".datepicker").datepicker({autoclose:true,todayHighlight: true});

        });

    </script>

@stop
