@extends('layouts.master')
@section('content')
@if (Session::get('success'))


@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i>Update Book</h2>

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
                @if(isset($book))
                            <form role="form" action="/library/update" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="id" value="{{$book->id }}">
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
                                  <input type="text" readonly="true" class="form-control" required name="code"  value="{{$book->code}}">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div class="form-group">
                              <label for="name">Title/Name</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" class="form-control" required name="title" value="{{$book->title}}">
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
                                <input type="text" class="form-control" required name="author" value="{{$book->author}}">
                          </div>
                      </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label" for="rack">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                    <input type="text" class="form-control"  name="quantity" value="{{$book->quantity}}">
                                </div>
                            </div>
                        </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label class="control-label" for="rack">Rack No</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                      <input type="text" class="form-control"  name="rackNo" value="{{$book->rackNo}}">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label class="control-label" for="row">Row No</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                      <input type="text" class="form-control"  name="rowNo" value="{{$book->rowNo}}">
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
                                   {{ Form::select('type',['Academic'=>'Academic','Story'=>'Story','Magazine'=>'Magazine','Other'=>'Other'],$book->type,['class'=>'form-control'])}}

                            </div>
                        </div>
                    </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                            <label class="control-label" for="class">Class</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                 {{ Form::select('class',$classes,$book->class,['class'=>'form-control'])}}
                                            </div>
                                        </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                              <label class="control-label" for="dec">Description</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                <textarea class="form-control"  name="desc" >{{$book->desc}} </textarea>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>



                <div class="row">
                <div class="col-md-12">

                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Update</button>

                  </div>
                </div>
                </form>
                @else
                  <div class="alert alert-danger">
                    <strong>There is no book!!</strong>
                  </div>
                @endif

        </div>
    </div>
</div>
</div>
@stop
