<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Monthly Attendance Report Two</title>
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

      table{
        border-collapse:collapse;
      }
      tr td{
        page-break-inside: avoid;
        white-space: nowrap;
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
    #attendanceList{
      font-size: 10px;
    }
    #attendanceList th,#attendanceList td{
      text-align: center;
      vertical-align: middle !important;
    }
    #attendanceList tr td{
      padding: 2px;
    }
    body {
      -webkit-print-color-adjust: exact;
      padding: 0;
      margin: 0;
    }

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
        <strong>Monthly Attendance Report</strong>
      </h5>
      <h6><strong>Month: </strong> {{date('F,Y',strtotime($yearMonth))}}</h6>
    </div>
  </div>
  @if($data)
    <div class="">
      <table id="attendanceList" class="table table-bordered">
        <thead>
        <tr>
          @foreach($keys as $index=>$key)
            @if($index>2)
              <th>{{date('d-M',strtotime($key))}}</th>
            @elseif($index==1)
            @else
              <th>{{$key}}</th>
            @endif
          @endforeach
          <th>Present</th>
          <th>Absent</th>
          <th>ToT.DAYS</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $datum)
          <tr>
              <?php
              $row = (array) $datum;
              $totalP = 0;
              $totalA = 0;
              $empRegNo = '';
              ?>
            @foreach($keys as $index=>$key)
              @if($index==0)
                <td rowspan="4">{{$row[$key]}}</td>
              @elseif($index==1)
                      <?php $empRegNo = $row[$key]; ?>
              @elseif($index==2)
                <td>STATUS</td>

              @else
                      <?php
                      $symbol = "-";
                      $color = "blue";
                      ?>

                @if(isset($fridays[$key]))
                          <?php
                          $symbol = "F";
                          $totalP++;
                          $color = "green";
                          ?>
                @elseif(isset($holiDays[$key]))
                          <?php
                          $symbol = "H";
                          $totalP++;
                          $color = "green";
                          ?>
                @elseif($row[$key]=="P")
                          <?php
                          $symbol = "P";
                          $totalP++;
                          ?>
                @elseif($row[$key]=="A")
                          <?php
                          $symbol = "A";
                          $totalA++;
                          $color = "red";
                          ?>
                  @if(isset($empLeaves[$empRegNo]) && isset($empLeaves[$empRegNo][$key]))
                              <?php
                              $symbol = "L";
                              ?>
                  @endif
                  @if(isset($empWorks[$empRegNo]) && isset($empWorks[$empRegNo][$key]))
                              <?php
                              $symbol = "WO";
                              $totalP++;
                              $color = "green";
                              $totalA--;
                              ?>
                  @endif
                @else
                          <?php
                          $symbol = "-";
                          $color = "blackil";
                          ?>
                @endif
                @if($index != 0 && $index!=1)
                  <td style="color:{{$color}};">{{$symbol}}</td>
                @endif
              @endif

            @endforeach
            <td rowspan="3">{{$totalP}}</td>
            <td rowspan="3">{{$totalA}}</td>
            <td rowspan="3">{{($totalP+$totalA)}}</td>
          </tr>
          <tr>
              <?php
              $empRegNo = '';
              ?>
            @foreach($keys as $index=>$key)
              @if($index==0)
              @elseif($index==1)
                      <?php $empRegNo = $row[$key]; ?>
              @elseif($index==2)
                <td>IN_TIME</td>
              @else
                <td>
                  @if(isset($prityData[$empRegNo][$key]) && $prityData[$empRegNo][$key]['in'] !="00:00:00")
                    {{date('h:i:s a', strtotime($prityData[$empRegNo][$key]['in']))}}
                  @else
                    {{isset($prityData[$empRegNo][$key]) ? $prityData[$empRegNo][$key]['in'] : '-'}}
                  @endif
                </td>

              @endif
            @endforeach
          </tr>
          <tr>
              <?php
              $empRegNo = '';
              ?>
            @foreach($keys as $index=>$key)
              @if($index==0)
              @elseif($index==1)
                      <?php $empRegNo = $row[$key]; ?>
              @elseif($index==2)
                <td>OUT_TIME</td>
              @else

                  @if(isset($prityData[$empRegNo][$key]) && $prityData[$empRegNo][$key]['out'] !="00:00:00")
                    @if(strtotime($prityData[$empRegNo][$key]['out']) < strtotime('15:00:00'))
                      <td style="background: red; color: white;">{{date('h:i:s a', strtotime($prityData[$empRegNo][$key]['out']))}}</td>
                    @else
                      <td>{{date('h:i:s a', strtotime($prityData[$empRegNo][$key]['out']))}}</td>
                    @endif
                  @else
                    <td>{{isset($prityData[$empRegNo][$key]) ? $prityData[$empRegNo][$key]['out'] : '-'}}</td>
                  @endif

              @endif
            @endforeach
          </tr>
          <tr>
              <?php
                  $totalH = 0;
              $empRegNo = '';
              ?>
            @foreach($keys as $index=>$key)
              @if($index==0)
              @elseif($index==1)
                      <?php $empRegNo = $row[$key]; ?>
              @elseif($index==2)
                <td>Working Hour</td>
              @else
                  <td>
                    @if(isset($prityData[$empRegNo][$key]))
                      <?php
                            $totalH += $prityData[$empRegNo][$key]['work'];
                       ?>
                      {{SmsHelper::clockalize($prityData[$empRegNo][$key]['work'])}}
                      @else
                      -
                    @endif
                  </td>
              @endif
            @endforeach
            <td colspan="3">
              {{SmsHelper::clockalize($totalH)}}
            </td>
          </tr>

        @endforeach
        </tbody>
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
