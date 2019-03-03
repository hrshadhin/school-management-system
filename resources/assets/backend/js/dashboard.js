import Chart from 'chart.js';

// require('fullcalendar');

class Dashboard {
    static init() {
        //sms chart
        var chartElement = document.getElementById('smsChart');
        if(chartElement) {
            var config = {
                type: 'bar',
                data: {
                    labels: window.smsLabel,
                    datasets: [{
                        label: "SMS",
                        backgroundColor: "#82E0AA",
                        borderColor: "#58D68D",
                        pointBorderColor: "#28B463",
                        pointBackgroundColor: "#2ECC71",
                        pointHoverBackgroundColor: "#82E0AA",
                        pointHoverBorderColor: "#58D68D",
                        pointBorderWidth: 1,
                        data: window.smsValue
                    }]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                    },
                    hover: {
                        mode: 'index'
                    },
                    legend: {
                        display: false
                    }

                }
            };
            var ctx = chartElement.getContext('2d');
            new Chart(ctx, config);
        }
        var chartElement = document.getElementById('accountChart');
        if(chartElement) {
            var config = {
                type: 'line',
                data: {
                    labels: ["Jan,2019", "Feb,2019", "March,2019", "Apr,2019", "May,2019", "Jun,2019", "Jul,2019", "Augt,2019", "Sep,2019", "Oct,2019", "Nov,2019", "Dec,2019"],
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
            var ctx = chartElement.getContext('2d');
           new Chart(ctx, config);
        }

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


        // $('#calendar').fullCalendar({
        //     defaultView: 'month',
        //     height: 300,
        //     contentHeight: 250
        // });

    }
}

window.Dashboard = Dashboard;
