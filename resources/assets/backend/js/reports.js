export default class Reports {
    /**
     * Report related codes
     */
    static studentIdcardPrint() {
        Generic.initCommonPageJS();

        $('select[name="class_id"]').on('change', function () {
            let class_id = $(this).val();
            Academic.getSection(class_id);
        });
    }

    static commonJs() {
        $("#reportForm, .reportForm").validate({
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
        $(".year_picker").datetimepicker({
            format: "YYYY",
            viewMode: 'years',
            ignoreReadonly: true
        });

        $(".month_picker").datetimepicker({
            format: "MM/YYYY",
            viewMode: 'months',
            ignoreReadonly: true
        });

        $('input').not('.dont-style').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
        $('.select2').select2();


        $('select[name="class_id"]').on('change', function () {
            let class_id = $(this).val();
            Academic.getSection(class_id);
        });
    }

}