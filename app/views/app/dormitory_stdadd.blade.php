@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/dormitory/assignstd/list">View List</a><br>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Student Add To Dormitory</h2>

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
                    <form role="form" action="/dormitory/assignstd/create" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label" for="class">Class</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                        <select id="class" id="class" name="class" class="form-control" >
                                                            <option value="">--Select Class--</option>
                                                            @foreach($classes as $class)
                                                                <option value="{{$class->code}}">{{$class->name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="section">Section</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <select id="section" name="section"  class="form-control" >
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                            <option value="E">E</option>
                                                            <option value="F">F</option>
                                                            <option value="G">G</option>
                                                            <option value="H">H</option>
                                                            <option value="I">I</option>
                                                            <option value="J">J</option>

                                                        </select>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="shift">Shift</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <select id="shift" name="shift"  class="form-control" >
                                                            <option value="Day">Day</option>
                                                            <option value="Morning">Morning</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label for="session">session</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                        <input type="text" id="session" required="true" class="form-control datepicker2" name="session"   data-date-format="yyyy">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                        <div class="row">
                            <div class="col-md-12">


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="student">Student</label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user blue"></i></span>
                                    <select id="student" name="regiNo" class="form-control" required="true">
                                        <option value="">--Select Student--</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="joindate">Join Date</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                            <input type="text"   class="form-control datepicker" name="joinDate" required  data-date-format="yyyy-mm-dd">
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="isActive">Is Active</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <select  name="isActive" class="form-control" required="true">
                                              <option value="Yes">Yes</option>
                                              <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="dormitory">Dormitory</label>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                            <select  name="dormitory" class="form-control" required="true">
                                              <option value="">--Select Dormitory--</option>
                                              @foreach($dormitories as $dorm)
                                                  <option value="{{$dorm->id}}">{{$dorm->name}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label" for="roomNo">Room No.</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                              <input type="text"  name="roomNo" class="form-control" required="true" placeholder="12" />

                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label" for="monthlyFee">Monthly Fee</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                              <input type="text"  name="monthlyFee" class="form-control" required="true" placeholder="5000.00" />

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
                    </form>

        </div>
    </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">

        $( document ).ready(function() {

            $('#btnsave').hide();
            $(".datepicker").datepicker({autoclose:true,todayHighlight: true});
            $(".datepicker2").datepicker( {
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years",
                autoclose:true

            }).on('changeDate', function (ev) {
                var aclass = $('#class').val();
                var section =  $('#section').val();
                var shift = $('#shift').val();
                var session = $('#session').val().trim();
                $.ajax({
                    url: '/student/getList/'+aclass+'/'+section+'/'+shift+'/'+session,
                    data: {
                        format: 'json'
                    },
                    error: function(error) {
                        alert("Please fill all inputs correctly!");
                    },
                    dataType: 'json',
                    success: function(data) {

                        if(data.length>0)
                        {
                          $('#student').empty();
                          $('#student').append($('<option>').text("--Select Student--").attr('value',""));
                          for(var i =0;i < data.length;i++)
                          {
                              sdata=data[i];
                              $('#student').append($('<option>').text(sdata['firstName']+' '+sdata['middleName']+' '+sdata['lastName']+'['+sdata['rollNo']+']').attr('value', sdata['regiNo']));
                          }
                            $('#btnsave').show();
                        }
                        else {
                          alert('Students not found!');
                        }

                    },
                    type: 'GET'
                });

            });


        });

    </script>

@stop
