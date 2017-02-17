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
        <h2><i class="glyphicon glyphicon-book"></i> Books List</h2>

      </div>
      <div class="box-content">

        <div class="row">
          <div class="col-md-12">

            <form role="form" action="/library/view-show" method="get" enctype="multipart/form-data">

              <div class="row">
                <div class="col-md-12">

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="class">Class</label>

                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                        {{ Form::select('classcode',$classes,$formdata->class,['class'=>'form-control','required'=>'true'])}}
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
            @if(count($books)>0)
            <table id="booklist" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Code/ISBN No</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Class</th>
                  <th>Type </th>
                  <th>Quantity</th>
                  <th>Rack No</th>
                  <th>Row No</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($books as $book)
                <tr>
                  <td>{{$book->code}}</td>
                  <td>{{$book->title}}</td>
                  <td>{{$book->author}}</td>
                  <td>{{$book->class}}</td>
                  <td>{{$book->type}}</td>
                  <td>{{$book->quantity}}</td>
                  <td>{{$book->rackNo}}</td>
                  <td>{{$book->rowNo}}</td>
                  <td>{{$book->desc}}</td>

                  <td>
                    <a title='Edit' class='btn btn-success' href='{{url("/library/edit")}}/{{$book->id}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/library/delete")}}/{{$book->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                  </td>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <br><br>

          {{$books->appends(array('classcode' => $formdata->class))->links()}}
          @endif
        </div>
      </div>
    </div>
  </div>
  @stop
  @section('script')
  <script type="text/javascript">
  $( document ).ready(function() {
    $('#booklist').dataTable();
  });
  </script>

  @stop
