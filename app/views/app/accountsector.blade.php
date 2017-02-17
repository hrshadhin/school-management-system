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
                    <h2><i class="glyphicon glyphicon-user"></i> Accounting Sector</h2>

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
                    @if($sector)
                        <form role="form" action="/accounting/sectorupdate" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{$sector->id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="gpa">Sector Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="name" value="{{$sector->name}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="type">Type</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                {{ Form::select('type',['Income'=>'Income','Expence'=>'Expence'],$sector->type,['class'=>'form-control','required'=>'true'])}}


                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Update</button>
                            <br>
                        </form>
                    @else
                        <form role="form" action="/accounting/sectorcreate" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="gpa">Sector Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="name"  placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="type">Type</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <select name="type" id="type" required="true" class="form-control" >
                                                    <option value="Income">Income</option>
                                                    <option value="Expence">Expence</option>
                                                </select>


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


                @if(count($sectors)>0)
                    <div class="row">
                        <div class="col-md-12">
                            <table id="sectorList" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Sector Name</th>
                                    <th>Type</th>

                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sectors as $sector)

                                    <tr>
                                        <td>{{$sector->name}}</td>
                                        <td>{{$sector->type}}</td>


                                        <td>
                                            <a title='Edit' class='btn btn-info' href='{{url("/accounting/sectoredit")}}/{{$sector->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/accounting/sectordelete")}}/{{$sector->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
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
