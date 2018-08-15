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
            minView:'month',
            maxView:'decade',
            autoclose: true,
            todayBtn: true
        });
        $('#listTable').DataTable({
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
        });

        let stopchange = false;
        $('.statusChange').change(function(e) {
            let that = $(this);
            if(stopchange === false) {
                let isActive = $(this).prop('checked') ? 1 : 0;
                let pk = $(this).attr('data-pk');
                let newpostUrl = postUrl.replace(/\.?0+$/, pk);
                axios.post(newpostUrl, {'status': isActive})
                    .then((response) => {
                        if (response.data.success) {
                            toastr.success(response.data.message);
                        }
                        else {
                            let status = response.data.message;
                            if(stopchange === false){
                                stopchange = true;
                                that.bootstrapToggle('toggle');
                                stopchange = false;
                            }
                            toastr.error(status);
                        }
                    }).catch((error) => {
                    let status = error.statusText;
                    if(stopchange === false){
                        stopchange = true;
                        that.bootstrapToggle('toggle');
                        stopchange = false;
                    }
                    toastr.error(status);

                });
            }
        })


    }

}