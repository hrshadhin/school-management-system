@extends('layouts.master')
@section('style')
<link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
@stop
@section('content')
@if (Session::get('success'))
<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/student/list">View List</a><br>

</div>
@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-user"></i> Student New Admission</h2>

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
              <form role="form" action="/student/create" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                  <div class="col-md-12">
                      <h3 class="text-info"> Acdemic Details</h3>
                      <hr>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="control-label" for="class">Class</label>

                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                  <select name="class" id="class" class="form-control" required>
                                      @foreach($classes as $class)
                                          <option value="{{$class->code}}">{{$class->name}}</option>
                                      @endforeach

                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="control-label" for="section">Section</label>

                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <select name="section" id="section" required="true" class="form-control" >
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
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label for="session">session</label>
                              <div class="input-group">

                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                  <input type="text" id="session"  class="form-control datepicker2" name="session" required  data-date-format="yyyy">
                              </div>
                          </div>
                      </div>




                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="regiNo">Registration No</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" id="regiNo" class="form-control" required name="regiNo" value="" placeholder="">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="rollNo">Card/Roll No</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" id="rollNo" class="form-control" required name="rollNo" placeholder="Class roll no">
                              </div>
                          </div>
                      </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <label class="control-label" for="group">Group</label>

                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                      <select name="group" class="form-control" >
                        <option value="N/A">N/A</option>
                        <option value="Science">Science</option>
                          <option value="Arts">Arts</option>
                            <option value="Commerce">Commerce</option>


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
                  <label class="control-label" for="shift">Shift</label>

                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                      <select name="shift" required="true" class="form-control" >
                        <option value="Day">Day</option>
                          <option value="Morning">Morning</option>
                     </select>

                  </div>
                </div>
                  </div>
                </div>
              </div>

            <div class="row">
              <div class="col-md-12">
                  <h3 class="text-info"> Student's Detail</h3>
                  <hr>
              </div>
            </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="fname">First Name</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                              <input type="text" class="form-control" required name="fname" placeholder="First Name">
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="mname">Midle Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <input type="text" class="form-control"  name="mname" placeholder="Midle Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="lname">Last Name</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                              <input type="text" class="form-control" required name="lname" placeholder="Last Name">
                          </div>
                      </div>
                      </div>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <div class="form-group">
                        <label class="control-label" for="gender">Gender</label>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <select name="gender" class="form-control" required >

                                <option value="Male">Male</option>
                               <option value="Female">Female</option>
                              <option value="Other">Other</option>
                            </select>
                        </div>
                      </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                          <label class="control-label" for="religion">Religion</label>

                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                              <select name="religion" class="form-control" required >
                                    <option value="Islam">Islam</option>
                                  <option value="Hindu">Hindu</option>
                                  <option value="Cristian">Cristian</option>
                                  <option value="Buddhist">Buddhist</option>
                                  <option value="Other">Other</option>
                              </select>
                          </div>
                        </div>
                          </div>
                      <div class="col-md-4">
                        <div class="form-group">
                        <label class="control-label" for="bloodgroup">Bloodgroup</label>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                            <select name="bloodgroup" class="form-control" required >
                      				<option value="A+">A+</option>
                      				<option value="A-">A-</option>
                      				<option value="B+">B+</option>
                      				<option value="B-">B-</option>
                      				<option value="AB+">AB+</option>
                      				<option value="AB-">AB-</option>
                      				<option value="O+">O+</option>
                      				<option value="O-">O-</option>
		                     	</select>

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
                              <label for="nationality">Nationality</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" class="form-control" required  name="nationality" placeholder="Nationality">
                              </div>
                          </div>
                        </div>

                          <div class="col-md-4">
                            <div class="form-group ">
                                             <label for="dob">Date Of Birth</label>
                                                 <div class="input-group">

                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                    <input type="text"   class="form-control datepicker" name="dob" required  data-date-format="dd/mm/yyyy">
                                                </div>


                                         </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group ">
                              <label for="photo">Photo</label>
                              <input id="photo" name="photo" required type="file">
                              </div>
                            </div>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">


                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="extraActivity">Extra Curicular Activity </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <input type="text" class="form-control"  name="extraActivity" placeholder="Sport,Writing,etc">
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="remarks">Remarks </label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" class="form-control"  name="remarks" placeholder="Remarks">
                              </div>
                          </div>
                          </div>
                      </div>
                    </div>



                      <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-info"> Guardian's Detail</h3>
                            <hr>
                        </div>
                      </div>
                        <div class="row">
                          <div class="col-md-12">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="fatherName">Father's Name </label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" class="form-control" required  name="fatherName" placeholder="Name">
                              </div>
                          </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="fatherCellNo">Father's Mobile No </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                    <input type="text" class="form-control"  required name="fatherCellNo" placeholder="+8801xxxxxxxxx">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="motherName">Mother's Name </label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                      <input type="text" class="form-control" required  name="motherName" placeholder="Name">
                                  </div>
                              </div>
                              </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="motherCellNo">Mother's Mobile No </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <input type="text" class="form-control" required name="motherCellNo" placeholder="+8801xxxxxxxxx">
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="localGuardian">Local Guardian Name </label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" class="form-control"  name="localGuardian" placeholder="Name">
                              </div>
                          </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="localGuardianCell">local Guardian Mobile No </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                    <input type="text" class="form-control"  name="localGuardianCell" placeholder="+8801xxxxxxxxx">
                                </div>
                            </div>
                            </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                    <h3 class="text-info"> Address Detail</h3>
                    <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                          <div class="col-md-6">
                        <div class="form-group">
                            <label for="presentAddress">Present Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker blue"></i></span>
                                <textarea type="text" class="form-control" required name="presentAddress" placeholder="Address"></textarea>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="parmanentAddress">Parmanent Address</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker blue"></i></span>
                                  <textarea type="text" class="form-control" required name="parmanentAddress" placeholder="Address"></textarea>
                              </div>
                          </div>
                          </div>
              </div>
            </div>

                    <div class="clearfix"></div>

                                <div class="form-group">
                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i>Add</button>
                    <br>
                  </div>
                </form>






        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">

    $( document ).ready(function() {

      $('.datepicker').datepicker({autoclose:true});
      $(".datepicker2").datepicker( {
    format: " yyyy", // Notice the Extra space at the beginning
    viewMode: "years",
    minViewMode: "years",
    autoclose:true
}).on('changeDate', function (ev) {

          var aclass = $('#class').val();
          var session = $('#session').val().trim();
          var section=$('#section').val().trim();
          $.ajax({
              url: '/student/getRegi/'+aclass+'/'+session+'/'+section,
              data: {
                  format: 'json'
              },
              error: function(error) {
                  alert(error);
              },
              dataType: 'json',
              success: function(data) {

                  $('#regiNo').val(data[0]);
                  $('#rollNo').val(data[1]);

              },
              type: 'GET'
          });


        });

    });

</script>
@stop
