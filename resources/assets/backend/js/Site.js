export default class Site {
    /**
     * Sliders related codes
     */
    static sliderInit() {
        $('#sliders').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false
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


}