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
            format: "dd/mm/yyyy",
            startView: 'decade',
            minView: 'month',
            maxView: 'decade',
            autoclose: true,
            todayBtn: true
        });
        var buttonCommon = {
            exportOptions: {
                columns: ':not(.notexport)',
                format: {
                    body: function (data, row, column, node) {
                        if (column === 4) {
                            data = /checked/.test(data) ? 'Active' : 'Deactive';
                        }
                        return data;
                    }
                }
            }
        };
        var table = $('#listTable').DataTable({
            pageLength: 25,
            lengthChange: false,
            responsive: true,
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copy',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'copy',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'csv',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'pdf',
                    customize: function (doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content[1].alignment = "center";
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'print',
                })
            ]
        });

        table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));

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

}