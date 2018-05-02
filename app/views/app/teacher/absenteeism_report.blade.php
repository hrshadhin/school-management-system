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
    /*.badge-warning {*/
      /*background-color: #f89406;*/
    /*}*/
    /*.badge-warning:hover {*/
      /*background-color: #c67605;*/
    /*}*/
    /*.badge-success {*/
      /*background-color: #468847;*/
    /*}*/
    /*.badge-success:hover {*/
      /*background-color: #356635;*/
    /*}*/

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
        <strong>{{$egroup}} Absenteeism Report</strong>
      </h5>
      <h6><strong>Time Period: </strong> {{date('d/m/Y',strtotime($dateFrom))}} <strong>To</strong> {{date('d/m/Y',strtotime($dateTo))}}</h6>
    </div>
  </div>
  <hr>
      @if($data)
        <div class="row">
          <div class="col-md-12">
            <table id="attendanceList" class="table table-striped table-bordered table-hover">
              <thead>
              <tr>
                <th>Date</th>
                <th>Tot_strength</th>
                <th>Tot_pre</th>
                <th>Tot_abs</th>
                <th>%of_abs</th>
                <th>%of_pre</th>
              </tr>
              </thead>
              <tbody>

              @foreach($data as $atd)
                <tr>
                  <td>{{$atd->date->format('j-M-y')}}</td>
                  <td>{{$atd->total}}</td>
                  <td>{{$atd->present}}</td>
                  <td>{{$atd->absent}}</td>
                  <td>{{number_format((($atd->absent/$atd->total)*100),2)}}</td>
                  <td>{{number_format((($atd->present/$atd->total)*100),2)}}</td>
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
