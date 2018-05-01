@extends('layouts.master')
@section("style")
  <link href='<?php echo url();?>/css/custom.min.css' rel='stylesheet'>
  <link href='<?php echo url();?>/font-awesome/css/font-awesome.min.css' rel='stylesheet'>

  <style>
    .fc-today{
      background-color: #2AA2E6;
      color:#fff;


    }
    .fc-button-today
    {
      display: none;
    }
    .green{
      color: #1ABB9C;
    }
    .tile_count .tile_stats_count_nb:before {
      border-left: none !important;
    }
  </style>
@stop
@section('content')
  <div class="row">
    <div class="box col-md-12">
      <div class="box-inner">
        <div data-original-title="" class="box-header well">
          <h2><i class="glyphicon glyphicon-book"></i> Employee Information</h2>

        </div>
        <div class="box-content">
          @if (isset($teacher))

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <img class="img responsive-img" style="height:150px;width:200px;" src="<?php echo url();?>/images/teachers/{{$teacher->photo}}" alt="Photo">
                </div>
                <div class="col-md-4"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Employee No :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->regNo}}</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Full Name :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->fullName}}</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Employee type :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->egroup}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Gender :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->gender}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Religion :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->religion}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Bloodgroup :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->bloodgroup}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Nationality :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->nationality}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Date Of Birth :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->dob}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Join Date :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->joinDate}} </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Education Qualification :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->educationQualification}} </label>
                </div>
              </div>
            </div>


               <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Mobile No :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->cellNo}} </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Present Address :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->presentAddress}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Parmanent Address :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->parmanentAddress}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Details :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$teacher->details}} </label>
                </div>
              </div>
            </div>

            <hr>
            <div class="row tile_count text-center">

              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count tile_stats_count_nb">
                <span class="count_top"><i class="fa fa-2x fa-level-down green"></i><b> Casual Leave(CL)</b></span>
                <div class="count blue">{{$cl}}/20</div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-2x fa-level-down green"></i><b> Sick Leave(ML)</b></span>
                <div class="count red">{{$ml}}/10</div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-2x fa-level-down green"></i><b> Undefined Leave(UL)</b></span>
                <div class="count purple">{{$ul}}/&infin;</div>
              </div>

            </div>


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

