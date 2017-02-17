@extends('layouts.master')
@section('content')
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-home"></i> Fee Edit</h2>

            </div>
            <div class="box-content">
                  @if (isset($fee))
              <form role="form" action="/fee/edit" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" name="id" value="{{$fee->id }}">
                   <div class="form-group">
                       <label class="control-label" for="class">Class</label>

                       <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                           {{ Form::select('class',$classes,$fee->class,['class'=>'form-control'])}}

                       </div>
                   </div>
                     <div class="form-group">
                                           <label class="control-label" for="type">Type</label>

                                           <div class="input-group">
                                               <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                               {{ Form::select('type',['Other'=>'Other','Monthly'=>'Monthly'],$fee->type,['class'=>'form-control'])}}

                                           </div>
                                       </div>
                   <div class="form-group">
                       <label for="name">Title</label>
                       <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                           <input type="text" class="form-control" required name="title" value="{{$fee->title}}" placeholder="Fee title">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="written">Fee</label>
                       <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                           <input type="text" class="form-control" required="true" name="fee" value="{{$fee->fee}}" placeholder="0.00" >
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="written">Late Fee</label>
                       <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                           <input type="text" class="form-control" name="Latefee" value="{{$fee->Latefee}}" placeholder="0.00">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="name">Description</label>
                       <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                           <textarea type="text" class="form-control" name="description" placeholder="Fee Description">{{$fee->description}}</textarea>
                       </div>
                   </div>
                    <div class="clearfix"></div>
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
                                <div class="form-group">
                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-check"></i>Update</button>
                    <br>
                  </div>
                </form>
                @else
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong>There is no such Fee!<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                         @endif

        </div>
    </div>
</div>
</div>
@stop
