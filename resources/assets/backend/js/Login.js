export default class Login {

    static init() {

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });


        $("#loginForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 5 characters"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
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

    static forgot() {
        $("#forgotForm").validate({
            rules: {
                email: {
                    required: true,
                    maxlength: 255,
                    email: true
                }

            },
            messages: {
                email: {
                    required: "Please enter your email address",
                    maxlength: "Your email must not greater than 255 characters"
                },

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
    static reset() {
        $("#resetForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 255
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    maxlength: 255,
                    equalTo: "#password"

                },

            },
            messages: {
                password: {
                    required: "Please enter your password",
                    maxlength: "Your password must not greater than 255 characters"
                },
                email: {
                    required: "Please enter your email",
                    maxlength: "Your password must not greater than 255 characters"
                },
                password_confirmation: {
                    required: "Please enter confirm password",
                    maxlength: "Your password must not greater than 255 characters",
                    equalTo: "Password didn't match!"
                },

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
    static changePassword() {
        $("#changePasswordForm").validate({
            rules: {
                old_password: {
                    required: true,
                    minlength: 6,
                    maxlength: 255
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 255
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    maxlength: 255,
                    equalTo: "#password"

                },

            },
            messages: {
                password: {
                    required: "Please enter your new password",
                    maxlength: "Your password must not greater than 255 characters"
                },
                old_password: {
                    required: "Please enter your old password",
                    maxlength: "Your password must not greater than 255 characters"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    maxlength: "Your password must not greater than 255 characters",
                    equalTo: "Password didn't match!"
                },

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
    static resetPassword() {
        $("#changePasswordForm").validate({
            rules: {
                user_id: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 255
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    maxlength: 255,
                    equalTo: "#password"

                },

            },
            messages: {
                password: {
                    required: "Please enter your new password",
                    maxlength: "Your password must not greater than 255 characters"
                },
                user_id: {
                    required: "Please select a user",
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    maxlength: "Your password must not greater than 255 characters",
                    equalTo: "Password didn't match!"
                },

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
    static profileUpdate() {

        $('.btnUpdate').click(function (e) {
            e.preventDefault();
            $('#profileUpdate').show();
        });
        $('.btnCancel').click(function (e) {
            e.preventDefault();
            $('#profileUpdate').hide();
        });
        $("#profileUpdateForm").validate({
            rules: {

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

}