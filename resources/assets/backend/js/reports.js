import Academic from "./Academic";
import Generic from "./Generic";

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

        $(".month_picker_with_clear").datetimepicker({
            format: "MM/YYYY",
            viewMode: 'months',
            ignoreReadonly: true,
            showClear: true,
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

        $('input').not('.dont-style').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
        $('.select2').select2({ allowClear: true, placeholder: 'Pick a option...'});


        $('select[name="class_id"]:not(.notFireAjax)').on('change', function () {
            let class_id = $(this).val();
            Academic.getSection(class_id);
        });

        $('#hostel_id_filter').on('change', function () {
            let hostelId = $(this).val();
            if(!hostelId) {
                $('select[name="hostel_member_id"]').empty().select2({ placeholder: 'Pick a member...' });
                return false;
            }
            let getUrl = window.getHostelMemberAjaxUrl + "?hostel_id=" + hostelId;
            Generic.loaderStart();
            axios.get(getUrl)
                .then((response) => {
                    // console.log(response);
                    if (Object.keys(response.data).length) {
                        $('select[name="hostel_member_id"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a member...', data: response.data });
                    }
                    else {
                        $('select[name="hostel_member_id"]').empty().select2({ placeholder: 'Pick a member...' });
                        toastr.warning('This hostel have no member!');
                    }
                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();
            });
        });

    }

    static marksheet() {
        Reports.commonJs();
        $('#class_change').on('change', function () {
            let class_id = $(this).val();
            if(class_id) {
                //get exams
                Academic.getExam(class_id);
                Academic.getSection(class_id);
            }
            else{
                $('select[name="exam_id"]').empty().select2({placeholder: 'Pick a exam...'});
            }
        });
    }

    static loadExamAjax() {
        $('#class_change').on('change', function () {
            let class_id = $(this).val();
            if(class_id) {
                //get exams
                Academic.getExam(class_id);
            }
            else{
                $('select[name="exam_id"]').empty().select2({placeholder: 'Pick a exam...'});
            }
        });
    }

    static loadSubjectExamAjax() {
        $('#class_change').on('change', function () {
            let class_id = $(this).val();
            if(class_id) {
                //get subject of requested class
                Generic.loaderStart();
                Academic.getSubject(class_id, 0, function (res = {}) {
                    // console.log(res);
                    if (Object.keys(res).length) {
                        $('select[name="subject_id"]').empty().prepend('<option selected=""></option>').select2({
                            allowClear: true,
                            placeholder: 'Pick a subject...',
                            data: res
                        });
                    }
                    else {
                        // clear subject list dropdown
                        $('select[name="subject_id"]').empty().select2({ placeholder: 'Pick a subject...' });
                        toastr.warning('This class have no subject!');
                    }
                    Generic.loaderStop();
                });
                //get exams
                Academic.getExam(class_id);
            }
            else{
                $('select[name="exam_id"]').empty().select2({placeholder: 'Pick a exam...'});
            }
        });
    }



    static individualInit() {
        Reports.commonJs();
        $('#section_id_filter').on('change', function () {
            //hide button
            $('button[type="submit"]').hide();
            let sectionId = $(this).val();
            let classId = $('select[name="class_id"]').val();
            let acYearId = $('select[name="academic_year"]').val();
            //validate input
            if (!classId || !sectionId || !acYearId) {
                return false;
            }

            Generic.loaderStart();
            Academic.getStudentByAcYearAndClassAndSection(acYearId, classId, sectionId, function (data) {
                let students = data;
                if (students.length) {
                    let studentOptions = [];
                    students.forEach(function (item) {
                        studentOptions.push({
                            id: item.id,
                            text: item.student.name + '[' + item.roll_no + ']'
                        });
                    });
                    $('select[name="student_id"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a student...', data: studentOptions });
                    //now show the submit button
                    $('button[type="submit"]').show();
                }
                else {
                    $('select[name="student_id"]').empty().select2({ placeholder: 'Pick a student...' });
                    toastr.error('This section have no student!');
                }
                Generic.loaderStop();
            });

        });
    }

}