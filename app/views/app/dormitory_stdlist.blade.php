@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
@if (Session::get('success'))
<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
</div>

@endif
@if (Session::get('error'))
    <div class="alert alert-warning">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong> {{ Session::get('error')}}</strong>

    </div>
@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-home"></i> Dormitory Student List <i class="glyphicon glyphicon-user"></i></h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">

                        <form role="form" action="/dormitory/assignstd/list" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="class">Dormitory</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                {{ Form::select('dormitory',$dormitories,$formdata->dormitory,['class'=>'form-control','required'=>'true'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label class="control-label" for="">&nbsp;</label>
                                                <div class="input-group">
                                              <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
                                            </div>
                                            </div>
                                      </div>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
              <table id="studentList" class="table table-striped table-bordered table-hover">
                                                         <thead>
                                                             <tr>
                                                                <th>Regi No</th>
                                                                 <th>Roll No</th>
                                                                 <th>Class</th>
                                                                 <th>Name</th>
                                                                 <th>Guardian's Contact</th>
                                                                 <th>Room No</th>
                                                                  <th>Fee</th>
                                                                  <th>Joind Date</th>
                                                                  <th>Leave Date</th>

                                                                 <th>Is Active</th>
                                                                  <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                           @foreach($students as $student)
                                                             <tr>
                                                                  <td>{{$student->regiNo}}</td>
                                                                     <td>{{$student->rollNo}}</td>
                                                                     <td>{{$student->class}}</td>
                                                               <td>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>
                                                               <td>{{$student->fatherCellNo.'<br>' }}{{$student->motherCellNo.'<br>'}}{{$student->localGuardianCell}}</td>
                                                               <td>{{$student->roomNo}}</td>
                                                                  <td>{{$student->monthlyFee}}</td>
                                                                  <td>{{$student->joinDate}}</td>
                                                                  <td>{{$student->leaveDate}}</td>
                                                                  <td>{{$student->isActive}}</td>
                                                       <td>
                                                <a title='Edit' class='btn btn-info' href='{{url("/dormitory/assignstd/edit")}}/{{$student->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/dormitory/assignstd/delete")}}/{{$student->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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
        $('#studentList').dataTable();
            });
</script>
@stop
