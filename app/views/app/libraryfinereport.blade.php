@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')

<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-home"></i> Library Month Fine Report <i class="glyphicon glyphicon-user"></i></h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">


                            <div class="row">
                                <div class="col-md-12">


                                  <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="month">Fine month</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text"   class="form-control datepicker" id="fineMonth" required  data-date-format="yyyy-mm-dd">
                                        </div>


                                    </div>
                                  </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label class="control-label" for="">&nbsp;</label>
                                                <div class="input-group">
                                              <button class="btn btn-primary pull-right" id="btnPrint"><i class="glyphicon glyphicon-print"></i> Print List</button>
                                            </div>
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
  <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
          $(".datepicker").datepicker( {
              startView: "months",
              minViewMode: "months",
              autoclose:true
            });
            $( "#btnPrint" ).click(function() {

                var month =  $('#fineMonth').val();
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host;
                var url =baseUrl+"/library/reports/fine/";
                if(month !="" ) {
                   url +=month;
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
