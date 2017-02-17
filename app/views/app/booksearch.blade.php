@extends('layouts.master')
@section('style')


@stop
@section('content')

<div class="row">
  <div class="box col-md-12">
    <div class="box-inner">
      <div data-original-title="" class="box-header well">
        <h2><i class="glyphicon glyphicon-search"></i> Books Search</h2>

      </div>
      <div class="box-content">
        <div class="row">
          <div class="col-md-12">
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
            @if (Session::get('error'))
            <div class="alert alert-warning">
              <button data-dismiss="alert" class="close" type="button">×</button>
              <strong> {{ Session::get('error')}}</strong>

            </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">

            <form role="form" action="/library/search" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <span class="text-danger">[*]Fill up any feilds and search </span>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name">Code/ISBN No</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                        <input type="text" class="form-control"  name="code" placeholder="Book Code">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Title/Name</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                        <input type="text" class="form-control"  name="title" placeholder="Book Name">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="author">Author</label>

                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                        <input type="text" class="form-control"  name="author" placeholder="Writer Name">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <div class="input-group">
                      <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                    </div>
                  </div>

                </div>
              </div>

            </form>
            <form role="form" action="/library/search2" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <span class="text-danger">[*]Fill up both feilds and search </span>
              <div class="row">
                <div class="col-md-12">



                  <div class="col-md-5">
                    <div class="form-group">
                      <label class="control-label" for="type">Type</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                        {{ Form::select('type',['Academic'=>'Academic','Story'=>'Story','Magazine'=>'Magazine','Other'=>'Other'],Input::get('type'),['class'=>'form-control'])}}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label class="control-label" for="class">Class</label>

                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                        {{ Form::select('class',$classes,Input::get('class'),['class'=>'form-control'])}}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <div class="input-group">
                      <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                    </div>
                  </div>

                </div>
              </div>


              <br>
            </form>
          </div>
        </div>
        @if(isset($books))
        <div class="row">
          <div class="col-md-12">
            @if(count($books)>0)
            <table id="bookList" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Code/ISBN No</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Class</th>
                  <th>Type </th>
                  <th>Quantity </th>
                  <th>Rack No</th>
                  <th>Row No</th>
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
                  <td>
                    <a title='Update Quantity' class='btn btn-success' href='{{url("/library/edit")}}/{{$book->id}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>
                  </td>


                  @endforeach

                </tbody>
              </table>
              @else
              <div class="alert alert-warning">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <strong>Book Not Found!</strong>

              </div>
              @endif
            </div>
          </div>
          @endif


        </div>
      </div>
    </div>
  </div>
  @stop
  @section('script')

  <script type="text/javascript">
  $( document ).ready(function() {
    $('#bookList').dataTable();

  });
  </script>
  @stop
