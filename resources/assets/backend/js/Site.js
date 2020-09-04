export default class Site {
    /**
     * Sliders related codes
     */
    static sliderInit() {
        $('#sliders').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': false
        });

        $("#sliderAddForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 5,
                    maxlength: 255,
                },
                subtitle: {
                    required: true,
                    minlength: 5,
                    maxlength: 255,
                },
                image: {
                    required: true,
                },
                order: {
                    required: true,
                    min: 0,
                    number: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Your title must consist of at least 5 characters",
                    maxlength: "Your title must be less or equal to 255 characters"
                },
                subtitle: {
                    required: "Please enter a subtitle",
                    minlength: "Your subtitle must consist of at least 5 characters",
                    maxlength: "Your subtitle must be less or equal to 255 characters"
                }

            },
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
        $("#sliderEditForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 5,
                    maxlength: 255,
                },
                subtitle: {
                    required: true,
                    minlength: 5,
                    maxlength: 255,
                },
                order: {
                    required: true,
                    min: 0,
                    number: true
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Your title must consist of at least 5 characters",
                    maxlength: "Your title must be less or equal to 255 characters"
                },
                subtitle: {
                    required: "Please enter a subtitle",
                    minlength: "Your subtitle must consist of at least 5 characters",
                    maxlength: "Your subtitle must be less or equal to 255 characters"
                }

            },
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
    static testimonialInit() {
        $('#testimonials').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': false
        });
        $("#testimonialAddForm").validate({
            rules: {
                writer: {
                    required: true,
                    minlength: 5,
                    maxlength: 255,
                },
                comments: {
                    required: true
                },
                order: {
                    required: true,
                    min: 0,
                    number: true
                }
            },
            messages: {


            },
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

    static aboutInit() {
        // bootstrap WYSIHTML5 - text editor
        $('.textarea').each(function (index, elem) {
            $(elem).wysihtml5();
        });
        $("#AboutContentForm").validate({
            ignore: ":hidden:not(textarea)",
            rules: {
                why_content: {
                    required: true,
                    minlength: 5,
                    maxlength: 500
                },
                key_point_1_title: {
                    required: true,
                    minlength: 5,
                    maxlength: 100
                },
                key_point_1_content: {
                    required: true,
                    minlength: 5
                },
                key_point_2_title: {
                    minlength: 5,
                    maxlength: 100
                },
                key_point_2_content: {
                    minlength: 5
                },
                key_point_3_title: {
                    minlength: 5,
                    maxlength: 100
                },
                key_point_3_content: {
                    minlength: 5
                },
                key_point_4_title: {
                    minlength: 5,
                    maxlength: 100
                },
                key_point_4_content: {
                    minlength: 5
                },
                key_point_5_title: {
                    minlength: 5,
                    maxlength: 100
                },
                key_point_5_content: {
                    minlength: 5
                },
                about_us: {
                    required: true,
                    maxlength: 500,
                    minlength: 50
                },
                who_we_are: {
                    required: true,
                    maxlength: 1000,
                    minlength: 100
                },
                intro_video_embed_code: {
                    required: true
                },
                video_site_link: {
                    maxlength: 500,
                }
            },
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

        $('.thumbnail .remove-image').on('click', function () {
            var that = this;
            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if(result.value) {
                    Site.deleteThumnailImage(that);

                }
            });

        });

    }
    static classProfileInit() {
        $('#profiles').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });
        // bootstrap WYSIHTML5 - text editor
        $('.textarea').each(function (index, elem) {
            $(elem).wysihtml5();
        });
        $("#classProfileAddForm").validate({
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

    }
    static EventInit() {
        $('#eventList').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });
        // bootstrap WYSIHTML5 - text editor
        $('.textarea').each(function (index, elem) {
            $(elem).wysihtml5();
        });
        $("#EventForm").validate({
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

        $(".event_time").datetimepicker({
            format: "DD/MM/YYYY LT",
            viewMode: 'days',
            ignoreReadonly: true
        });

    }
    static teacherProfileInit() {
        $('#profiles').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': false
        });

        $("#teacherProfileForm").validate({
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

    }
    static deleteThumnailImage(that) {
        let id = $(that).attr('data-id');
        let newpostUrl = postUrl.replace(/\.?0+$/,id);
        axios.post(newpostUrl,{})
            .then((response)=>{
                if(response.data.success){
                    $(that).parents('div.thumbnail').remove();
                    toastr.success(response.data.message);
                }
                else{
                    let status = response.data.message;
                    toastr.error(status);
                }
            }).catch((error)=>{
            let status = error.statusText;
            toastr.error(status);
        });

    }
    static galleryInit() {
        $('.thumbnail .remove-image').on('click', function () {
            let that = this;
            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if(result.value) {
                    Site.deleteThumnailImage(that);

                }
            });

        });

    }
    static contactUs() {
        $("#contactUsForm").validate({
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

    }
    static settingsInit() {
        $("#settingsForm").validate({
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

    }
    static AnalyticsInit() {
        $("#analyTicsSettingForm").validate({
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

    }
    static faqInit() {

        // bootstrap WYSIHTML5 - text editor
        $('.textarea').each(function (index, elem) {
            $(elem).wysihtml5();
        });
        $('#faqList').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': false
        });

        $("#faqForm").validate({
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

    }
    static timeLineInit() {

        $('#timeLineList').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': false,
            'autoWidth': false
        });

        $("#timelineForm").validate({
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

    }
}