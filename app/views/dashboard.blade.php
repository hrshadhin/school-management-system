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

</style>
@stop
@section('content')
@if (Session::get('accessdined'))
<div class="alert alert-danger">
  <button data-dismiss="alert" class="close" type="button">×</button>
  <strong>Process Faild.</strong> {{ Session::get('accessdined')}}

</div>
@endif
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <!-- /top tiles -->
    <div class="row tile_count text-center">
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-2x fa-home green"></i>     Class</span>
        <div class="count red">{{$total['class']}}</div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-2x fa-users green"></i> Students</span>
        <div class="count blue">{{$total['student']}}</div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-2x fa-file green"></i> Subjects</span>
        <div class="count yellow">{{$total['subject']}}</div>
      </div>
    </div>
    <div class="row tile_count text-center">
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-2x fa-edit green"></i> Attendance(Days)</span>
        <div class="count red">{{$total['attendance']}}</div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-2x fa-pencil green"></i> Exams</span>
        <div class="count blue">{{$total['exam']}}</div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-2x fa-book green"></i> Books</span>
        <div class="count yellow">{{$total['book']}}</div>
      </div>
    </div>
    <!-- /top tiles -->
    <!-- Graph start -->
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Accounting Report<small>(Monthly)</small></h2>
            <label class="total_bal">
              Balance: {{$balance}}
            </label>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
            <canvas height="136" id="lineChart" width="821" style="width: 821px; height: 136px;"></canvas>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>



@stop
@section("script")
<script src="<?php echo url();?>/js/Chart.min.js"></script>

<script>
Chart.defaults.global.legend = {
  enabled: false
};

// Line chart
   var ctx = document.getElementById("lineChart");
   var lineChart = new Chart(ctx, {
     type: 'line',
     data: {
       labels: ["<?php echo join($incomes['key'], '","')?>"],
       datasets: [{
         label: "Income",
         backgroundColor: "rgba(38, 185, 154, 0.31)",
         borderColor: "rgba(38, 185, 154, 0.7)",
         pointBorderColor: "rgba(38, 185, 154, 0.7)",
         pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
         pointHoverBackgroundColor: "#fff",
         pointHoverBorderColor: "rgba(220,220,220,1)",
         pointBorderWidth: 1,
         data: [<?php echo join($incomes['value'], ',')?>]
       }, {
         label: "Expence",
         backgroundColor: "rgba(3, 88, 106, 0.3)",
         borderColor: "rgba(3, 88, 106, 0.70)",
         pointBorderColor: "rgba(3, 88, 106, 0.70)",
         pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
         pointHoverBackgroundColor: "#fff",
         pointHoverBorderColor: "rgba(151,187,205,1)",
         pointBorderWidth: 1,
         data: [<?php echo join($expences['value'], ',')?>]
       }]
     },
   });



</script>
@stop
