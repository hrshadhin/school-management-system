@extends('layouts.master')
@section('style')
<link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
@stop
@section('content')

<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-user"></i> Update employee information </h2>

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
              @if (isset($teacher))
              <form role="form" action="/teacher/update" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $teacher->regNo }}">
                  <input type="hidden" name="oldphoto" value="{{ $teacher->photo }}">

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
                                          <input type="text" class="form-control" required name="fullName" value="{{$teacher->fullName}}" placeholder="Full Name">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="regNo">Employee No</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <input type="text" class="form-control" readonly name="regNo" value="{{$teacher->regNo}}" placeholder="">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="control-label" for="gender">Employee type</label>

                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <?php  $data=[
                                              'Teacher'=>'Teacher',
                                              'Staff'=>'Staff',
                                          ];?>
                                          {{ Form::select('egroup',$data,$teacher->egroup,['class'=>'form-control','required'=>'true'])}}
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
                                          <?php  $data=[
                                              'Male'=>'Male',
                                              'Female'=>'Female',
                                              'Other'=>'Other'

                                          ];?>
                                          {{ Form::select('gender',$data,$teacher->gender,['class'=>'form-control','required'=>'true'])}}
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <label class="control-label" for="religion">Religion</label>

                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <?php  $data=[
                                              'Islam'=>'Islam',
                                              'Hindu'=>'Hindu',
                                              'Cristian'=>'Cristian',
                                              'Buddhist'=>'Buddhist',
                                              'Other'=>'Other'

                                          ];?>
                                          {{ Form::select('religion',$data,$teacher->religion,['class'=>'form-control','required'=>'true'])}}

                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <label class="control-label" for="bloodgroup">Bloodgroup</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <?php  $data=[
                                              'A+'=>'A+',
                                              'A-'=>'A-',
                                              'B+'=>'B+',
                                              'B+'=>'B+',
                                              'AB+'=>'AB+',
                                              'AB-'=>'AB-',
                                              'O+'=>'O+',
                                              'O-'=>'O-',

                                          ];?>
                                          {{ Form::select('bloodgroup',$data,$teacher->bloodgroup,['class'=>'form-control','required'=>'true'])}}

                                      </div>

                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <label for="nationality">Nationality</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <input type="text" class="form-control"  value="{{$teacher->nationality}}" required  name="nationality" placeholder="Nationality">
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
                                          <input type="text" value="{{$teacher->dob}}"  class="form-control datepicker" name="dob" required  data-date-format="dd/mm/yyyy">
                                      </div>


                                  </div>
                              </div>
                              <div class="col-md-2">
                                  <div class="form-group ">
                                      <label for="joinDate">Join Date</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                          <input type="text" value="{{$teacher->joinDate}}"  class="form-control datepicker" name="joinDate" required  data-date-format="dd/mm/yyyy">
                                      </div>

                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="educationQualification">Last Education Certificate</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                          <input type="text" class="form-control" value="{{$teacher->educationQualification}}"  name="educationQualification" placeholder="HSC,Degree,Hons,MA etc">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group ">
                                      <label for="photo">Photo</label>
                                      <input id="photo" name="photo" type="file">
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
                                          <input type="text" class="form-control" value="{{$teacher->cellNo}}"  name="cellNo" placeholder="+8801xxxxxxxxx" required>
                                      </div>
                                  </div>
                              </div>


                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="presentAddress">Present Address</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker blue"></i></span>
                                          <textarea type="text" class="form-control" required name="presentAddress" placeholder="Address">{{$teacher->presentAddress}}</textarea>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="parmanentAddress">Parmanent Address</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker blue"></i></span>
                                          <textarea type="text" class="form-control" required name="parmanentAddress" placeholder="Address">{{$teacher->parmanentAddress}}</textarea>
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
                                      <textarea  class="form-control" rows="5"  name="details" placeholder="details other information">{{$teacher->details}}</textarea>
                                  </div>
                              </div>
                          </div>
                      </div>

                    <div class="clearfix"></div>

                                <div class="form-group">
                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-check"></i>Update</button>
                    <br>
                  </div>
                </form>
              @else
                      <div class="alert alert-danger">
                          <strong>Whoops!</strong>There is no such teacher!<br><br>
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
<script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">

    $( document ).ready(function() {

      $('.datepicker').datepicker({autoclose:true});
      $(".datepicker2").datepicker( {
    format: " yyyy", // Notice the Extra space at the beginning
    viewMode: "years",
    minViewMode: "years",
    autoclose:true
});


    });


</script>
@stop
