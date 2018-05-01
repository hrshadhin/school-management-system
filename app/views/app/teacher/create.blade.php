@extends('layouts.master')
@section('style')
<link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
@stop
@section('content')
@if (Session::get('success'))
<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
  <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/teacher/list">View List</a><br>

</div>
@endif
<div class="row">
  <div class="box col-md-12">
    <div class="box-inner">
      <div data-original-title="" class="box-header well">
        <h2><i class="glyphicon glyphicon-user"></i> New Employee Etnry</h2>

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
        <form role="form" action="/teacher/create" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="row">
            <div class="col-md-12">
              <h3 class="text-info"> Employee's Detail</h3>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fullName">Full Name</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                    <input type="text" class="form-control" required name="fullName" placeholder="Full Name">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="regNo">Employee No</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                    <input type="text" class="form-control" required name="regNo" value="" placeholder="">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="gender">Employee type</label>

                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                    <select name="egroup" class="form-control" required >
                      <option value="Teacher">Teacher</option>
                      <option value="Staff">Staff</option>
                    </select>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-3">
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
              <div class="col-md-3">
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
              <div class="col-md-3">
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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nationality">Nationality</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                    <input type="text" class="form-control" value="Bangladeshi" required  name="nationality" placeholder="Nationality">
                  </div>
                </div>
              </div>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">

            <div class="col-md-2">
              <div class="form-group ">
                <label for="dob">Date Of Birth</label>
                <div class="input-group">

                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                  <input type="text"   class="form-control datepicker" name="dob" required  data-date-format="dd/mm/yyyy">
                </div>


              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group ">
                <label for="joinDate">Join Date</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                  <input type="text"   class="form-control datepicker" name="joinDate" required  data-date-format="dd/mm/yyyy">
                </div>

              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="educationQualification">Last Education Certificate</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                  <input type="text" class="form-control"  name="educationQualification" placeholder="HSC,Degree,Hons,MA etc">
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
                <label for="cellNo">Mobile No </label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                  <input type="text" class="form-control"  name="cellNo" placeholder="+8801xxxxxxxxx" required>
                </div>
              </div>
            </div>


            <div class="col-md-4">
              <div class="form-group">
                <label for="presentAddress">Present Address</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker blue"></i></span>
                  <textarea type="text" class="form-control" required name="presentAddress" placeholder="Address"></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-4">
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
        <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                <label for="details">Details </label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                  <textarea  class="form-control" rows="5"  name="details" placeholder="details other information"> </textarea>
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
});

</script>
@stop
