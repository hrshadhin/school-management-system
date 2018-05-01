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
          <h2><i class="glyphicon glyphicon-calendar"></i>Class Off Days</h2>

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

          <form role="form" action="/class-off/store" method="post" enctype="multipart/form-data">
            <fieldset>
              <legend class="text-info">Add new class off day</legend>

              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-2">
                    <div class="form-group ">
                      <label for="dob">Date Start</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                        <input type="text"   class="form-control datepicker" name="offDate" required  data-date-format="dd/mm/yyyy">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group ">
                      <label for="holiDateTo">Date End <span class="text-danger">[Optional]</span></label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                        <input type="text"  class="form-control datepicker" name="offDateEnd"   data-date-format="dd/mm/yyyy">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label" for="gender">Off type</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                        <select name="oType" class="form-control" required >
                          <option value="E">Exam (E)</option>
                          <option value="O">Class Off (O)</option>
                          <option value="CP">College Program (CP)</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label for="holiDateTo">Description</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i> </span>
                        <textarea class="form-control" name="description"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="">&nbsp;</label>
                      <div>
                        <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>
          </form>
          <fieldset>
            <legend class="text-info">Class off days</legend>
            <div class="row">
              <div class="col-md-12">
                <table id="offdayList" class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($offdays as $day)

                    <tr>
                      <td>{{$day->offDate->format('j M,Y')}}</td>
                      <td>
                        @if($day->oType=='E')
                          Exam
                        @elseif($day->oType=="O")
                          Class Off
                        @else
                          College Program
                        @endif
                      </td>
                      <td>{{$day->description}}</td>
                      <td>{{$day->created_at->format('d/m/Y h:i:s a')}}</td>
                      <td>
                        <a title='Delete' class='btn btn-danger' href='{{url("/class-off/delete")}}/{{$day->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                      </td>
                  @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </fieldset>

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
          $('#offdayList').dataTable();
      });

  </script>
@stop
