@extends('layouts.master')
@section('style')

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
                <h2><i class="glyphicon glyphicon-home"></i> Dormitory</h2>

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
                   @if($dormitory)
                     <form role="form" action="/dormitory/update" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="id" value="{{$dormitory->id}}">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <div class="row">
                         <div class="col-md-12">
                           <div class="col-md-4">
                               <div class="form-group">
                             <label for="name">Name</label>
                             <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                 <input type="text" class="form-control" required name="name"  value="{{$dormitory->name}}">
                             </div>
                         </div>
                           </div>
                           <div class="col-md-2">
                             <div class="form-group">
                                 <label for="numOfRoom">Number Of Rooms</label>
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                     <input type="text" class="form-control" required name="numOfRoom" value="{{$dormitory->numOfRoom}}">
                                 </div>
                             </div>
                           </div>
                           <div class="col-md-3">
                             <div class="form-group">
                                 <label for="address">Address</label>
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                     <textarea class="form-control" required name="address" >{{$dormitory->address}}</textarea>
                                 </div>
                             </div>
                           </div>
                           <div class="col-md-3">
                             <div class="form-group">
                                 <label for="description">Description</label>
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                     <textarea class="form-control"  name="description">{{$dormitory->description}}</textarea>
                                 </div>
                             </div>
                           </div>

                         </div>
                       </div>
                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Update</button>
                      </form>
                    @else
                    <form role="form" action="/dormitory/create" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4">
                          <div class="form-group">
                        <label for="name">Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <input type="text" class="form-control" required name="name"  placeholder="Dormitory Name">
                        </div>
                    </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                            <label for="numOfRoom">Number Of Rooms</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <input type="text" class="form-control" required name="numOfRoom" placeholder="Total rooms in it">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <textarea class="form-control" required name="address" ></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <textarea class="form-control"  name="description"></textarea>
                            </div>
                        </div>
                      </div>

                    </div>
                  </div>


                      <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>
                      <br>
                        </form>
                    @endif
                    <br>
                  </div>


                @if(count($dormitories)>0)
                <div class="row">
                  <div class="col-md-12">
                    <table id="dormitoryList" class="table table-striped table-bordered table-hover">
                                                               <thead>
                                                                   <tr>
                                                                       <th>Name</th>
                                                                       <th>Num Of Rooms</th>
                                                                       <th>Address</th>

                                                                        <th>Description</th>
                                                                          <th>Action</th>
                                                                   </tr>
                                                               </thead>
                                                               <tbody>
                                                                 @foreach($dormitories as $dorm)

                                                                   <tr>
                                                                      <td>{{$dorm->name}}</td>
                                                                     <td>{{$dorm->numOfRoom}}</td>
                                                                     <td>{{$dorm->address}}</td>
                                                                     <td>{{$dorm->description}}</td>

                                                             <td>
                                                                       <a title='Edit' class='btn btn-info' href='{{url("/dormitory/edit")}}/{{$dorm->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/dormitory/delete")}}/{{$dorm->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                                                     </td>
                                                                 @endforeach
                                                                 </tbody>
                                      </table>

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
        $('#dormitoryList').dataTable();
    });
</script>

@stop
