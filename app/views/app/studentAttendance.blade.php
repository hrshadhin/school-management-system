
@extends('layouts.master')
@section('style')

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
        </div>
    @endif
    @if (Session::get('noresult'))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>{{ Session::get('noresult')}}</strong>

        </div>
    @endif

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Student Individual Attendance Report</h2>

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

                    <form role="form" action="/attendance/report" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">

                            <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="session">Regi No</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text" id="regiNo" required="true" class="form-control" name="regiNo">
                                        </div>

                                    </div>
                                </div>
                            <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="session">&nbsp;</label>
                                        <div >
                                            <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-print"></i> Get Report</button>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4"></div>


                            </div>
                        </div>


                    </form>



                </div>
            </div>
        </div>
    </div>
@stop
@section('script')

    <script type="text/javascript">

    </script>
@stop
