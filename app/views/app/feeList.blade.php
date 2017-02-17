@extends('layouts.master')

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
                <h2><i class="glyphicon glyphicon-book"></i> Fee List</h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">

                        <form role="form" action="/fees/list" method="post" enctype="multipart/form-data">
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
                                        <div class="form-group">
                                            <label class="control-label">&nbsp;</label>
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
              <table id="feeList" class="table table-striped table-bordered table-hover">
                                                         <thead>
                                                             <tr>
                                                                 <th>Type</th>
                                                                <th>Title</th>
                                                                 <th>Fee</th>
                                                                 <th>Late Fee</th>
                                                                 <th>Description</th>

                                                                  <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                           @foreach($fees as $fee)
                                                             <tr>
                                                                  <td>{{$fee->type}}</td>
                                                                  <td>{{$fee->title}}</td>
                                                                     <td>{{$fee->fee}}</td>
                                                                     <td>{{$fee->Latefee}}</td>
                                                                     <td>{{$fee->description}}</td>

                                                       <td>
                                                <a title='Edit' class='btn btn-info' href='{{url("/fee/edit")}}/{{$fee->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/fee/delete")}}/{{$fee->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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

<script type="text/javascript">
    $( document ).ready(function() {
        $('#feeList').dataTable();

    });
</script>
@stop
