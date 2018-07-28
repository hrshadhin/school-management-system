import Chart from 'chart.js';

require('fullcalendar');

class Dashboard {
    static init() {
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

    }
}

window.Dashboard = Dashboard;
