@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">
@stop
@section('content')

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Student Information Edit</h2>

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
                    @if (isset($student))
                        <form role="form" action="/student/update" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $student->id }}">
                            <input type="hidden" name="oldphoto" value="{{ $student->photo }}">
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
                                            <label for="regiNo">Registration No</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" readonly name="regiNo" value="{{$student->regiNo}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rollNo">Card/Roll No</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="rollNo" value="{{$student->rollNo}}" placeholder="Class roll no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="session">session</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                <input type="text" value="{{$student->session}}"  class="form-control datepicker2" name="session" required  data-date-format="yyyy">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="class">Class</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                {{ Form::select('class',$classes,$student->class,['class'=>'form-control','required'=>'true'])}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="group">Group</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                {{ Form::select('group',['All'=>'N/A','Science'=>'Science','Arts'=>'Arts','Commerce'=>'Commerce'],$student->group,['class'=>'form-control','required'=>'true'])}}


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label" for="section">Section</label>

                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <?php  $data=[
                                                    'A'=>'A',
                                                    'B'=>'B',
                                                    'C'=>'C',
                                                    'D'=>'D',
                                                    'E'=>'E',
                                                    'F'=>'F',
                                                    'G'=>'G',
                                                    'H'=>'H',
                                                    'I'=>'I',
                                                    'J'=>'J'
                                                ];?>
                                                {{ Form::select('section',$data,$student->section,['class'=>'form-control','required'=>'true'])}}



                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label" for="shift">Shift</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <?php  $data=[
                                                    'Day'=>'Day',
                                                    'Morning'=>'Morning'
                                                ];?>
                                                {{ Form::select('shift',$data,$student->shift,['class'=>'form-control','required'=>'true'])}}


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-warning">Attention!!!</h3>
                                    <div class="alert alert-warning">
                                        <h5 class="text-danger">
                                            <i class="glyphicon glyphicon-hand-right"></i>
                                             In fourth subject code field put correct 4th subject code.
                                        </h5>
                                        <h5 class="text-danger">
                                            <i class="glyphicon glyphicon-hand-right"></i>
                                            If student change 4th subject with other subject,<br>
                                            then put the 4th subject code in fourth subject code feild and alternate subject code <br>
                                            in alternate subject code field.
                                        </h5>
                                        <h5 class="text-danger">
                                            <i class="glyphicon glyphicon-hand-right"></i>
                                            If student doesn't change 4th subject with other subject,<br>
                                            then leave the alternate subject code field empty.
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" for="fourthSubject">Fourth Subject Code<br><span class="text-danger">* leave empty if not have 4th subject</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" value="{{$student->fourthSubject}}"  name="fourthSubject" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" for="fourthSubject">Alternate Subject Code<br><span class="text-danger">* leave empty if not exchange subjects</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" value="{{$student->cphsSubject}}"  name="cphsSubject" placeholder="">
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
                                                <input type="text" class="form-control" value="{{$student->firstName}}" required name="fname" placeholder="First Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="mname">Midle Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" value="{{$student->middleName}}"  name="mname" placeholder="Midle Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lname">Last Name</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" value="{{$student->lastName}}" required name="lname" placeholder="Last Name">
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
                                                <?php  $data=[
                                                    'Male'=>'Male',
                                                    'Female'=>'Female',
                                                    'Other'=>'Other'

                                                ];?>
                                                {{ Form::select('gender',$data,$student->gender,['class'=>'form-control','required'=>'true'])}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                                {{ Form::select('religion',$data,$student->religion,['class'=>'form-control','required'=>'true'])}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                                {{ Form::select('bloodgroup',$data,$student->bloodgroup,['class'=>'form-control','required'=>'true'])}}

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
                                                <input type="text" class="form-control" value="{{$student->nationality}}" required  name="nationality" placeholder="Nationality">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="dob">Date Of Birth</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                <input type="text" value="{{$student->dob}}"  class="form-control datepicker" name="dob" required  data-date-format="dd/mm/yyyy">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="photo">Photo</label>
                                            <input id="photo" name="photo"  type="file">
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
                                                <input type="text" class="form-control" value="{{$student->extraActivity}}"  name="extraActivity" placeholder="Sport,Writing,etc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="remarks">Remarks </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control"  value="{{$student->remarks}}"   name="remarks" placeholder="Remarks">
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
                                                <input type="text" class="form-control" value="{{$student->fatherName}}"  required  name="fatherName" placeholder="Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fatherCellNo">Father's Mobile No </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" value="{{$student->fatherCellNo}}" required name="fatherCellNo" placeholder="+8801xxxxxxxxx">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="motherName">Mother's Name </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required  value="{{$student->motherName}}"  name="motherName" placeholder="Name">
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
                                                <input type="text" class="form-control" value="{{$student->motherCellNo}}"  required name="motherCellNo" placeholder="+8801xxxxxxxxx">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardian">Local Guardian Name </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" value="{{$student->localGuardian}}"  name="localGuardian" placeholder="Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardianCell">local Guardian Mobile No </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control"  value="{{$student->localGuardianCell}}"  name="localGuardianCell" placeholder="+8801xxxxxxxxx">
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
                                                <textarea type="text" class="form-control" required name="presentAddress" placeholder="Address">{{$student->presentAddress}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parmanentAddress">Parmanent Address</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker blue"></i></span>
                                                <textarea type="text" class="form-control" required name="parmanentAddress" placeholder="Address">{{$student->parmanentAddress}}</textarea>
                                            </div>
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
