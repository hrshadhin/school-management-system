import Academic from "./Academic";

export default class Generic {
    /**
     * academic related codes
     */
    static initCommonPageJS() {
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
            ignoreReadonly: true,
        });
        $(".date_picker_with_clear").datetimepicker({
            format: "DD/MM/YYYY",
            viewMode: 'days',
            showClear: true,
            ignoreReadonly: true
        });


        $(".date_picker2").datetimepicker({
            format: "DD/MM/YYYY",
            viewMode: 'years',
            ignoreReadonly: true
        });
        $(".date_picker_month_year").datetimepicker({
            format: "MM-YYYY",
            viewMode: 'months',
            ignoreReadonly: true,
            useCurrent: false
        });

        $(".time_picker").datetimepicker({
            format: 'LT',
            showClear: true,
            ignoreReadonly: true
        });

        $(".date_time_picker").datetimepicker({
            format: "DD/MM/YYYY LT",
            viewMode: 'days',
            ignoreReadonly: true
        });

        $('.date_picker_with_disable_days').datetimepicker({
            format: "DD/MM/YYYY",
            viewMode: 'days',
            ignoreReadonly: true,
            daysOfWeekDisabled: window.disableWeekDays,
            useCurrent: false
        });

        $('.only_year_picker').datetimepicker({
            format: "YYYY",
            viewMode: 'years',
            ignoreReadonly: true,
            useCurrent: false
        });

        //table with out search
        var table = $('#listDataTable').DataTable({
            pageLength: 25,
            lengthChange: false,
            responsive: true
        });

        //table custom
        var table33 = $('#listDataTableOnlyPrint').DataTable({
            lengthChange: false,
            responsive: true,
            paging: false,
            filter: false
        });

        var table2 = $('#listDataTableWithSearch').DataTable({
            pageLength: 25,
            lengthChange: false,
            orderCellsTop: true,
            responsive: true
        });

        var table3 = $('#listDataTableWithSearchNoPaginate').DataTable({
            paging:false,
            lengthChange: false,
            orderCellsTop: true,
            responsive: true,
            info: false
        });

        $('#listDataTableOnlyFilter').DataTable({
            lengthChange: false,
            responsive: true,
            paging: false,
            filter: true,
            info: false,
            order: []
        });

        let stopchange = false;
        $('html #listDataTableWithSearch, html #listDataTable, html #listDataTableWithSearchNoPaginate, html #listDataTableOnlyFilter')
        .on('change', 'input.statusChange', function (e) {
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
                        // console.log(error.response);
                        let status = error.response.statusText;
                        if (stopchange === false) {
                            stopchange = true;
                            that.bootstrapToggle('toggle');
                            stopchange = false;
                        }
                        toastr.error(status);

                    });
            }
        });

        $(".year_picker").datetimepicker({
            format: "YYYY",
            viewMode: 'years',
            ignoreReadonly: true
        });

        $('input').not('.dont-style').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
        $('.select2').select2();
        // $('.select2-allow-clear').select2({allowClear:true});


    }

    static initDeleteDialog() {
        $('html #listDataTableWithSearch, html #listDataTable, html #listDataTableWithSearchNoPaginate, html #listDataTableOnlyPrint, html #listDataTableOnlyFilter')
        .on('submit', 'form.myAction', function (e) {
            e.preventDefault();
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
                if (result.value) {
                    that.submit();
                }
            });
        });
    }

    static initMarksheetPublic() {
        Generic.initCommonPageJS();
        // $('#class_change').val('').trigger('change');
        $('#class_change').on('change', function () {
            let class_id = $(this).val();
            if(class_id) {
                //get sections
                Academic.getExam(class_id);
            }
            else{
                $('select[name="exam_id"]').empty().select2({placeholder: 'Pick a exam...'});
            }

        });
    }
    static loaderStart(){
        // console.log('loader started...');
        $('.ajax-loader').css('display','block');
    } 
    static loaderStop(){
        // console.log('loader stoped...');
        $('.ajax-loader').css('display','none');
    }

    static onlineRegistrationInit() {
        Generic.initCommonPageJS();
        $('.btnReset').click(function () {

        });
        var _URL = window.URL || window.webkitURL;
        $('select[name="nationality"]').on('change', function () {
            // console.log('fire me');
            var value = $(this).val();
            if(value == 'Other'){
                $('input[name="nationality_other"]').prop('readonly', false);
            }
            else{
                $('input[name="nationality_other"]').val('');
                $('input[name="nationality_other"]').prop('readonly', true);
            }
        });
        $('#photoUp').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                //validate size
                var sizeImg =input.files[0].size/1024;
                if (sizeImg>200) {
                    $('#photoPreview').attr('src', 'https://via.placeholder.com/150');
                    toastr.error("File is too big!");
                    $('#photoUp').val('');
                    return false
                }
                //validate dimention
                var img = new Image();
                var minwidth = 150;
                var minheight = 150;
                img.src = _URL.createObjectURL(input.files[0]);
                img.onload = function() {
                    if(this.width < minwidth || this.height < minheight){
                        toastr.error("Image dimensions min 150x150 px");
                        $('#photoUp').val('');
                        $('#photoPreview').attr('src', 'https://via.placeholder.com/150');
                        return false
                    }
                };


                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#photoPreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

            }
            else{
                $('#photoPreview').attr('src', 'https://via.placeholder.com/150');
            }
        });
        $('#signatureUp').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                //validate size
                var sizeImg =input.files[0].size/1024;
                if (sizeImg>200) {
                    $('#singnaturePreview').attr('src', 'https://via.placeholder.com/100x50');
                    toastr.error("File is too big!");
                    $('#signatureUp').val('');
                    return false
                }
                //validate dimention
                var img = new Image();
                var minwidth = 100;
                var minheight = 50;
                img.src = _URL.createObjectURL(input.files[0]);
                img.onload = function() {
                    if(this.width < minwidth || this.height < minheight){
                        toastr.error("Image dimensions min 100x50 px");
                        $('#signatureUp').val('');
                        $('#singnaturePreview').attr('src', 'https://via.placeholder.com/100x50');
                        return false
                    }
                };


                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#singnaturePreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

            }
            else{
                $('#singnaturePreview').attr('src', 'https://via.placeholder.com/100x50');
            }
        });

        $('.class_change').on('change', function () {
            //get subject of requested class
            let class_id = $(this).val();
            if(!class_id) {
                $('select[name="core_subjects[]"]').empty().select2();
                $('select[name="selective_subjects[]"]').empty().select2();
                $('select[name="fourth_subject"]').empty().select2({placeholder: 'select a subject'});
                $('#divSelective').show();
                $('#divElective').show();
                return false;
            }
            let getUrl = window.get_class_subject_settings.replace(':class_id', class_id);
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        if(response.data.have_selective_subject){
                            $('#divSelective').show();
                            $('select[name="selective_subjects[]"]').attr('data-max', response.data.max_selective_subject);
                            loadSelective(class_id);
                        }
                        else{
                            $('#divSelective').hide();
                            $('select[name="selective_subjects[]"]').removeAttr('data-max');
                        }

                        if(response.data.have_elective_subject){
                            $('#divElective').show();
                            loadElective(class_id);

                        }
                        else{
                            $('#divElective').hide();

                        }
                    }

                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
            });
            loadCoreSubjects(class_id);
        });
        function loadCoreSubjects(class_id) {
            Generic.loaderStart();
            Academic.getSubject(class_id, 1, function (subjects = {}) {
                // console.log(res);
                if (Object.keys(subjects).length) {
                    let ids = subjects.map((subject) => subject.id);
                    $('select[name="core_subjects[]"]').empty().select2({
                        data: subjects
                    }).val(ids).trigger('change');

                } else {
                    // clear subject list dropdowns
                    $('select[name="core_subjects[]"]').empty().select2();
                    toastr.error('This class have no core subject!');
                }
                Generic.loaderStop();
            });
        }

        function loadSelective(class_id) {
            Generic.loaderStart();
            Academic.getSubject(class_id, 3, function (subjects = {}) {
                // console.log(res);
                if (Object.keys(subjects).length) {
                    $('select[name="selective_subjects[]"]').empty().select2({data: subjects});
                } else {
                    // clear subject list dropdowns
                    $('select[name="selective_subjects[]"]').empty().select2();
                    toastr.warning('This class have no selective subject!');
                }
                Generic.loaderStop();
            });
        }
        function loadElective(class_id) {
            Generic.loaderStart();
            Academic.getSubject(class_id, 2, function (subjects = {}) {
                // console.log(res);
                if (Object.keys(subjects).length) {
                    $('select[name="fourth_subject"]').empty().select2({
                        data: subjects,
                        placeholder: 'select a subject'
                    }).val('').trigger('change');

                } else {
                    $('select[name="fourth_subject"]').empty().select2({placeholder: 'select a subject'});
                    toastr.warning('This class have no 4th subject!');
                }
                Generic.loaderStop();
            });
        }
    }
}