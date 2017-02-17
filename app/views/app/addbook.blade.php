@extends('layouts.master')
@section('content')
@if (Session::get('success'))

<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/library/view">View List</a><br>

</div>
@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i> Add Book</h2>

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
                                    </div>
                                  </div>

                            <form role="form" action="/library/addbook" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                      <div class="col-md-12">
                          <h3 class="text-info"> Book Details</h3>
                          <hr>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-3">
                          <div class="form-group">
                              <label for="name">Code/ISBN No</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  {{ Form::text('code','',['class'=>'form-control','required'=>'true','placeholder'=>'Book Code'])}}

                              </div>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div class="form-group">
                              <label for="name">Title/Name</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                    {{ Form::text('title','',['class'=>'form-control','required'=>'true','placeholder'=>'Book Name']) }}
                              </div>
                          </div>
                        </div>


                                    </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label class="control-label" for="author">Author</label>

                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                  {{ Form::text('author','',['class'=>'form-control','required'=>'true','placeholder'=>'Writer Name']) }}

                          </div>
                      </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label" for="rack">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                      {{ Form::text('quantity','',['class'=>'form-control','required'=>'true','placeholder'=>'How many?']) }}

                                </div>
                            </div>
                        </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label class="control-label" for="rack">Rack No</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                        {{ Form::text('rackNo','',['class'=>'form-control','placeholder'=>'Rack No']) }}

                                  </div>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label class="control-label" for="row">Row No</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                      {{ Form::text('rowNo','',['class'=>'form-control','placeholder'=>'Row No']) }}
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                          <div class="row">
                            <div class="col-md-12">
                    <div class="col-md-3">
                      <div class="form-group">
                            <label class="control-label" for="type">Type</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                               {{ Form::select('type',['Academic'=>'Academic','Story'=>'Story','Magazine'=>'Magazine','Other'=>'Other'],Input::get('type'),['class'=>'form-control'])}}
                            </div>
                        </div>
                    </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                            <label class="control-label" for="class">Class</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                   {{ Form::select('class',$classes,Input::get('class'),['class'=>'form-control'])}}

                                            </div>
                                        </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                              <label class="control-label" for="dec">Description</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>

                                  {{ Form::textarea('desc','',['class'=>'form-control','placeholder'=>'Description No','rows'=>'3']) }}
                              </div>
                          </div>
                      </div>

                  </div>
                </div>



                <div class="row">
                <div class="col-md-12">

                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>

                  </div>
                </div>
                </form>

        </div>
    </div>
</div>
</div>
@stop
