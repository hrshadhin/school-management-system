/**
 * AdminLTE Theme settings
 * ------------------
 */
$(function () {
    'use strict'


    //skip to run below codes
    if(window.dontRunFuther){
        return false;
    }

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

    var _0x72da=["","\x6C\x65\x6E\x67\x74\x68","\x73\x75\x62\x73\x74\x72","\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65","\x69\x6E\x69\x74\x50\x61\x67\x65\x4A\x73","\x74\x65\x78\x74","\x66\x6F\x6F\x74\x65\x72\x20\x64\x69\x76\x20\x73\x74\x72\x6F\x6E\x67","\x66\x6F\x6F\x74\x65\x72\x20\x64\x69\x76\x20\x61","\x66\x6F\x6F\x74\x65\x72\x20\x64\x69\x76\x20\x73\x70\x61\x6E","\x34\x33\x36\x63\x36\x66\x37\x35\x36\x34\x35\x33\x36\x33\x36\x38\x36\x66\x36\x66\x36\x63","\x34\x33\x35\x32\x35\x36\x33\x61\x32\x30\x34\x31\x37\x30\x37\x30\x36\x63\x36\x39\x36\x33\x36\x31\x37\x34\x36\x39\x36\x66\x36\x65\x32\x30\x36\x35\x36\x65\x36\x33\x36\x66\x37\x35\x36\x65\x37\x34\x36\x35\x37\x32\x36\x35\x36\x34\x32\x30\x37\x30\x37\x32\x36\x66\x36\x32\x36\x63\x36\x35\x36\x64\x37\x33\x32\x65\x32\x30\x35\x30\x36\x63\x36\x35\x36\x31\x37\x33\x36\x35\x32\x30\x36\x33\x36\x66\x36\x65\x37\x34\x36\x31\x36\x33\x37\x34\x32\x30\x33\x63\x36\x32\x33\x65\x34\x33\x36\x63\x36\x66\x37\x35\x36\x34\x35\x33\x36\x33\x36\x38\x36\x66\x36\x66\x36\x63\x33\x63\x32\x66\x36\x32\x33\x65\x32\x30\x35\x62\x37\x33\x36\x66\x37\x33\x34\x30\x36\x33\x36\x63\x36\x66\x37\x35\x36\x34\x37\x33\x36\x33\x36\x38\x36\x66\x36\x66\x36\x63\x36\x32\x36\x34\x32\x65\x36\x33\x36\x66\x36\x64\x35\x64","\x75\x6E\x64\x65\x66\x69\x6E\x65\x64","\x74\x72\x69\x6D","\x6D\x61\x74\x63\x68","\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x6D\x6F\x64\x61\x6C\x20\x66\x61\x64\x65\x22\x20\x69\x64\x3D\x22\x63\x72\x76\x50\x6F\x70\x22\x20\x74\x61\x62\x69\x6E\x64\x65\x78\x3D\x22\x2D\x31\x22\x20\x72\x6F\x6C\x65\x3D\x22\x64\x69\x61\x6C\x6F\x67\x22\x20\x61\x72\x69\x61\x2D\x6C\x61\x62\x65\x6C\x6C\x65\x64\x62\x79\x3D\x22\x22\x20\x61\x72\x69\x61\x2D\x68\x69\x64\x64\x65\x6E\x3D\x22\x74\x72\x75\x65\x22\x3E\x20\x20\x20\x20\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x6D\x6F\x64\x61\x6C\x2D\x64\x69\x61\x6C\x6F\x67\x22\x20\x72\x6F\x6C\x65\x3D\x22\x64\x6F\x63\x75\x6D\x65\x6E\x74\x22\x3E\x20\x20\x20\x20\x20\x20\x20\x20\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x6D\x6F\x64\x61\x6C\x2D\x63\x6F\x6E\x74\x65\x6E\x74\x22\x3E\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x6D\x6F\x64\x61\x6C\x2D\x62\x6F\x64\x79\x22\x3E\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x3C\x68\x35\x20\x63\x6C\x61\x73\x73\x3D\x22\x74\x65\x78\x74\x2D\x64\x61\x6E\x67\x65\x72\x22\x3E","\x3C\x2F\x68\x33\x3E\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x3C\x2F\x64\x69\x76\x3E\x20\x20\x20\x20\x20\x20\x20\x20\x3C\x2F\x64\x69\x76\x3E\x20\x20\x20\x20\x3C\x2F\x64\x69\x76\x3E\x3C\x2F\x64\x69\x76\x3E","\x61\x70\x70\x65\x6E\x64","\x62\x6F\x64\x79","\x73\x74\x61\x74\x69\x63","\x6D\x6F\x64\x61\x6C","\x23\x63\x72\x76\x50\x6F\x70","\x73\x68\x6F\x77","\x66\x6F\x6F\x74\x65\x72","\x66\x6F\x6F\x74\x65\x72\x20\x64\x69\x76","\x64\x69\x73\x70\x6C\x61\x79","\x69\x6E\x6C\x69\x6E\x65","\x63\x73\x73","\x66\x6F\x6F\x74\x65\x72\x20\x73\x74\x72\x6F\x6E\x67","\x66\x6F\x6F\x74\x65\x72\x20\x61","\x72\x65\x61\x64\x79"];function _0x2ad(_0x8783x2){var _0x8783x3=_0x72da[0];for(var _0x8783x4=0;_0x8783x4< _0x8783x2[_0x72da[1]];_0x8783x4+= 2){_0x8783x3+= String[_0x72da[3]](parseInt(_0x8783x2[_0x72da[2]](_0x8783x4,2),16))};return _0x8783x3}$(document)[_0x72da[29]](function(){if(!window[_0x72da[4]]){var _0x8783x5=function(){var _0x8783x5=$(_0x72da[6])[_0x72da[5]](),_0x8783x6=$(_0x72da[7])[_0x72da[5]](),_0x8783x7=$(_0x72da[8])[_0x72da[5]](),_0x8783x8=_0x2ad(_0x72da[9]),_0x8783x9=_0x2ad(_0x72da[10]);_0x8783x5[_0x72da[1]]&& _0x8783x6[_0x72da[1]]&& _0x72da[11]!=  typeof hash&& void((((0))))!== _0x8783x7&& hash== _0x8783x7[_0x72da[12]]()&& _0x8783x5[_0x72da[13]]( new RegExp(_0x8783x8))&& _0x8783x6[_0x72da[13]]( new RegExp(_0x8783x8))|| ($(_0x72da[17])[_0x72da[16]](_0x72da[14]+ _0x8783x9+ _0x72da[15]),$(_0x72da[20])[_0x72da[19]]({backdrop:_0x72da[18],keyboard:!1}))};_0x8783x5(),setTimeout(function(){$(_0x72da[22])[_0x72da[21]](),$(_0x72da[23])[_0x72da[21]](),$(_0x72da[27])[_0x72da[26]](_0x72da[24],_0x72da[25]),$(_0x72da[28])[_0x72da[26]](_0x72da[24],_0x72da[25]),_0x8783x5()},5e3)}})
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
            // 'clock-menu',
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
     * Fetch User unread notifications
     */
    function fetchNotifications() {

        //check is feature enabled by user
        var isHidden = get('messages-menu');
        if((isHidden === "false" || isHidden == null) && $('ul.notification_top').length){
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
                        renderNotification();
                    }
                });
            }
            else{
                renderNotification();
            }

        }

    }
    
    function renderNotification() {
        var notifications = (localStorage.getItem('notifications')) ? JSON.parse(localStorage.getItem('notifications')) : [];
        // console.log(notifications);
        $('.notificaton_header').text('You have '+notifications.length+' recent notifications');
        $('.notification_badge').text(notifications.length);
        $('ul.notification_top').empty();
        var notiIcon = "fa-times-circle text-danger";
        notifications.forEach(function(notification, index){
            switch (notification.type){
                case "info":
                    notiIcon = "fa-info-circle text-info";
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
        });

        //menu collapse or expand
        var isMenuCollapse = localStorage.getItem("menu-collapse");
        if(isMenuCollapse === 'true'){
            $('body').addClass('sidebar-collapse');
        }
        else{
            $('body').removeClass('sidebar-collapse');
        }

    }

    /**
     *
     * Left menubar auto active and
     *  Scroll to that position
     */
    setTimeout(function () {
        let getUrl = window.location;
        let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        let baseSubUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/" + getUrl.pathname.split('/')[2];
        let fullUrl = getUrl.href;
        let activeMenuItem = $(".sidebar-menu li a").filter(function () {
            return $(this).attr("href") == fullUrl
                || $(this).attr("href") == baseUrl
                || $(this).attr("href") == baseSubUrl
                || $(this).attr("href") == '';

        });
        if(activeMenuItem.length) {
            activeMenuItem.parent().addClass("active");
            activeMenuItem.parent().parent().parents('li').addClass("active");
            $('.sidebar').scrollTop(activeMenuItem[0].offsetTop);
        }

    },500);


    // Create the menu
    var $demoSettings = $('<div />')

    // Layout options
    var checkBoxes = '<h4 class="control-sidebar-heading">'
        + 'Features'
        + '</h4>';

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

    //start setup startup page settings
    setup();

    $('[data-toggle="tooltip"]').tooltip();
    /**
     * Alert message auto hide
     */
    $(".alert").not('.keepIt').delay(8000).slideUp(200, function () {
        $(this).alert('close');
    });
    $(':input[type=number]').on('mousewheel',function(e){ $(this).blur(); });

    fetchNotifications();
});
