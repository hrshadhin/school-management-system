import Academic from "./Academic";

export default class Administrator {
    /**
     * administrator related codes
     */
    static academicYearInit() {
        $("#entryForm").validate({
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                error.insertAfter(element);

            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            }
        });

        $(".date_picker").datetimepicker({
            format: "DD/MM/YYYY",
            viewMode: 'days',
            ignoreReadonly: true
        });

        var table = $('#listTable').DataTable({
            pageLength: 25,
            lengthChange: false,
            responsive: true,
        });

        // table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));

        let stopchange = false;
        $('.statusChange').change(function (e) {
            let that = $(this);
            if (stopchange === false) {
                let isActive = $(this).prop('checked') ? 1 : 0;
                let pk = $(this).attr('data-pk');
                let newpostUrl = postUrl.replace(/\.?0+$/, pk);
                axios.post(newpostUrl, { 'status': isActive })
                    .then((response) => {
                        if (response.data.success) {
                            toastr.success(response.data.message);
                        }
                        else {
                            let status = response.data.message;
                            if (stopchange === false) {
                                stopchange = true;
                                that.bootstrapToggle('toggle');
                                stopchange = false;
                            }
                            toastr.error(status);
                        }
                    }).catch((error) => {
                        let status = error.statusText;
                        if (stopchange === false) {
                            stopchange = true;
                            that.bootstrapToggle('toggle');
                            stopchange = false;
                        }
                        toastr.error(status);

                    });
            }
        })


    }

    /**
     *  Mail and sms template
     */

    static templateMailSMSInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
        $("#templateForm").validate({
            ignore: ":hidden:not(textarea)",
            rules: {},
            messages: {},
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                error.insertAfter(element);

            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            }
        });
        $('select[name="role_id"]').on('change', function () {
           let value = $(this).val();
           $('.emailtagdiv').css('display','none');
           if(value){
               $('#email_'+value).css('display', 'block');

           }
            $('.wysihtml5-sandbox').contents().find('body').html('');
            $('#smsContentArea').val('');
        });

        $('input.keyword_tag').click(function () {
            let formType = $('input[name="type"]:checked').val();
            if(formType == "2") {
                var contents = $('.wysihtml5-sandbox').contents().find('body').html();
                contents += $(this).val();
                $('.wysihtml5-sandbox').contents().find('body').html(contents);
            }
            else{
                var contents = $('#smsContentArea').val();
                contents += $(this).val();
                $('#smsContentArea').val(contents);
            }
        });

        $('input[name="type"]').on('ifClicked', function(event) {
            let value = $(this).val();
            if(value == "2"){
                $('#emailContent').show();
                $('#smsContent').hide();
                $('#smsContentArea').removeAttr('required');
                $('#textareaEditor').attr("required", true);
            }
            else{
                $('#textareaEditor').removeAttr('required');
                $('#smsContentArea').attr("required", true);
                $('#emailContent').hide();
                $('#smsContent').show();
            }
        });

    }

    /**
     *  Id card tempalte
     */

    static templateIdcardInit() {
        var templateMainUrl = window.templateUrl;
        var logoDataImage = window.logoString || "";
        var signatureDataImage = window.signatureString || "";
        var titleBgDataImage = window.titleBgString || "";

        $('.select2').select2();

        $('select[name="format_id"]').on('change', function () {
            var format = $(this).val();
            if(format) {
                var fullTemplateUrl = templateMainUrl + format + ".html";
                $('#idFrame').attr('src', fullTemplateUrl);
            }
            else{
                $('#idFrame').attr('src', '');
            }

            if(format == 3){
                $('.onlyFormat3').show();
            }
            else{
                $('.onlyFormat3').hide();
            }

        });


        $('iframe').on('load', function() {
            //now fill colors
            $('input[name="bg_color"]').trigger('change');
            $('input[name="border_color"]').trigger('change');
            $('input[name="body_text_color"]').trigger('change');
            $('input[name="fs_title_color"]').trigger('change');
            $('input[name="picture_border_color"]').trigger('change');
            $('input[name="bs_title_color"]').trigger('change');
            $('input[name="website_link_color"]').trigger('change');

            if($('select[name="format_id"]').val() == 3) {
                $('input[name="fs_title_bg_color"]').trigger('change');
                $('input[name="id_title_color"]').trigger('change');
            }

            if($('#logoUp').val() || !window.liveChange) {
                $('#logoUp').trigger('change');
            }
            if($('#signatureUp').val() || !window.liveChange) {
                $('#signatureUp').trigger('change');
            }
            if($('#titleBgUp').val() && $('select[name="format_id"]').val() == 3) {
                $('#titleBgUp').trigger('change');
                $('input[name="fs_title_bg_color"]').trigger('change');
                $('input[name="id_title_color"]').trigger('change');
            }

            //if not edit form
            if(window.liveChange) {
                logoDataImage = $('#idFrame').contents().find('body div.logo img').attr('src');
                signatureDataImage = $('#idFrame').contents().find('body div.signature img').attr('src');
                titleBgDataImage = $('#idFrame').contents().find('body img.id_bg').attr('src');
            }
        });

        $('input[name="bg_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body div.card').css('background-color', color);
            }
        });
        $('input[name="border_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body div.card').css('border-color', color);
            }
        });
        $('input[name="body_text_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body').css('color', color);
            }
        });

        $('input[name="fs_title_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body div.header div.title').css('color', color);
            }
        });

        $('input[name="picture_border_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body span.student_pic>img').css('border-color', color);
            }
        });

        $('input[name="bs_title_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body .back h2').css('color', color);
            }
        });

        $('input[name="website_link_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body .back a').css('color', color);
            }
        });
        $('input[name="fs_title_bg_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body div.header div.title').css('background-color', color);
            }
        });
        $('input[name="id_title_color"]').on('change keyup paste', function () {
            var color = $(this).val();
            if(color) {
                $('#idFrame').contents().find('body span.id_title').css('color', color);
            }
        });

        $('.my-colorpicker').colorpicker();

        $('#logoUp').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#idFrame').contents().find('body div.logo img').attr('src', e.target.result);
                    $('#idFrame').contents().find('body img.back-logo').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                if(logoDataImage) {
                    $('#idFrame').contents().find('body div.logo img').attr('src', logoDataImage);
                    $('#idFrame').contents().find('body img.back-logo').attr('src', logoDataImage);
                }
            }
        });
        $('#signatureUp').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#idFrame').contents().find('body div.signature img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                if(signatureDataImage) {
                    $('#idFrame').contents().find('body div.signature img').attr('src', signatureDataImage);
                }
            }
        });
        $('#titleBgUp').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#idFrame').contents().find('body img.id_bg').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                if(titleBgDataImage) {
                    $('#idFrame').contents().find('body img.id_bg').attr('src', titleBgDataImage);
                }
            }
        });

        $('.btnReset').click(function () {
            $('input[name="bg_color"]').val('');
            $('input[name="border_color"]').val('');
            $('input[name="body_text_color"]').val('');
            $('input[name="fs_title_color"]').val('');
            $('input[name="picture_border_color"]').val('');
            $('input[name="bs_title_color"]').val('');
            $('input[name="website_link_color"]').val('');
            $('input[name="fs_title_bg_color"]').val('');

            $('#logoUp').val('');
            $('#signatureUp').val('');
            $('#titleBgUp').val('');
            $('input[name="fs_title_bg_color"]').val('');
            $('input[name="id_title_color"]').val('');

            logoDataImage = "";
            signatureDataImage = "";
            titleBgDataImage = "";

            var format = $('select[name="format_id"]').val();
            if(format) {
                var fullTemplateUrl = templateMainUrl + format + ".html";
                $('#idFrame').attr('src', fullTemplateUrl);
            }

        });

        $("#templateForm").validate({
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                error.insertAfter(element);

            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            }
        });

    }

    static templateIdcardPreview() {
        $('.btnIdcardPreview').click(function () {
            //clear preview content
            $('.modal-body').empty();
            $('.modal-body').append(' <iframe id="idFrame" style="margin-left:22px;width: 100%; height: 350px;" src="" frameborder="0">\n' +
                '                    </iframe>');

            let pk = $(this).attr('data-id');
            Generic.loaderStart();
            Administrator.getTemplateIdcardData(pk)
                .then((response) => {
                    let template = response.data;
                    // console.log(template);
                    if (Object.keys(template).length) {
                        let templateSample = window.templateUrl + template.format_id + ".html";
                        //now feed data to iframe
                        $('#idFrame').attr('src', templateSample);
                        $('iframe').on('load', function() {
                            // console.log('iframe load');
                            //now fill colors
                            Administrator.setidcardTemplateData(template);
                        });

                        //now show the modal
                        Generic.loaderStop();
                        $('#modalIdcardPreview').modal('show');
                    }
                    else {
                        toastr.warning("Template content not found!");
                    }
                }).catch((error) => {
                    Generic.loaderStop();

             });

        });
    }

    static getTemplateIdcardData(pk) {
        //get template data
        let getUrl = window.templateGetURL + "?pk=" + pk;
        return axios.get(getUrl)
            .then((response) => {
               return response;
            });
    }

    static setidcardTemplateData  (data) {
            // console.log(data);
            if(data.bg_color) {
                $('#idFrame').contents().find('body div.card').css('background-color', data.bg_color);
            }


            if(data.body_text_color) {
                $('#idFrame').contents().find('body').css('color', data.body_text_color);
            }

            if(data.border_color) {
                $('#idFrame').contents().find('body div.card').css('border-color', data.border_color);
            }


            if(data.fs_title_color) {
                $('#idFrame').contents().find('body div.header div.title').css('color', data.fs_title_color);
            }

            if(data.bs_title_color) {
                $('#idFrame').contents().find('body .back h2').css('color', data.bs_title_color);
            }


            if(data.picture_border_color) {
                $('#idFrame').contents().find('body span.student_pic>img').css('border-color', data.picture_border_color);
            }

             if(data.website_link_color) {
                 $('#idFrame').contents().find('body .back a').css('color', data.website_link_color);
            }

            if(data.logo) {
                let logoDataImage = "data:image/png;base64,"+data.logo;
                $('#idFrame').contents().find('body div.logo img').attr('src', logoDataImage);
                $('#idFrame').contents().find('body img.back-logo').attr('src', logoDataImage);
            }
            if(data.signature) {
                let signatureDataImage = "data:image/png;base64,"+data.signature;
                $('#idFrame').contents().find('body div.signature img').attr('src', signatureDataImage);
            }




            if(data.format_id == 3){
                if(data.fs_title_bg_color) {
                    $('#idFrame').contents().find('body div.header div.title').css('background-color', data.fs_title_bg_color);
                }

                if(data.id_title_color) {
                    $('#idFrame').contents().find('body span.id_title').css('color', data.id_title_color);
                }
                if(data.title_bg_image) {
                    let titleBgDataImage = "data:image/png;base64,"+data.title_bg_image;
                    $('#idFrame').contents().find('body img.id_bg').attr('src', titleBgDataImage);
                }
            }

        }
}