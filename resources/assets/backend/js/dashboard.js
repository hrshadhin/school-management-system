import Chart from 'chart.js';

class Dashboard {
    static init() {
        var chartElement = document.getElementById('attendanceChart');
        if(chartElement) {
            var config = {
                type: 'line',
                data: {
                    labels:  window.attendanceLabel,
                    datasets: [{
                        label: 'Present',
                        data: window.presentData,
                        backgroundColor: "rgb(54, 162, 235)",
                        borderColor: "rgb(54, 162, 235)",
                        fill: false,
                        pointRadius: 6,
                        pointHoverRadius: 20,
                    }, {
                        label: 'Absent',
                        data: window.absentData,
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
                        display: false,
                        text: 'Students Today\'s Attendance'
                    }
                }
            };
            var ctx = chartElement.getContext('2d');
            new Chart(ctx, config);
        }
    }
}

window.Dashboard = Dashboard;
