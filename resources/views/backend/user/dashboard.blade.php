<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Dashboard @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-orange-dark" href="#">
                        <div class="icon bg-orange-dark" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-student"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                150                  </h3>
                            <p class="text-white">
                                Student </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-pink-light" href="#">
                        <div class="icon bg-pink-light" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-teacher"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                12                  </h3>
                            <p class="text-white">
                                Teacher </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-teal-light" href="#">
                        <div class="icon bg-teal-light" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-subject"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                80                  </h3>
                            <p class="text-white">
                                Subject </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-purple-light" href="#">
                        <div class="icon bg-purple-light" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa icon-subject"></i>
                        </div>
                        <div class="inner ">
                            <h3 class="text-white">
                                80                  </h3>
                            <p class="text-white">
                                Books </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
       <div class="row">
           <div class="col-md-12">
               <div class="box box-success">
                   <div class="box-header with-border x_title">
                       <h3>Accounting Report</h3>
                       <label class="total_bal">
                           Balance: 7022771.82
                       </label>

                   </div>
                   <!-- /.box-header -->
                   <div class="box-body">

                       <canvas id="accountChart" style="width: 821px; height: 136px;"></canvas>
                   </div>
                   <!-- /.box-body -->
               </div>
               <!-- /.box -->
           </div>
       </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-body" style="max-height: 342px;">
                        <canvas id="attendanceChart" style="width: 400px; height: 150px;"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>


    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        $(document).ready(function () {
            var config = {
                type: 'line',
                data: {
                    labels: ["January,2018","February,2018","March,2018","April,2018","May,2018","June,2018","July,2018","August,2018","September,2018","October,2018","November,2018","December,2018"],
                    datasets: [{
                        label: "Income",
                        backgroundColor: "#82E0AA",
                        borderColor: "#58D68D",
                        pointBorderColor: "#28B463",
                        pointBackgroundColor: "#2ECC71",
                        pointHoverBackgroundColor: "#82E0AA",
                        pointHoverBorderColor: "#58D68D",
                        pointBorderWidth: 1,
                        data: [
                            52662545.31,
                            32271914.00,
                            20651857.91,
                            31068496.90,
                            26380827.16,
                            405006.00,
                            0.00,
                            0.00,
                            0.00,
                            0.00,
                            0.00,
                            0.00
                        ]
                    }, {
                        label: "Expence",
                        backgroundColor: "#F1948A",
                        borderColor: "#EC7063",
                        pointBorderColor: "#CB4335",
                        pointBackgroundColor: "#E74C3C",
                        pointHoverBackgroundColor: "#F1948A",
                        pointHoverBorderColor: "#EC7063",
                        pointBorderWidth: 1,
                        data: [
                            57301010.42,
                            32220143.00,
                            20669087.91,
                            27231585.68,
                            25534450.16,
                            20450.00,
                            0.00,
                            0.00,
                            0.00,
                            0.00,
                            0.00,
                            0.00
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                    },
                    hover: {
                        mode: 'index'
                    }

                }
            };

            var ctx = document.getElementById('accountChart').getContext('2d');
            var accountChart = new Chart(ctx, config);


            var config = {
                type: 'line',
                data: {
                    labels: ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'],
                    datasets: [{
                        label: 'Present',
                        data: [
                            30,
                            20,
                            25,
                            28,
                            26,
                            15,
                            18,
                            22,
                            24,
                            30
                        ],
                        backgroundColor:  "rgb(54, 162, 235)",
                        borderColor:  "rgb(54, 162, 235)",
                        fill: false,
                        pointRadius: 6,
                        pointHoverRadius: 20,
                    }, {
                        label: 'Absent',
                        data: [
                            0,
                            10,
                            5,
                            2,
                            5,
                            15,
                            12,
                            8,
                            6,
                            0
                        ],
                        backgroundColor: "rgb(255, 99, 132)",
                        borderColor: "rgb(255, 99, 132)",
                        fill: false,
                        pointRadius: 6,
                        pointHoverRadius: 20,

                    }
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    hover: {
                        mode: 'index'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Class'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Attendace'
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: 'Students Today\'s Attendance'
                    }
                }
            };

            var ctx = document.getElementById('attendanceChart').getContext('2d');
            var attendanceChart = new Chart(ctx, config);



            $('#calendar').fullCalendar({
                defaultView: 'month',
                height: 300,
                contentHeight: 250
            });




        });

    </script>
@endsection
<!-- END PAGE JS-->
