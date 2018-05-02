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
                    <h2><i class="glyphicon glyphicon-user"></i>System Users</h2>

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
                    @if($user)
                        <form role="form" action="/userupdate" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Fist Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="firstname" value="{{$user->firstname}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Last Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="lastname" value="{{$user->lastname}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="email" class="form-control" required name="email" value="{{$user->email}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Login Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" readonly="true" class="form-control" required name="login" value="{{$user->login}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>  </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gpa">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="password" required="true" class="form-control"  name="password" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="type">User Group</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                {{ Form::select('group',['Admin'=>'Admin','Management'=>'Management','Other'=>'Other'],$user->group,['class'=>'form-control','required'=>'true'])}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Description</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <textarea type="text" class="form-control" required name="desc" placeholder="Description">{{$user->desc}}</textarea>

                                            </div>
                                        </div>
                                    </div>


                                </div>  </div>

                            <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i> Update</button>
                            <br>
                        </form>
                    @else
                        <form role="form" action="/usercreate" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Fist Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="firstname"  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Last Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="lastname"  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="email" class="form-control" required name="email"  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gpa">Login Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="login"  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>  </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gpa">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="password" class="form-control" required=""  name="password" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="type">User Group</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <select name="group"  required="true" class="form-control" >
                                                    <option value="Admin">Admin</option>
                                                    <option value="Management">Management</option>
                                                    <option value="Other">Other</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Description</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <textarea type="text" class="form-control" required name="desc" placeholder="Description"></textarea>

                                            </div>
                                        </div>
                                    </div>


                                </div>  </div>

                            <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            <br>
                        </form>
                    @endif
                    <br>
                </div>


                @if(count($users)>0)
                    <div class="row">
                        <div class="col-md-12">
                            <table id="sectorList" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Login</th>
                                    <th>Group</th>
                                    <th>Descripton</th>

                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)

                                    <tr>
                                        <td>{{$user->firstname}} {{$user->lastname}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->login}}</td>
                                        <td>{{$user->group}}</td>
                                        <td>{{$user->desc}}</td>


                                        <td>
                                            <a title='Edit' class='btn btn-info' href='{{url("/useredit")}}/{{$user->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/userdelete")}}/{{$user->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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
            $('#sectorList').dataTable();
        });
    </script>

@stop
