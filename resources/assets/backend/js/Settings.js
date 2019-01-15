export default class Settings {
    /**
     * app settings related codes
     */
    static instituteInit() {
        Generic.initCommonPageJS();
        $('select[name="student_attendance_notification"]').on('change', function () {
            let value = $(this).val();
            // console.log(value);

            if(value==0){
                $('#divSmsGateWayList_St').addClass('hide');
                $('#divTemplateList_St').addClass('hide');
                $('#divTemplateList_St').empty();
                $('#divSmsGateWayList_St').empty();
            }
            if(value==1){
                Settings.setSmsGateWay("_St");
                Settings.setTemplate("_St");
            }

            if(value==2){
                Settings.setTemplate("_St");
                $('#divSmsGateWayList_St').addClass('hide');
                $('#divSmsGateWayList_St').empty();
            }

            //fixed dom issue
            $('.select2-container').css('width','100%');
        });

    $('select[name="employee_attendance_notification"]').on('change', function () {
            let value = $(this).val();
            // console.log(value);

            if(value==0){
                $('#divSmsGateWayList_Emp').addClass('hide');
                $('#divTemplateList_Emp').addClass('hide');
                $('#divTemplateList_Emp').empty();
                $('#divSmsGateWayList_Emp').empty();
            }
            if(value==1){
                Settings.setSmsGateWay("_Emp");
                Settings.setTemplate("_Emp");
            }

            if(value==2){
                Settings.setTemplate("_Emp");
                $('#divSmsGateWayList_Emp').addClass('hide');
                $('#divSmsGateWayList_Emp').empty();
            }

            //fixed dom issue
            $('.select2-container').css('width','100%');
        });

    }
    static setSmsGateWay(which) {
        let gatewayhtml = '<div class="form-group has-feedback">\n' +
            '<label for="sms_gateway">SMS Gateway\n' +
            '<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="SMS Gateway to send sms"></i>\n' +
            '<span class="text-danger">*</span>\n' +
            '</label>\n' +
            '<select name="sms_gateway'+which+'" placeholder ="Pick a sms gateway..." class="form-control" required>\n' +
            '</select>\n' +
            '<span class="form-control-feedback"></span>\n' +
            '</div>';
        $('#divSmsGateWayList'+which).empty();
        $('#divSmsGateWayList'+which).append(gatewayhtml);

        //now call api and get data

        $('select[name="sms_gateway'+which+'"]').select2();
        $('#divSmsGateWayList'+which).removeClass('hide');
    }
    static setTemplate(which) {
        let templateHtml = '<div class="form-group has-feedback">\n' +
            '<label for="notification_template">Notification template\n' +
            '<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Which template use in notification"></i>\n' +
            ' <span class="text-danger">*</span>\n' +
            ' </label>\n' +
            ' <select name="notification_template'+which+'" placeholder ="Pick a template..." class="form-control" required></select>\n' +
            ' <span class="form-control-feedback"></span>\n' +
            ' </div>';
        $('#divTemplateList'+which).empty();
        $('#divTemplateList'+which).append(templateHtml);

       //now call api and get data

        $('select[name="notification_template'+which+'"]').select2();
        $('#divTemplateList'+which).removeClass('hide');
    }

}