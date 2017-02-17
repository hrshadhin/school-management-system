@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}<br>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-home"></i> Dormitory Fee Colleciton</h2>

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
                    <form role="form" action="/dormitory/fee" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="dormitory">Dormitory</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                            <select id="dormitory"  name="dormitory" class="form-control" required="true">
                                              <option value="">--Select Dormitory--</option>
                                              @foreach($dormitories as $dorm)
                                                  <option value="{{$dorm->id}}">{{$dorm->name}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="control-label" for="students">Student</label>

                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                                          <select id="students" name="regiNo" class="form-control" required="true">
                                              <option value="">--Select Student--</option>


                                          </select>
                                      </div>
                                  </div>
                              </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="month">Fee month</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text"   class="form-control datepicker" name="feeMonth" required  data-date-format="yyyy-mm-dd">
                                        </div>


                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="control-label" for="amount">Fee Amount</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                              <input type="text"  name="feeAmount" class="form-control" required="true" placeholder="5000.00" />

                                          </div>
                                      </div>
                                  </div>
                                  </div>
                              </div>
                        <!--button save -->
                        <div class="row">
                            <div class="col-md-12">

                                <button class="btn btn-primary pull-right" id="btnsave" type="submit"><i class="glyphicon glyphicon-plus"></i>Save</button>
                              </div>
                          </div>
                        </div>
                              <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">

                                      <div id="board" class="alert alert-success text-center">
                                          <h3 >Monthly Fees</h3>
                                          <strong><h2  class="yellow" id='mfee'>0.00 TK.</h2></strong>
                                           <h3 id="status" class="green">Status: Paid</h3>
                                      </div>
                                      </div>
                                  </div>
                                </div>
                              </div>

                        </div>

                        </div>
                    </div>
                    </form>

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
            $('#btnsave').hide();
            $('#board').hide();

            $('#dormitory').on('change', function (e) {
                var val = $(e.target).val();
                $.ajax({
                    url:'/dormitory/getstudents/'+val,
                    type:'get',
                    dataType: 'json',
                    success: function( json ) {
                        $('#students').empty();
                        $('#students').append($('<option>').text("--Select Student--").attr('value',""));
                        $.each(json, function(i, student) {
                           // console.log(subject);

                            $('#students').append($('<option>').text(student.firstName+" "+student.middleName+" "+student.lastName+" ["+student.rollNo+"]").attr('value', student.regiNo));
                        });

                    }
                });
            });

            $('#students').on('change', function (e) {
                var val = $(e.target).val();
                $.ajax({
                    url:'/dormitory/fee/info/'+val,
                    type:'get',
                    dataType: 'json',
                    success: function( data ) {
                        //console.log(data);
                        $('#board').show();
                        $('#mfee').text(data[0]);
                        if(data[1]=="false")
                        {
                          $('#status').text('Status: Due');
                          $('#status').removeClass();
                          $('#status').addClass("red");

                        }
                        if(data[1]=="true")
                        {
                          $('#status').text('Status: Paid');
                          $('#status').removeClass();
                          $('#status').addClass("green");

                        }

                        $('#btnsave').show();
                    }
                });
            });


        });

    </script>

@stop
