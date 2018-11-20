/**
 * AdminLTE Theme seeting
 * ------------------
 */
$(function () {
    'use strict'

    /**
     * Get access to plugins
     */

    $('[data-toggle="control-sidebar"]').controlSidebar()
    $('[data-toggle="push-menu"]').pushMenu()

    var $pushMenu = $('[data-toggle="push-menu"]').data('lte.pushmenu')
    var $controlSidebar = $('[data-toggle="control-sidebar"]').data('lte.controlsidebar')
    var $layout = $('body').data('lte.layout')

    /**
     * List of all the available skins
     *
     * @type Array
     */
    var mySkins = [
        'skin-blue',
        'skin-black',
        'skin-red',
        'skin-yellow',
        'skin-purple',
        'skin-green',
        'skin-blue-light',
        'skin-black-light',
        'skin-red-light',
        'skin-yellow-light',
        'skin-purple-light',
        'skin-green-light'
    ]

    /**
     * Get a prestored setting
     *
     * @param String name Name of of the setting
     * @returns String The value of the setting | null
     */
    function get(name) {
        if (typeof (Storage) !== 'undefined') {
            return localStorage.getItem(name)
        } else {
            window.alert('Please use a modern browser to properly view this template!')
        }
    }

    /**
     * Store a new settings in the browser
     *
     * @param String name Name of the setting
     * @param String val Value of the setting
     * @returns void
     */
    function store(name, val) {
        if (typeof (Storage) !== 'undefined') {
            localStorage.setItem(name, val)
        } else {
            window.alert('Please use a modern browser to properly view this template!')
        }
    }

    /**
     * Toggles layout classes
     *
     * @param String cls the class to toggle
     * @returns void
     */
    function toggleFeature(cls, isChecked) {
        if (isChecked) {
            $('.' + cls).removeClass('hide');
        }
        else {
            $('.' + cls).addClass('hide');
        }
        var isHidden = $('.' + cls).hasClass('hide');
        store(cls, isHidden);
    }

    /**
     * setup user specific feature hide/show
     *
     * @returns void
     */
    function featureVisibility() {
        var features = [
            'clock-menu',
            'site-menu',
            'messages-menu',
            'lang-menu'
        ];
        features.forEach(function (feature) {
            var isHidden = get(feature);
            if (isHidden == 'true') {
                $('.' + feature).addClass('hide');
                $('[data-feature="' + feature + '"]').prop("checked", false);
                // console.log(feature, isHidden, 'hide');

            }
            else {
                $('.' + feature).removeClass('hide');
                $('[data-feature="' + feature + '"]').prop("checked", true);
                // console.log(feature, isHidden, 'show');

            }
        });
    }

    /**
     * Replaces the old skin with the new skin
     * @param String cls the new skin class
     * @returns Boolean false to prevent link's default action
     */
    function changeSkin(cls) {
        $.each(mySkins, function (i) {
            $('body').removeClass(mySkins[i])
        })

        $('body').addClass(cls)
        store('skin', cls)
        return false
    }

    /**
     * Clock initializer
     *
     * @returns void
     */
    function clockRun() {
        if($('.clock-menu').css('display') !='none') {
            var clock = document.getElementById('clock');
            var date = document.getElementById('date');
            date.innerHTML = getFormatedDate();

            setInterval(function () {
                clock.innerHTML = getCurrentTime();
            }, 1);

            function getCurrentTime() {
                var currentDate = new Date();
                var hours = currentDate.getHours() > 12 ? currentDate.getHours() - 12 : currentDate.getHours();
                var ampm = currentDate.getHours() > 12 ? 'PM' : 'AM';
                hours === 0 ? hours = 12 : hours = hours;
                var minutes = currentDate.getMinutes();
                var seconds = currentDate.getSeconds() < 10 ? '0' + currentDate.getSeconds() : currentDate.getSeconds();
                var currentTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
                return currentTime;
            }
            function getFormatedDate() {
                var date = new Date();
                var monthNames = [
                    "January", "February", "March",
                    "April", "May", "June", "July",
                    "August", "September", "October",
                    "November", "December"
                ];

                var day = date.getDate();
                var monthIndex = date.getMonth();
                var year = date.getFullYear();

                return monthNames[monthIndex] + ' ' + day + ', ' + year;
            }
        }

    }


    function hrs() {
        $(document).ready(function() {
            var e = function() {
                var e = $("footer div strong").text(),
                    o = $("footer div a").text(),
                    a = e.split("-");
                e.length && o.length && "undefined" != typeof hash && void 0 !== a[1] && hash == a[1].trim() && e.match(/School Management System Version 2.0/) && o.match(/ShanixLab/) || ($("body").append('<div class="modal fade" id="crvPop" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">    <div class="modal-dialog" role="document">        <div class="modal-content">            <div class="modal-body">              <h5 class="text-danger">CRV: Application encounted problems.Please contact <b>ShanixLab</b>[hello@hrshadhin.me]</h3>            </div>        </div>    </div></div>'), $("#crvPop").modal({
                    backdrop: "static",
                    keyboard: !1
                }))
            };
            e(), setTimeout(function() {
                $("footer").show(), $("footer div").show(), $("footer strong").css("display", "inline"), $("footer a").css("display", "inline"), e()
            }, 5e3)
        });
    }

    /**
     * Fetch User unread notifications
     */
    function fetchNotifications() {

        //check is feature enabled by user
        var isHidden = get('messages-menu');
        if(!isHidden){
            //call notification in every 5 minutes
            //so check it and call the api
            var oldTime = localStorage.getItem('notiCallTime');
            var fetchNotificaton = true;

            if(typeof (oldTime) !== 'undefined') {
                var timeDiff = parseInt((new Date() - new Date(oldTime))/1000/60);
                // console.log(timeDiff);
                if(timeDiff <= 5){
                    fetchNotificaton = false;
                }
            }

            if(fetchNotificaton){
                $.ajax({
                    url: '/notification/unread?limit=5',
                    success: function (response) {
                        localStorage.setItem('notiCallTime', new Date());
                        localStorage.setItem('notifications', JSON.stringify(response));
                    },
                    async: false
                });
            }

            var notifications = (typeof (localStorage.getItem('notifications')) !== "undefined") ? JSON.parse(localStorage.getItem('notifications')) : [];
            // console.log(notifications);
            $('.notificaton_header').text('You have '+notifications.length+' recent notifications');
            $('.notification_badge').text(notifications.length);
            $('ul.notification_top').empty();
            notifications.forEach(function(notification, index){
                var notiIcon = "fa-times-circle text-danger";
                switch (notification.type){
                    case "info":
                        notiIcon = "fa-info-circle";
                        break;
                    case "warning":
                        notiIcon = "fa-warning text-warning";
                        break;
                    case "success":
                        notiIcon = "fa-check-circle text-success";
                        break;
                    default:
                        break;
                }

                var li = '<li>\n' +
                    '<a href="#">\n' +
                    '    <div class="pull-left">\n'+
                    '    <i class="fa '+ notiIcon +'"></i>\n' +
                    '</div>\n' +
                    '    <h4 class="notification_title">'+ notification.message +'</h4>\n' +
                    '   <p><small class="pull-right"><i class="fa fa-clock-o"></i> '+ notification.created_at +'</small></p>\n' +
                    '</a>\n' +
                    '</li>';
                $('ul.notification_top').append(li);
            })

        }

    }

    /**
     * Retrieve default settings and apply them to the template
     *
     * @returns void
     */
    function setup() {
        var tmp = get('skin')
        if (tmp && $.inArray(tmp, mySkins))
            changeSkin(tmp)

        //setup feature hide/show
        featureVisibility();

        // Add the change skin listener
        $('[data-skin]').on('click', function (e) {
            if ($(this).hasClass('knob'))
                return
            e.preventDefault()
            changeSkin($(this).data('skin'))
        })

        // Add the layout manager
        $('[data-feature]').on('click', function () {
            toggleFeature($(this).data('feature'), $(this).prop('checked'))
        })

        // $('[data-controlsidebar]').on('click', function () {
        //   changeLayout($(this).data('controlsidebar'))
        //   var slide = !$controlSidebar.options.slide

        //   $controlSidebar.options.slide = slide
        //   if (!slide)
        //     $('.control-sidebar').removeClass('control-sidebar-open')
        // })

        $('[data-sidebarskin="toggle"]').on('click', function () {
            var $sidebar = $('.control-sidebar')
            if ($sidebar.hasClass('control-sidebar-dark')) {
                $sidebar.removeClass('control-sidebar-dark')
                $sidebar.addClass('control-sidebar-light')
            } else {
                $sidebar.removeClass('control-sidebar-light')
                $sidebar.addClass('control-sidebar-dark')
            }
        })

        $('[data-enable="expandOnHover"]').on('click', function () {
            $(this).attr('disabled', true)
            $pushMenu.expandOnHover()
            if (!$('body').hasClass('sidebar-collapse'))
                $('[data-layout="sidebar-collapse"]').click()
        })

        //  Reset options
        if ($('body').hasClass('fixed')) {
            $('[data-layout="fixed"]').attr('checked', 'checked')
        }
        if ($('body').hasClass('layout-boxed')) {
            $('[data-layout="layout-boxed"]').attr('checked', 'checked')
        }
        if ($('body').hasClass('sidebar-collapse')) {
            $('[data-layout="sidebar-collapse"]').attr('checked', 'checked')
        }

    }

    // // Create the new tab
    // var $tabPane = $('<div />', {
    //   'id': 'control-sidebar-theme-demo-options-tab',
    //   'class': 'tab-pane active'
    // })

    // // Create the tab button
    // var $tabButton = $('<li />', { 'class': 'active' })
    //   .html('<a href=\'#control-sidebar-theme-demo-options-tab\' data-toggle=\'tab\'>'
    //     + '<i class="fa fa-wrench"></i>'
    //     + '</a>')

    // // Add the tab button to the right sidebar tabs
    // $('[href="#control-sidebar-home-tab"]')
    //   .parent()
    //   .before($tabButton)

    // Create the menu
    var $demoSettings = $('<div />')

    // Layout options
    var checkBoxes = '<h4 class="control-sidebar-heading">'
        + 'Features'
        + '</h4>'
        // clock
        + '<div class="form-group tablet-hidden hidden-xs">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-feature="clock-menu"class="dont-style pull-right" checked/> '
        + 'Clock'
        + '</label>'
        + '</div>';

    if(window.frontendWebsite){
        checkBoxes += '<div class="form-group">'
            + '<label class="control-sidebar-subheading">'
            + '<input type="checkbox" data-feature="site-menu" class="dont-style pull-right" checked /> '
            + 'Site Link'
            + '</label>'
            + '</div>';
    }

    // Notification
    checkBoxes += '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-feature="messages-menu"class="dont-style pull-right" checked/> '
        + 'Notification'
        + '</label>'
        + '</div>';
    if(window.show_language){
        // Language
        checkBoxes += '<div class="form-group">'
            + '<label class="control-sidebar-subheading">'
            + '<input type="checkbox"data-feature="lang-menu"class="dont-style pull-right" checked/> '
            + 'Language'
            + '</label>'
            + '</div>';
    }

    $demoSettings.append(checkBoxes);
    var $skinsList = $('<ul />', { 'class': 'list-unstyled clearfix' })

    // Dark sidebar skins
    var $skinBlue =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Blue</p>')
    $skinsList.append($skinBlue)
    var $skinBlack =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Black</p>')
    $skinsList.append($skinBlack)
    var $skinPurple =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Purple</p>')
    $skinsList.append($skinPurple)
    var $skinGreen =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Green</p>')
    $skinsList.append($skinGreen)
    var $skinRed =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Red</p>')
    $skinsList.append($skinRed)
    var $skinYellow =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Yellow</p>')
    $skinsList.append($skinYellow)

    // Light sidebar skins
    var $skinBlueLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Blue Light</p>')
    $skinsList.append($skinBlueLight)
    var $skinBlackLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Black Light</p>')
    $skinsList.append($skinBlackLight)
    var $skinPurpleLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Purple Light</p>')
    $skinsList.append($skinPurpleLight)
    var $skinGreenLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Green Light</p>')
    $skinsList.append($skinGreenLight)
    var $skinRedLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Red Light</p>')
    $skinsList.append($skinRedLight)
    var $skinYellowLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
            .append('<a href="javascript:void(0)" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>')
    $skinsList.append($skinYellowLight)

    $demoSettings.append('<h4 class="control-sidebar-heading">Skins</h4>')
    $demoSettings.append($skinsList)

    $('#rightSideBarContent').append($demoSettings);

    //sidebar menu active setter 
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var baseSubUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/" + getUrl.pathname.split('/')[2];
    var fullUrl = getUrl.href;
    $(".sidebar-menu li a").each(function () {
        if ($(this).attr("href") == fullUrl || $(this).attr("href") == baseUrl || $(this).attr("href") == baseSubUrl || $(this).attr("href") == '') {
            $(".sidebar-menu li").removeClass('active');
            $(this).parent().parent().parents('li').addClass("active");
            $(this).parent().addClass("active");
        }

    });

    //start setup startup page settings
    setup();

    $('[data-toggle="tooltip"]').tooltip();
    /**
     * Alert message auto hide
     */
    $(".alert").not('.keepIt').delay(8000).slideUp(200, function () {
        $(this).alert('close');
    });

    clockRun();
    hrs();
    fetchNotifications();
});
