@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Attendance Edit</h2>

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
                    @if (isset($attendance))
                        <form role="form" action="/attendance/update" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{$attendance->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="regiNo">Regi No</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" readonly="true"  name="regiNo" value="{{$attendance->regiNo}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rollNo">Roll No</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" readonly="true"  name="rollNo" value="{{$attendance->rollNo}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" readonly="true"  name="name" value="{{$attendance->firstName}} {{$attendance->middleName}} {{$attendance->lastName}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="Absent">Is Present</label>
                                                <input type="checkbox" name="ispresent" @if($attendance->status=="Yes")checked="true" @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-check"></i>Update</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong>There is no such Student!<br><br>
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
@section('script')

    <script type="text/javascript">

    </script>
@stop
