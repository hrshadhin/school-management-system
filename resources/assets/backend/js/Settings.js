export default class Settings {
    /**
     * app settings related codes
     */
    static instituteInit() {
        Generic.initCommonPageJS();
        $('select[name="attendance_notification"]').on('change', function () {
            let value = $(this).val();
            console.log(value);

            if(value==0){
                $('#divSmsGateWayList').addClass('hide');
                $('#divTemplateList').addClass('hide');
                $('#divTemplateList').empty();
                $('#divSmsGateWayList').empty();
            }
            if(value==1){
                Settings.setSmsGateWay();
                Settings.setTemplate();
            }

            if(value==2){
                Settings.setTemplate();
                $('#divSmsGateWayList').addClass('hide');
                $('#divSmsGateWayList').empty();
            }

            //fixed dom issue
            $('.select2-container').css('width','100%');
        });

    }
    static setSmsGateWay() {
        let gatewayhtml = '<div class="form-group has-feedback">\n' +
            '<label for="sms_gateway">SMS Gateway\n' +
            '<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="SMS Gateway to send sms"></i>\n' +
            '<span class="text-danger">*</span>\n' +
            '</label>\n' +
            '<select name="sms_gateway" placeholder ="Pick a sms gateway..." class="form-control" required>\n' +
            '</select>\n' +
            '<span class="form-control-feedback"></span>\n' +
            '</div>';
        $('#divSmsGateWayList').empty();
        $('#divSmsGateWayList').append(gatewayhtml);

        //now call api and get data

        $('select[name="sms_gateway"]').select2();
        $('#divSmsGateWayList').removeClass('hide');
    }
    static setTemplate() {
        let templateHtml = '<div class="form-group has-feedback">\n' +
            '<label for="notification_template">Notification template\n' +
            '<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Which template use in notification"></i>\n' +
            ' <span class="text-danger">*</span>\n' +
            ' </label>\n' +
            ' <select name="notification_template" placeholder ="Pick a template..." class="form-control" required></select>\n' +
            ' <span class="form-control-feedback"></span>\n' +
            ' </div>';
        $('#divTemplateList').empty();
        $('#divTemplateList').append(templateHtml);

       //now call api and get data

        $('select[name="notification_template"]').select2();
        $('#divTemplateList').removeClass('hide');
    }

}