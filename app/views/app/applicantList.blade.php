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
                <h2><i class="glyphicon glyphicon-book"></i> Applicant List</h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">

                        <form role="form" action="/applicants" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" for="class">Class</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                {{ Form::select('class',$classes,$formdata->class,['class'=>'form-control','required'=>'true'])}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label for="session">session</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                <input type="text" id="session" required="true" class="form-control datepicker2" name="session" value="{{$formdata->session}}"   data-date-format="yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                      <label for="">&nbsp;</label>
                                      <div class="input-group">
                                        <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
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
                                                                <th>Ref No</th>
                                                                 <th>Seat No</th>
                                                                 <th>Class</th>

                                                                 <th>Name</th>
                                                                 <th>Transaction No</th>
                                                                  <th>Reg Date Time</th>
                                                                 <th>Status</th>
                                                                  <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                           @foreach($students as $student)
                                                             <tr>
                                                                  <td>{{$student->refNo}}</td>
                                                                     <td>{{$student->seatNo}}</td>
                                                                     <td>{{$student->class}}</td>

                                                               <td>{{$student->stdName}}</td>
                                                               <td><input type="text" class="transInput" name="transactionNo[]" value="{{$student->transactionNo}}"></td>
                                                               <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$student->created_at)->format('d/m/Y g:i A')}}</td>
                                                                  <td>{{$student->status}}</td>

                                                       <td>
                                              <a title='Update' class='btn btn-info btnUpdate' id='{{$student->id}}' href='#'> <i class="glyphicon glyphicon-check icon-white"></i></a>&nbsp&nbsp    <a title='View' class='btn btn-success' href='{{url("/applicants/view")}}/{{$student->id}}'> <i class="glyphicon glyphicon-zoom-in icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/applicants/delete")}}/{{$student->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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
        $(".datepicker2").datepicker( {
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years",
            autoclose:true

        });
        $(".btnUpdate").click(function() {
            var transNo = $(this).parent().parent().find('input[type=text]').val();;
             var rowid=$(this).attr('id');

             var formData = {id:rowid,transactionNo:transNo}; //Array
            $.ajax({ //Process the form using $.ajax()
           type      : 'GET', //Method type
           url       : '/applicants/payment', //Your form processing file URL
           data      : formData, //Forms name
           dataType  : 'json',
           success   : function(data) {
                        alert(data);

                       },
            error     : function(error)
            {
              alert('Error: Something went wrong!!!');
            },
                          });


        });
    });
</script>
@stop
