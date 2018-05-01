@extends('layouts.master')
@section('style')
  <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
@stop
@section('content')
  @if (Session::get('success'))
    <div class="alert alert-success">
      <button data-dismiss="alert" class="close" type="button">×</button>
      <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/leaves">View List</a><br>

    </div>
  @endif
  <div class="row">
    <div class="box col-md-12">
      <div class="box-inner">
        <div data-original-title="" class="box-header well">
          <h2><i class="glyphicon glyphicon-user"></i> New Leave Etnry</h2>

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
          <form role="form" action="/leaves/store" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
              <div class="col-md-12">
                <div  class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="class">Employee</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                      {{ Form::select('employee',$teachers,null,['class'=>'form-control','id'=>'class',])}}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="gender">Leave type</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                      <select name="lType" class="form-control" required >
                        <option value="CL">Casual leave (CL)</option>
                        <option value="ML">Sick leave (ML)</option>
                        <option value="UL">Undefined leave (UL)</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group ">
                    <label for="dob">Date Start</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                      <input type="text"   class="form-control datepicker" name="leaveDate" required  data-date-format="dd/mm/yyyy">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group ">
                    <label for="holiDateTo">Date End <span class="text-danger">[Optional]</span></label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                      <input type="text"  class="form-control datepicker" name="leaveDateEnd"   data-date-format="dd/mm/yyyy">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group ">
                    <label for="paper">Paper<span class="text-danger">(jpeg,jpg,png,pdf,doc,docx,odt[max:2mb])</span><span class="text-info">[Optional]</span></label>
                    <input id="paper" name="paper" type="file">
                  </div>
                </div>
              <div class="col-md-6">
                  <div class="form-group ">
                    <label for="holiDateTo">Description</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i> </span>
                      <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                </div>
              </div>
              </div>

                <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">&nbsp;</label>
                  <div>
                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      <br>
      </form>

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
      });

  </script>
@stop
