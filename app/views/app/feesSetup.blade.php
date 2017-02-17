@extends('layouts.master')

@section('content')
@if (Session::get('success'))

<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/fees/list">View List</a><br>

</div>
@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-list"></i> Fee Create</h2>

            </div>
            <div class="box-content">
              <form role="form" action="/fees/setup" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label" for="class">Class</label>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                            <select id="class" name="class" class="form-control" >
                                @foreach($classes as $class)
                                    <option value="{{$class->code}}">{{$class->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                      <div class="form-group">
                                            <label class="control-label" for="type">Type</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                <select name="type" class="form-control" required>
                                                <option value="Other">Other</option>
                                                  <option value="Monthly">Monthly</option>

                                                </select>
                                            </div>
                                        </div>
                    <div class="form-group">
                        <label for="name">Title</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <input type="text" class="form-control" required name="title" placeholder="Fee title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="written">Fee</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <input type="text" class="form-control" required="true" name="fee" placeholder="0.00" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="written">Late Fee</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <input type="text" class="form-control" name="Latefee" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <textarea type="text" class="form-control" name="description" placeholder="Fee Description"></textarea>
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
                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>
                    <br>
                  </div>
                </form>






        </div>
    </div>
</div>
</div>
@stop
@section('script')

    <script type="text/javascript">

        $( document ).ready(function() {


          });

    </script>

@stop
