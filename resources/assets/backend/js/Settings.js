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
                //it its update form then select item
                $('select[name="sms_gateway_Emp"]').val(window.gatewayEmp);
                $('select[name="notification_template_Emp"]').val(window.templateEmp);
            }

            if(value==2){
                Settings.setTemplate("_Emp");
                //it its update form then select item
                $('select[name="notification_template_Emp"]').val(window.templateEmp);
                $('#divSmsGateWayList_Emp').addClass('hide');
                $('#divSmsGateWayList_Emp').empty();
            }

            //fixed dom issue
            $('.select2-container').css('width','100%');
        });

        if($('select[name="student_attendance_notification"]').val()) {
            $('select[name="student_attendance_notification"]').trigger('change');

        }
        if($('select[name="employee_attendance_notification"]').val()) {
            $('select[name="employee_attendance_notification"]').trigger('change');

        }

    }
    static setSmsGateWay(which) {
        //add html dom
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
        Generic.loaderStart();
        axios.get(window.smsGatewayListURL)
            .then((response) => {
                if (Object.keys(response.data).length) {
                    $('select[name="sms_gateway'+which+'"]').empty().prepend('<option selected=""></option>').select2({allowClear: true,placeholder: 'Pick a gateway...', data: response.data});

                    //now if set selected value
                    if(which == "_St"){
                        $('select[name="sms_gateway_St"]').val(window.gatewaySt).trigger('change');
                    }
                    else{
                        $('select[name="sms_gateway_Emp"]').val(window.gatewayEmp).trigger('change');
                    }
                }
                else {
                    $('select[name="sms_gateway'+which+'"]').empty().select2({placeholder: 'Pick a gateway...'});
                    toastr.error('There are no gateway created!');
                }
                Generic.loaderStop();
            }).catch((error) => {
            let status = error.response.statusText;
            toastr.error(status);
            Generic.loaderStop();

        });

        //init select 2 and show the dom
        $('select[name="sms_gateway'+which+'"]').select2();
        $('#divSmsGateWayList'+which).removeClass('hide');
    }
    static setTemplate(which) {
        //add html dom
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
        Generic.loaderStart();
        let templateType = (which == "_St") ? $('select[name="student_attendance_notification"]').val() : $('select[name="employee_attendance_notification"]').val();
        let userType = (which == "_St") ? "student" : "employee";
        let getURL = window.templateListURL + "?type="+templateType+"&user="+userType;
        axios.get(getURL)
            .then((response) => {
                if (Object.keys(response.data).length) {
                    $('select[name="notification_template'+which+'"]').empty().prepend('<option selected=""></option>').select2({allowClear: true,placeholder: 'Pick a template...', data: response.data});
                    //now if set selected value
                    if(which == "_St"){
                        $('select[name="notification_template_St"]').val(window.templateSt).trigger('change');
                    }
                    else{
                        $('select[name="notification_template_Emp"]').val(window.templateEmp).trigger('change');
                    }
                }
                else {
                    $('select[name="notification_template'+which+'"]').empty().select2({placeholder: 'Pick a template...'});
                    toastr.error('There are no template created!');
                }
                Generic.loaderStop();
            }).catch((error) => {
            let status = error.response.statusText;
            toastr.error(status);
            Generic.loaderStop();

        });

        //init select 2 and show dom
        $('select[name="notification_template'+which+'"]').select2();
        $('#divTemplateList'+which).removeClass('hide');
    }


    static reportInit() {
        Generic.initCommonPageJS();
        $('.my-colorpicker').colorpicker();

        $('.documentUp').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                //validate size
                var sizeImg =input.files[0].size/1024;
                if (sizeImg>1024) {
                    toastr.error("File is too big!");
                    $(input).val('');
                    return false
                }
            }
            else{
                $(input).val('');
            }
        });
    }

}