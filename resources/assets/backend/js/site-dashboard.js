import Chart from 'chart.js';

class GoogleAnaylytics {
    static init() {
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };
        // == NOTE ==
        // This code uses ES6 promises. If you want to use this code in a browser
        // that doesn't supporting promises natively, you'll have to include a polyfill.
        gapi.analytics.ready(function() {
            var data = {ids: window.gid};
            var access_token = window.gtok;

            /**
             * Authorize the user immediately if the user has already granted access.
             * If no access has been created, render an authorize button inside the
             * element with the ID "embed-api-auth-container".
             */
            gapi.analytics.auth.authorize({
                'serverAuth': {
                    'access_token': access_token
                }
            });

            gapi.analytics.createComponent('ActiveUsers', {

                initialize: function initialize() {
                    this.activeUsers = 0;
                    gapi.analytics.auth.once('signOut', this.handleSignOut_.bind(this));
                },

                execute: function execute() {
                    // Stop any polling currently going on.
                    if (this.polling_) {
                        this.stop();
                    }

                    this.render_();

                    // Wait until the user is authorized.
                    if (gapi.analytics.auth.isAuthorized()) {
                        this.pollActiveUsers_();
                    } else {
                        gapi.analytics.auth.once('signIn', this.pollActiveUsers_.bind(this));
                    }
                },

                stop: function stop() {
                    clearTimeout(this.timeout_);
                    this.polling_ = false;
                    this.emit('stop', { activeUsers: this.activeUsers });
                },

                render_: function render_() {
                    var opts = this.get();

                    // Render the component inside the container.
                    this.container = typeof opts.container == 'string' ? document.getElementById(opts.container) : opts.container;

                    this.container.innerHTML = opts.template || this.template;
                    this.container.querySelector('b').innerHTML = this.activeUsers;
                },

                pollActiveUsers_: function pollActiveUsers_() {
                    var options = this.get();
                    var pollingInterval = (options.pollingInterval || 5) * 1000;

                    if (isNaN(pollingInterval) || pollingInterval < 5000) {
                        throw new Error('Frequency must be 5 seconds or more.');
                    }

                    this.polling_ = true;
                    gapi.client.analytics.data.realtime.get({ ids: options.ids, metrics: 'rt:activeUsers' }).then(function (response) {
                        var result = response.result;
                        var newValue = result.totalResults ? +result.rows[0][0] : 0;
                        var oldValue = this.activeUsers;

                        this.emit('success', { activeUsers: this.activeUsers });

                        if (newValue != oldValue) {
                            this.activeUsers = newValue;
                            this.onChange_(newValue - oldValue);
                        }

                        if (this.polling_ == true) {
                            this.timeout_ = setTimeout(this.pollActiveUsers_.bind(this), pollingInterval);
                        }
                    }.bind(this));
                },

                onChange_: function onChange_(delta) {
                    var valueContainer = this.container.querySelector('b');
                    if (valueContainer) valueContainer.innerHTML = this.activeUsers;

                    this.emit('change', { activeUsers: this.activeUsers, delta: delta });
                    if (delta > 0) {
                        this.emit('increase', { activeUsers: this.activeUsers, delta: delta });
                    } else {
                        this.emit('decrease', { activeUsers: this.activeUsers, delta: delta });
                    }
                },

                handleSignOut_: function handleSignOut_() {
                    this.stop();
                    gapi.analytics.auth.once('signIn', this.handleSignIn_.bind(this));
                },

                handleSignIn_: function handleSignIn_() {
                    this.pollActiveUsers_();
                    gapi.analytics.auth.once('signOut', this.handleSignOut_.bind(this));
                },

                template: '<div class="ActiveUsers is-increasing">' + 'Active Users: <b class="ActiveUsers-value"></b>' + '</div>'

            });


            /**
             * Create a new ActiveUsers instance to be rendered inside of an
             * element with the id "active-users-container" and poll for changes every
             * five seconds.
             */
            var activeUsers = new gapi.analytics.ext.ActiveUsers({
                container: 'active-users-container',
                pollingInterval: 5
            });


            /**
             * Add CSS animation to visually show the when users come and go.
             */
            activeUsers.once('success', function() {
                var element = this.container.firstChild;
                var timeout;

                this.on('change', function(data) {
                    var element = this.container.firstChild;
                    var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
                    element.className += (' ' + animationClass);

                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        element.className =
                            element.className.replace(/ is-(increasing|decreasing)/g, '');
                    }, 3000);
                });
            });
            activeUsers.set(data).execute();

            renderWeekOverWeekChart(data.ids);
            renderYearOverYearChart(data.ids);
            renderTopBrowsersChart(data.ids);
            renderTopCountriesChart(data.ids);

            /**
             * Draw the a chart.js line chart with data from the specified view that
             * overlays session data for the current week over session data for the
             * previous week.
             */
            function renderWeekOverWeekChart(ids) {

                // Adjust `now` to experiment with different days, for testing only...
                var now = window.moment(); // .subtract(3, 'day');

                var thisWeek = query({
                    'ids': ids,
                    'dimensions': 'ga:date,ga:nthDay',
                    'metrics': 'ga:sessions',
                    'start-date': window.moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
                    'end-date': window.moment(now).format('YYYY-MM-DD')
                });

                var lastWeek = query({
                    'ids': ids,
                    'dimensions': 'ga:date,ga:nthDay',
                    'metrics': 'ga:sessions',
                    'start-date': window.moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
                        .format('YYYY-MM-DD'),
                    'end-date': window.moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
                        .format('YYYY-MM-DD')
                });

                Promise.all([thisWeek, lastWeek]).then(function(results) {

                    var data1 = results[0].rows.map(function(row) { return +row[2]; });
                    var data2 = results[1].rows.map(function(row) { return +row[2]; });
                    var labels = results[1].rows.map(function(row) { return +row[0]; });

                    labels = labels.map(function(label) {
                        return window.moment(label, 'YYYYMMDD').format('ddd');
                    });

                    var data = {
                        labels : labels,
                        datasets : [
                            {
                                label: 'Last Week',
                                fillColor : 'rgba(220,220,220,0.5)',
                                strokeColor : 'rgba(220,220,220,1)',
                                pointColor : 'rgba(220,220,220,1)',
                                pointStrokeColor : '#fff',
                                backgroundColor: window.chartColors.blue,
                                borderColor: window.chartColors.blue,
                                borderWidth: 1,
                                data : data2
                            },
                            {
                                label: 'This Week',
                                fillColor : 'rgba(151,187,205,0.5)',
                                strokeColor : 'rgba(151,187,205,1)',
                                pointColor : 'rgba(151,187,205,1)',
                                pointStrokeColor : '#fff',
                                backgroundColor: window.chartColors.green,
                                borderColor: window.chartColors.green,
                                borderWidth: 1,
                                data : data1
                            }
                        ]
                    };

                    Chart.Line(makeCanvas('chart-1-container'), {
                        data: data
                    });
                });
            }


            /**
             * Draw the a chart.js bar chart with data from the specified view that
             * overlays session data for the current year over session data for the
             * previous year, grouped by month.
             */
            function renderYearOverYearChart(ids) {

                // Adjust `now` to experiment with different days, for testing only...
                var now = window.moment(); // .subtract(3, 'day');

                var thisYear = query({
                    'ids': ids,
                    'dimensions': 'ga:month,ga:nthMonth',
                    'metrics': 'ga:users',
                    'start-date': window.moment(now).date(1).month(0).format('YYYY-MM-DD'),
                    'end-date': window.moment(now).format('YYYY-MM-DD')
                });

                var lastYear = query({
                    'ids': ids,
                    'dimensions': 'ga:month,ga:nthMonth',
                    'metrics': 'ga:users',
                    'start-date': window.moment(now).subtract(1, 'year').date(1).month(0)
                        .format('YYYY-MM-DD'),
                    'end-date': window.moment(now).date(1).month(0).subtract(1, 'day')
                        .format('YYYY-MM-DD')
                });

                Promise.all([thisYear, lastYear]).then(function(results) {
                    var data1 = results[0].rows.map(function(row) { return +row[2]; });
                    var data2 = results[1].rows.map(function(row) { return +row[2]; });
                    var labels = ['Jan','Feb','Mar','Apr','May','Jun',
                        'Jul','Aug','Sep','Oct','Nov','Dec'];

                    // Ensure the data arrays are at least as long as the labels array.
                    // Chart.js bar charts don't (yet) accept sparse datasets.
                    for (var i = 0, len = labels.length; i < len; i++) {
                        if (data1[i] === undefined) data1[i] = null;
                        if (data2[i] === undefined) data2[i] = null;
                    }

                    var data = {
                        labels : labels,
                        datasets : [
                            {
                                label: 'Last Year',
                                fillColor : 'rgba(220,220,220,0.5)',
                                strokeColor : 'rgba(220,220,220,1)',
                                backgroundColor: window.chartColors.orange,
                                borderColor: 'rgba(255, 159, 64, 1)',
                                data : data2
                            },
                            {
                                label: 'This Year',
                                fillColor : 'rgba(151,187,205,0.5)',
                                strokeColor : 'rgba(151,187,205,1)',
                                backgroundColor: window.chartColors.purple,
                                borderColor:'rgba(153, 102, 255, 1)',
                                data : data1
                            }
                        ]
                    };

                    Chart.Bar(makeCanvas('chart-2-container'),{
                        data: data
                    });
                })
                    .catch(function(err) {
                        console.error(err.stack);
                    });
            }


            /**
             * Draw the a chart.js doughnut chart with data from the specified view that
             * show the top 5 browsers over the past seven days.
             */
            function renderTopBrowsersChart(ids) {
                var now = window.moment();
                query({
                    'ids': ids,
                    'dimensions': 'ga:browser',
                    'metrics': 'ga:pageviews',
                    'sort': '-ga:pageviews',
                    // 'max-results': 5,
                    'start-date': window.moment(now).date(1).month(0).format('YYYY-MM-DD'),
                    'end-date': window.moment(now).format('YYYY-MM-DD')
                })
                    .then(function(response) {

                        let chartData = [];
                        let labels = [];
                        response.rows.forEach(function(row, i) {
                            chartData.push(row[1]);
                            labels.push(row[0]);
                        });
                        data = {
                            datasets: [{
                                data: chartData,
                                backgroundColor: [
                                    window.chartColors.red,
                                    window.chartColors.orange,
                                    window.chartColors.yellow,
                                    window.chartColors.green,
                                    window.chartColors.blue,
                                    window.chartColors.purple,
                                    window.chartColors.grey
                                ]
                            }],
                            labels: labels,

                        };
                        Chart.Doughnut(makeCanvas('chart-3-container'),{
                            data:data
                        });
                    });
            }


            /**
             * Draw the a chart.js doughnut chart with data from the specified view that
             * compares sessions from mobile, desktop, and tablet over the past seven
             * days.
             */
            function renderTopCountriesChart(ids) {
                var now = window.moment();
                query({
                    'ids': ids,
                    'dimensions': 'ga:country',
                    'metrics': 'ga:users',
                    'sort': '-ga:users',
                    // 'max-results': 5,
                    'start-date': window.moment(now).date(1).month(0).format('YYYY-MM-DD'),
                    'end-date': window.moment(now).format('YYYY-MM-DD')
                })
                    .then(function(response) {
                        var totalUsers = response.totalsForAllResults['ga:users'];
                        $('.totalVisitors').text(totalUsers);
                        let chartData = [];
                        let labels = [];
                        let colors = [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(231,233,237)'
                        ];
                        let bgColors = [];
                        let colorCounter = 0;
                        
                        response.rows.forEach(function(row, i) {
                            // var percentage = parseFloat((row[1]/parseInt(totalUsers)*100).toFixed(1));
                            chartData.push(row[1]);
                            labels.push(row[0]);
                            //
                            bgColors.push(colors[colorCounter]);
                            colorCounter++;
                            if(colorCounter>=colors.length){
                                colorCounter =0;
                            }

                        });

                        data = {
                            datasets: [{
                                data: chartData,
                                backgroundColor: bgColors
                            }],
                            labels: labels,

                        };
                        Chart.Doughnut(makeCanvas('chart-4-container'),{
                            data:data,
                            // options: {
                            //     tooltips: {
                            //         callbacks: {
                            //             label: function (tooltipItem, data) {
                            //                 var dataset = data.datasets[tooltipItem.datasetIndex];
                            //                 var currentValue = dataset.data[tooltipItem.index];
                            //                 var tooltipLabel = data.labels[tooltipItem.index];
                            //                 return tooltipLabel + ': '+ currentValue + "%";
                            //             }
                            //         }
                            //     }
                            // }
                        });

                    });
            }


            /**
             * Extend the Embed APIs `gapi.analytics.report.Data` component to
             * return a promise the is fulfilled with the value returned by the API.
             * @param {Object} params The request parameters.
             * @return {Promise} A promise.
             */
            function query(params) {
                return new Promise(function(resolve, reject) {
                    var data = new gapi.analytics.report.Data({query: params});
                    data.once('success', function(response) { resolve(response); })
                        .once('error', function(response) { reject(response); })
                        .execute();
                });
            }


            /**
             * Create a new canvas inside the specified element. Set it to be the width
             * and height of its container.
             * @param {string} id The id attribute of the element to host the canvas.
             * @return {RenderingContext} The 2D canvas context.
             */
            function makeCanvas(id) {
                var container = document.getElementById(id);
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                container.innerHTML = '';
                canvas.width = container.offsetWidth;
                canvas.height = container.offsetHeight;
                container.appendChild(canvas);

                return ctx;
            }



            // Set some global Chart.js defaults.
            Chart.defaults.global.animationSteps = 60;
            Chart.defaults.global.animationEasing = 'easeInOutQuart';
            Chart.defaults.global.responsive = true;
            Chart.defaults.global.maintainAspectRatio = false;


        });
    }
}
window.GoogleAnaylytics = GoogleAnaylytics;