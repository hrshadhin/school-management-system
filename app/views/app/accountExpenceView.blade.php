@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
        </div>

    @endif
    @if (Session::get('error'))
        <div class="alert alert-warning">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong> {{ Session::get('error')}}</strong>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-book"></i> Expence List</h2>

                </div>
                <div class="box-content">

                    <div class="row">
                        <div class="col-md-12">

                            <form role="form" action="/accounting/expencelist" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <label for="session">Expence Year</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                    <input type="text"  required="true" class="form-control datepicker2" name="year" value=""   data-date-format="yyyy">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <label for="ff">&nbsp;</label>
                                                <div class="input-group">
                                                <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
                                                    </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <br>
                            </form>
                        </div>
                    </div>
                    @if(count($expences)>0)
                    <div class="row">
                        <div class="col-md-12">
                            <table id="studentList" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Description</th>

                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expences as $expence)
                                    <tr>
                                        <td>{{$expence->name}}</td>
                                        <td>{{$expence->amount}}</td>
                                        <td>{{date_format(date_create($expence->date), 'd/m/Y');}}</td>
                                        <td>{{$expence->description}}</td>
                                        <td>
                                            <a title='Edit' class='btn btn-info' href='{{url("/accounting/expenceedit")}}/{{$expence->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/accounting/expencedelete")}}/{{$expence->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                        </td>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    <br><br>


                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#studentList').dataTable();
            $(".datepicker2").datepicker( {
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years",
                autoclose:true

            });
        });
    </script>
@stop
