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
                <h2><i class="glyphicon glyphicon-book"></i> Books Reports</h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">


    <span class="text-danger">[*]Fill up any feilds and print. Don't fill up more than one feild at a time.</span>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="col-md-4">

                                    <div class="form-group">
                                          <label class="control-label" for="type">Type</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                               {{ Form::select('type',["-1"=>'--Select--','Academic'=>'Academic','Story'=>'Story','Magazine'=>'Magazine','Other'=>'Other'],Input::get('type'),['id'=>'type','class'=>'form-control'])}}
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-md-2">

                                      <div class="form-group">
                                            <label class="control-label" for="type">Today Return List</label>
                                            <br>
                                         <input type="checkbox" name="today" id="today">

                                    </div>



                                </div>




                                    <div class="col-md-2">

                                        <div class="form-group">
                                              <label class="control-label" for="type">Expire List</label>
                                             <br>
                                          <input type="checkbox" id="expire" name="expire">

                                           </div>




                                  </div>
                                  <div class="col-md-2">
                                    <label for="">&nbsp;</label>
                                    <div class="input-group">
                                      <button class="btn btn-primary"  type="submit" id="btnPrint"><i class="glyphicon glyphicon-print"></i> Print</button>
                                    </div>
                                  </div>
                                    </div>
                                      </div>



                            <br>

                    </div>
                </div>



        </div>
    </div>
</div>
</div>
@stop
@section('script')

    <script type="text/javascript">
        $( document ).ready(function() {

            $( "#btnPrint" ).click(function() {
                var type = $('#type').val();
                var today =  $('#today').is(':checked');
                var expire  = $('#expire').is(':checked');
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host;
                var url =baseUrl+"/library/reportprint/";
                if(type!="-1") {
                   url +=type;
                    var win = window.open(url, '_blank');
                    win.focus();

                }
                else if(today)
              {
                url +="today";
                 var win = window.open(url, '_blank');
                 win.focus();
              }
              else if(expire)
              {
                url +="expire";
                 var win = window.open(url, '_blank');
                 win.focus();
              }
                else
                {
                    alert('Fill up inputs feilds correclty!!!');
                }
            });

        });

    </script>
@stop
