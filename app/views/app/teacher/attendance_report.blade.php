<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Employee Attendance Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- The styles -->
  <link id="bs-css" href="<?php echo url();?>/css/bootstrap-cerulean.min.css" rel="stylesheet">

  <link href="<?php echo url();?>/css/charisma-app.css" rel="stylesheet">
  <style>
    @media print
    {
      .no-print, .no-print *
      {
        display: none !important;
      }
    }
    #footer
    {

      width:100%;
      height:50px;
      position:absolute;
      bottom:0;
      left:0;
    }
    .logo{
      height:80px;
      width: 100px;
    }
    #attendanceList th,#attendanceList td{
      text-align: center;
    }
    .badge-warning {
      background-color: #f89406;
    }

    .badge-success {
      background-color: #468847;
    }


    /*@media print {*/
      /*table#attendanceList {*/
        /*-webkit-print-color-adjust: exact;*/
      /*}}*/

    /*@media print {*/
      /**/
     /*}*/
  </style>
</head>
<body>
{{--<div class="row">--}}
  {{--<div class="col-md-12">--}}
  {{--<a  class="btn btn-danger no-print" href="/teacher-attendance/list"><i class=""></i>Back</a>--}}
{{--</div>--}}
{{--</div>--}}
<div id="printableArea">
  <div class="row text-center">

    <div class="col-md-1 col-sm-1">
      <img class="logo" src="{{url()}}/img/logo.png">
    </div>
    <div class="col-md-11 col-sm-11">
      <h4><strong>{{$institute->name}}</strong></h4>
      <h5><strong>Establish:</strong> {{$institute->establish}}  <strong>Web:</strong> {{$institute->web}}  <strong>Email:</strong> {{$institute->email}}</h5>
      <h5><strong>Phone:</strong> {{$institute->phoneNo}} <strong>Address:</strong> {{$institute->address}}</h5>
    </div>



  </div>

   <div class="row">
    <div class="col-md-12 text-center">
      <h5>
        @if($searchType=='1')
        <strong>Employee Attendance Report @if($egroup)[{{$egroup}}] @endif</strong>
        @else
          <strong>Employee Attendance Report</strong>
        @endif
      </h5>
      @if($regNo)
        @if(count($attendance))
        <h6>Name: <strong>{{$attendance[0]->teacher->fullName}}</strong></h6>
          @endif
      @endif
      <h6><strong>Time Period: </strong> {{date('d/m/Y',strtotime($dateFrom))}} <strong>To</strong> {{date('d/m/Y',strtotime($dateTo))}}</h6>
    </div>
  </div>
  <hr>
      @if($attendance)
        <div class="row">
          <div class="col-md-12">
            <table id="attendanceList" class="table table-striped table-bordered table-hover">
              <thead>
              <tr>
                <th>Employee No</th>
                <th>Name</th>
                <th>Date</th>
                <th>dIN_TIME</th>
                <th>dOUT_TIME</th>
                <th>nWorking_HOUR</th>
                <th>vSTATUS</th>
              </tr>
              </thead>
              <tbody>
              @if($regNo)
                @define $totalDay = 0
                @define $totalHour = 0

              @endif

              @foreach($attendance as $atd)
                <tr>
                  <td>{{$atd->regNo}}</td>
                  <td>{{$atd->teacher->fullName}}</td>
                  <td>{{$atd->date->format('d/m/Y')}}</td>
                  <td>
                    @if($atd->dIN_TIME!="00:00:00")
                      {{date('h:i:s a', strtotime($atd->dIN_TIME))}}
                    @else
                      {{$atd->dIN_TIME}}
                    @endif
                  </td>
                  <td>
                    @if($atd->dOUT_TIME!="00:00:00")
                      {{date('h:i:s a', strtotime($atd->dOUT_TIME))}}
                    @else
                      {{$atd->dOUT_TIME}}
                    @endif
                  </td>
                  <td>
                        {{SmsHelper::clockalize($atd->nWorkingHOUR)}}
                  </td>
                  <td>
{{--                    {{$atd->vSTATUS}}--}}
                    {{--@if($atd->vSTATUS=="A")--}}
                      {{--<span class="badge badge-warning">A</span>--}}
                    {{--@else--}}
                      {{--<span class="badge badge-success">P</span>--}}
                    {{--@endif--}}
                    @if($atd->vSTATUS=="A")
                      @if(isset($holiDays[$atd->date->format('Y-m-d')]))
                        <span class="badge badge-success">H</span>
                      @elseif(isset($empWorks[$atd->regNo]) && isset($empWorks[$atd->regNo][$atd->date->format('Y-m-d')]))
                        <span class="badge badge-success">WO</span>
                      @else
                        <span class="badge badge-warning">A</span>
                      @endif
                    @else
                      <span class="badge badge-success">P</span>
                    @endif

                  </td>
                  @if($regNo)
                    @define $totalDay += 1
                    @define $totalHour += $atd->nWorkingHOUR

                @endif
              @endforeach
              </tbody>

              @if($regNo)
                <tfoot>
                <tr>
                  <td colspan="2">Total</td>
                  <td>{{$totalDay}}(Days)</td>
                  <td></td>
                  <td></td>
                  <td>
                    {{SmsHelper::clockalize($totalHour)}}
                  </td>
                  <td></td>

                </tr>
                </tfoot>
              @endif

            </table>
            <p>Print Date: {{date('d/m/Y')}}</p>
          </div>


        </div>
      @endif

</div>
<script src="<?php echo url();?>/bower_components/jquery/jquery.min.js"></script>
<script src="<?php echo url();?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $( document ).ready(function() {

       window.print();

    });
</script>
</body>
</html>
