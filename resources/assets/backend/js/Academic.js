import Generic from "./Generic";

export default class Academic {
    /**
     * academic related codes
     */
    static iclassInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
    }
    static sectionInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
    }
    static subjectInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
        $('#class_id_filter').on('change', function () {
            let class_id = $(this).val();
            let getUrl = window.location.href.split('?')[0];
            if (class_id) {
                getUrl += "?class=" + class_id;

            }
            window.location = getUrl;

        });
    }
    static studentInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
        $('select[name="nationality"]').on('change', function () {
            // console.log('fire me');
            var value = $(this).val();
            if (value == 'Other') {
                $('input[name="nationality_other"]').prop('readonly', false);
            }
            else {
                $('input[name="nationality_other"]').val('');
                $('input[name="nationality_other"]').prop('readonly', true);
            }
        });

        $('select[name="class_id"]').on('change', function () {
            let class_id = $(this).val();
            Academic.getSection(class_id);

        });

        $('#student_add_edit_class_change').on('change', function () {
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
                        }
                        else{
                            $('#divSelective').hide();
                            $('select[name="selective_subjects[]"]').removeAttr('data-max');
                        }

                        if(response.data.have_elective_subject){
                            $('#divElective').show();
                        }
                        else{
                            $('#divElective').hide();
                        }
                    }

                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
            });
            loadSubjects(class_id);
        });

        $('#student_list_filter').on('change', function () {
            let class_id = $('select[name="class_id"]').val();
            let section_id = $(this).val();
            let status = $('select[name="status"]').val();
            let urlLastPart = '';
            if (institute_category == 'college') {
                let ac_year = $('select[name="academic_year"]').val();
                if (!ac_year) {
                    toastr.error('Select academic year!');
                    return false;
                }

                urlLastPart = "&academic_year=" + ac_year;
            }
            urlLastPart += "&status="+status;

            if (class_id && section_id) {
                let getUrl = window.location.href.split('?')[0] + "?class=" + class_id + "&section=" + section_id + urlLastPart;
                window.location = getUrl;

            }

        });
        $('select[name="academic_year"]').on('change', function () {
            $('#student_list_filter').trigger('change');
        });

        $('select[name="status"]').on('change', function () {
            $('#student_list_filter').trigger('change');
        });

        $('#checkStudentCapacity').on('change', function () {
            let section_id = $(this).val();
            let class_id = $('select[name="class_id"]').val() || $('input[name="class_id"]').val();
            if(section_id) {
                let urlLastPart = '';
                if (institute_category == 'college') {
                    let ac_year = $('select[name="academic_year"]').val();
                    if (!ac_year) {
                        toastr.error('Select academic year!');
                        return false;
                    }
                    urlLastPart = "&academic_year=" + ac_year;
                }
                let getUrl = window.section_capacity_check_url + "?class_id=" + class_id + "&section_id=" + section_id + urlLastPart;
                axios.get(getUrl)
                    .then((response) => {
                        if (!response.data.success) {
                            toastr.error(response.data.message);
                            if (response.data.clear) {
                                $('select[name="section_id"]').empty().select2({placeholder: 'Pick a section...'});
                            }
                        }
                        Generic.loaderStop();
                    }).catch((error) => {
                    let status = error.response.statusText;
                    toastr.error(status);
                    Generic.loaderStop();
                });
            }

        });

        function loadSubjects(class_id) {
            Generic.loaderStart();
            Academic.getSubject(class_id, 1, function (subjects = {}) {
                // console.log(res);
                if (Object.keys(subjects).length) {
                    let ids = subjects.map((subject) => subject.id);
                    $('select[name="core_subjects[]"]').empty().select2({
                        data: subjects
                    }).val(ids).trigger('change');

                }
                else {
                    // clear subject list dropdowns
                    $('select[name="core_subjects[]"]').empty().select2();
                    toastr.error('This class have no core subject!');
                }
                Generic.loaderStop();
            });

            if(institute_category == "college" ) {
                Generic.loaderStart();
                Academic.getSubjectMultipleType(class_id, [2,3], function (subjects = {}) {
                    // console.log(res);
                    if (Object.keys(subjects).length) {
                        $('select[name="selective_subjects[]"]').empty().select2({ data: subjects });
                        $('select[name="fourth_subject"]').empty().select2({
                            data: subjects,
                            placeholder: 'select a subject'
                        }).val('').trigger('change');
                    }
                    else {
                        // clear subject list dropdowns
                        $('select[name="selective_subjects[]"]').empty().select2();
                        toastr.warning('This class have no selective subject!');
                        $('select[name="fourth_subject"]').empty().select2({placeholder: 'select a subject'});
                        toastr.warning('This class have no 4th subject!');
                    }
                    Generic.loaderStop();
                });
            }
            else {
                Generic.loaderStart();
                Academic.getSubject(class_id, 3, function (subjects = {}) {
                    // console.log(res);
                    if (Object.keys(subjects).length) {
                        $('select[name="selective_subjects[]"]').empty().select2({ data: subjects });
                    }
                    else {
                        // clear subject list dropdowns
                        $('select[name="selective_subjects[]"]').empty().select2();
                        toastr.warning('This class have no selective subject!');
                    }
                    Generic.loaderStop();
                });

                Generic.loaderStart();
                Academic.getSubject(class_id, 2, function (subjects = {}) {
                    // console.log(res);
                    if (Object.keys(subjects).length) {
                        $('select[name="fourth_subject"]').empty().select2({
                            data: subjects,
                            placeholder: 'select a subject'
                        }).val('').trigger('change');

                    }
                    else {
                        $('select[name="fourth_subject"]').empty().select2({placeholder: 'select a subject'});
                        toastr.warning('This class have no 4th subject!');
                    }
                    Generic.loaderStop();
                });
            }

        }

        $('select[name="selective_subjects[]"]').change(function(){
            let selectiveSubjects = $(this).val();
            let fourthSubject = $('select[name="fourth_subject"]').val();
            let that = this;
            if(selectiveSubjects.includes(fourthSubject)){
                toastr.error('Selective and fourth subject can not be same!');
                selectiveSubjects.splice(selectiveSubjects.indexOf(fourthSubject), 1);
                $(that).val(selectiveSubjects).change();
                // console.log(selectiveSubjects, fourthSubject);

            }
            let max = $(that).attr('data-max');
            if(selectiveSubjects.length > max){
                toastr.error(`Maximum ${max} subjects allowed!`);
                selectiveSubjects.pop();
                $(that).val(selectiveSubjects).change();
            }
        });

        $('select[name="fourth_subject"]').change(function(){
            checkSubjectDuplicate();
        });

        function checkSubjectDuplicate() {
            let selectiveSubjects = $('select[name="selective_subjects[]"]').val();
            let fourthSubject = $('select[name="fourth_subject"]').val();
            if(selectiveSubjects.includes(fourthSubject)){
                toastr.error('Selective and fourth subject can not be same!');
                $('select[name="fourth_subject"]').val('').change();
            }
            // console.log(selectiveSubjects, fourthSubject);

        }
    }
    static getSection(class_id) {
        let getUrl = window.section_list_url + "?class=" + class_id;
        if (class_id) {
            Generic.loaderStart();
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        $('select[name="section_id"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a section...', data: response.data });
                    }
                    else {
                        $('select[name="section_id"]').empty().select2({ placeholder: 'Pick a section...' });
                        toastr.error('This class have no section!');
                    }
                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();

            });
        }
        else {
            // clear section list dropdown
            $('select[name="section_id"]').empty().select2({ placeholder: 'Pick a section...' });
        }
    }
    static getSubject(class_id, $type = 0, cb) {
        let getUrl = window.subject_list_url + "?class=" + class_id + "&type=" + $type;
        if (class_id) {
            axios.get(getUrl)
                .then((response) => {
                    cb(response.data);

                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                cb();

            });
        }
        else {
            cb();
        }
    }
    static getSubjectMultipleType(class_id, type = [0], cb) {
        var request = {
            params: { type: type, class: class_id }
        };
        if (class_id) {
            axios.get(window.subject_list_url, request)
                .then((response) => {
                    cb(response.data);

                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                cb();

            });
        }
        else {
            cb();
        }
    }
    static getStudentByAcYearAndClassAndSection(acYear = 0, classId, sectionId, cb = function () { }) {
        let getUrl = window.getStudentAjaxUrl + "?academic_year=" + acYear + "&class=" + classId + "&section=" + sectionId;
        axios.get(getUrl)
            .then((response) => {
                // console.log(response);
                cb(response.data);
            }).catch((error) => {
            let status = error.response.statusText;
            toastr.error(status);
            cb([]);
        });
    }

    /**
     * Student Attendance
     */
    static attendanceInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();

        $('select[name="class_id"]').on('change', function () {
            let class_id = $(this).val();
            Academic.getSection(class_id);
        });
        $('select[name="section_id"]').on('change', function () {
            $('#attendance_list_filter').trigger('dp.change');
        });
        $('#attendance_list_filter').on('dp.change', function (event) {
            let atDate = $(this).val();
            let classId = $('select[name="class_id"]').val();
            let sectionId = $('select[name="section_id"]').val();
            let acYearId = $('select[name="academic_year"]').val();

            //check year, class, section and date is fill up then procced
            if (!atDate || !classId || !sectionId) {
                toastr.warning('Fill up class, section and date first!');
                return false;
            }
            if (institute_category == "college" && !acYearId) {
                toastr.warning('Select academic year first!');
                return false;
            }

            let queryString = "?class=" + classId + "&section=" + sectionId + "&attendance_date=" + atDate;
            if (institute_category == 'college') {
                queryString += "&academic_year=" + acYearId;
            }

            let getUrl = window.location.href.split('?')[0] + queryString;
            window.location = getUrl;

        });

        $('.attendanceExistsChecker').on('dp.change', function (event) {
            Academic.checkAttendanceExists(function (data) {
                if (data > 0) {
                    toastr.error('Attendance already exists!');
                }
                else {
                    $('#section_id_filter').trigger('change');
                }
            });

        });
        $('#toggleCheckboxes').on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                $('input:checkbox:not(.notMe)').iCheck('check');
            } else {
                $('input:checkbox:not(.notMe)').iCheck('uncheck');
            }
        });

        $('#section_id_filter').on('change', function () {
            //hide button
            let sectionId = $(this).val();
            let classId = $('select[name="class_id"]').val();
            let acYearId = $('select[name="academic_year"]').val();
            //validate input
            if (!classId || !sectionId) {
                return false;
            }
            //check year then procced
            if (institute_category == "college") {
                if (!acYearId) {
                    toastr.warning('Select academic year first!');
                    return false;
                }
            }
            else {
                acYearId = 0;
            }

            Generic.loaderStart();
            Academic.checkAttendanceExists(function (data) {
                if (data > 0) {
                    toastr.error('Attendance already exists!');
                }

                Generic.loaderStop();

            });


        });

        $('input.inTime').on('dp.change', function (event) {
            let attendance_date = window.moment($('input[name="attendance_date"]').val(), 'DD-MM-YYYY');
            let inTime = window.moment(event.date, 'DD-MM-YYYY');
            if (inTime.isBefore(attendance_date)) {
                toastr.error('In time can\'t be less than attendance date!');
                $(this).data("DateTimePicker").date(attendance_date.format('DD/MM/YYYY, hh:mm A'));
                return false;
            }

            let timeDiff = window.moment.duration(inTime.diff(attendance_date));
            if (timeDiff.days() > 0) {
                toastr.error('In time can\'t be greater than attendance date!');
                $(this).data("DateTimePicker").date(attendance_date.format('DD/MM/YYYY, hh:mm A'));
                return false;
            }

        });

        $('input.outTime').on('dp.change', function (event) {
            let inTime = window.moment($(this).parents('tr').find('input.inTime').val(), 'DD-MM-YYYY, hh:mm A');
            let outTime = window.moment(event.date, 'DD-MM-YYYY, hh:mm A');

            if (outTime.isBefore(inTime)) {
                toastr.error('Out time can\'t be less than in time!');
                $(this).data("DateTimePicker").date(inTime);
                return false;
            }
            let timeDiff = window.moment.duration(outTime.diff(inTime));
            if (timeDiff.days() > 0) {
                toastr.error('Can\'t stay more than 24 hrs!');
                $(this).data("DateTimePicker").date(inTime);
                return false;
            }
            let workingHours = [timeDiff.hours(), timeDiff.minutes()].join(':');
            $(this).parents('tr').find('span.stayingHour').text(workingHours);

        });
    }

    static checkAttendanceExists(cb = {}) {
        let atDate = $('input[name="attendance_date"]').val();
        let classId = $('select[name="class_id"]').val();
        let sectionId = $('select[name="section_id"]').val();
        let acYearId = $('select[name="academic_year"]').val();
        let queryString = "?class=" + classId + "&section=" + sectionId + "&attendance_date=" + atDate;

        if (institute_category == 'college') {
            queryString += "&academic_year=" + acYearId;
        }

        let getUrl = window.attendanceUrl + queryString;
        axios.get(getUrl)
            .then((response) => {
                cb(response.data);
            }).catch((error) => {
            let status = error.response.statusText;
            toastr.error(status);
            cb(0);
            Generic.loaderStop();
        });

    }

    static attendanceFileUploadStatus() {
        // progress status js code here
        $.ajax({
            'url': window.fileUploadStatusURL,
        }).done(function (r) {
            if (r.success) {
                $('#statusMessage').html(r.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            } else {
                $('#statusMessage').html(r.msg);
                if (r.status == 0) {
                    setTimeout(function () {
                        Academic.attendanceFileUploadStatus();
                    }, 500);
                }
                else if (r.status == -1) {
                    $('.progressDiv').removeClass('alert-info');
                    $('.progressDiv').addClass('alert-danger');
                    $('#spinnerspan').remove();
                }

            }
        }).fail(function () {
            $('#statusMessage').html("An error has occurred...Contact administrator");
        });

    }

    static studentProfileInit() {
        $('.btnPrintInformation').click(function () {
            $('ul.nav-tabs li:not(.active)').addClass('no-print');
            $('ul.nav-tabs li.active').removeClass('no-print');
            window.print();
        });

        $('#tabAttendance').click(function () {
            let id = $(this).attr('data-pk');
            let geturl = window.attendanceUrl + '?student_id=' + id;
            Generic.loaderStart();
            $('#attendanceTable tbody').empty();
            axios.get(geturl)
                .then((response) => {
                    // console.log(response);
                    if (response.data.length) {
                        response.data.forEach(function (item) {
                            let color = item.present == "Present" ? 'bg-green' : 'bg-red';
                            let trrow = ' <tr>\n' +
                                '  <td class="text-center">' + item.attendance_date + '</td>\n' +
                                '  <td class="text-center"> <span class="badge ' + color + '">' + item.present + '</span></td>\n' +
                                '</tr>';

                            $('#attendanceTable tbody').append(trrow);
                        });
                    }

                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();
            });
        });

        $('#tabMakrs').click(function () {
            let id = $(this).attr('data-pk');
            let geturl = window.marksUrl + '?student_id=' + id;
            Generic.loaderStart();
            $('#marks').empty();
            axios.get(geturl)
                .then((response) => {
                    // console.log(response);
                    if(response.data.success){
                        response.data.data.forEach(function (examData) {
                            $('#marks').append(generateExamMarksAndResultHtml(examData));
                        });
                    }
                    else{
                        toastr.error(response.data.message);
                    }
                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();
            });
        });

        $('#tabSubject').click(function () {
            let id = $(this).attr('data-pk');
            let geturl = window.subjectUrl + '?student_id=' + id;
            Generic.loaderStart();
            $('#subjectTable tbody').empty();
            axios.get(geturl)
                .then((response) => {
                    // console.log(response);
                    if (response.data.success && response.data.data.length) {
                        response.data.data.forEach(function (subject) {
                            let row = `<tr><td>${subject.name}</td><td>${subject.code}</td>
                                <td>${subject.type}</td></tr>`;

                            $('#subjectTable tbody').append(row);
                        });
                    }
                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();
            });
        });

        function generateExamMarksAndResultHtml(examData) {
            var html ='';
            if(examData.marks.length) {
                 html += '<h4 class="title text-info">' + examData.exam + '</h4>\n' +
                    '                            <table class="table table-bordered table-hover table-marks-and-result">\n' +
                    '                                <thead>\n' +
                    '                                <tr>\n' +
                    '                                    <td rowspan="2" class="text-center">Subject</td>\n' +
                    '                                    <td rowspan="2" class="text-center">Code</td>\n' +
                    '                                    <td colspan="3" colspan="' + Object.keys(examData.marks_distribution).length + '" class="text-center">Marks</td>\n' +
                    '                                    <td rowspan="2" class="text-center">Total Marks</td>\n' +
                    '                                    <td rowspan="2" class="text-center">Grade</td>\n' +
                    '                                    <td rowspan="2" class="text-center">Point</td>\n' +
                    '                                </tr>\n';

                html += '<tr>\n';
                for (var mdType in examData.marks_distribution) {
                    html += '<td>' + examData.marks_distribution[mdType] + '</td>\n';
                }
                html += '</tr></thead><tbody>\n';

                examData.marks.forEach(function (mark) {
                    var row = '<tr>';
                    row += `<td>${mark.subject.name}</td><td>${mark.subject.code}</td>`;
                    var marksDistribution = JSON.parse(mark.marks);
                    for (var mdType in examData.marks_distribution) {
                        row += '<td>' + marksDistribution[mdType] + '</td>\n';
                    }
                    row += `<td>${mark.total_marks}</td><td>${mark.grade}</td><td>${mark.point}</td>`;
                    row += '</tr>';

                    html += row;
                });
                html += `<tfoot>
                        <tr>
                            <td colspan="${Object.keys(examData.marks_distribution).length + 2}">Result</td>
                            <td>${examData.result.total_marks}</td>
                            <td>${examData.result.grade}</td>
                            <td>${examData.result.point}</td>
                        </tr>
                     </tfoot>`;
                html += '</tbody></table>';
            }

            return html
        }
    }


    static examRuleInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
        $('#exam_rules_add_class_change').on('change', function () {
            //get subject of requested class
            Generic.loaderStart();
            let class_id = $(this).val();
            Academic.getSubject(class_id, 0, function (res = {}) {
                // console.log(res);
                if (Object.keys(res).length) {
                    $('select[name="subject_id"]').empty().prepend('<option selected=""></option>').select2({ placeholder: 'Pick a subject...', data: res });
                    $('select[name="combine_subject_id"]').empty().prepend('<option selected=""></option>').select2({ placeholder: 'Pick a subject...', data: res });
                }
                else {
                    // clear subject list dropdown
                    $('select[name="subject_id"]').empty().select2({ placeholder: 'Pick a subject...' });
                    $('select[name="combine_subject_id"]').empty().select2({ placeholder: 'Pick a subject...' });
                    toastr.warning('This class have no subject!');
                }
                Generic.loaderStop();
            });

            //now fetch exams for this class
            Academic.getExam(class_id);

        });

        $('select[name="exam_id"]').on('change', function () {
            $('#distributionTypeTable tbody').empty();
            if ($(this).val()) {
                let getUrl = window.exam_details_url + "?exam_id=" + $(this).val();
                Generic.loaderStart();
                axios.get(getUrl)
                    .then((response) => {
                        // console.log(response.data);
                        response.data.forEach(function (item) {
                            let trrow = '<tr>\n' +
                                ' <td>\n' +
                                ' <span>' + item.text + '</span>\n' +
                                ' <input type="hidden" name="type[]" value="' + item.id + '">\n' +
                                ' </td>\n' +
                                ' <td>\n' +
                                '<input type="number" class="form-control" name="total_marks[]" value="" required min="0">\n' +
                                '</td>\n' +
                                ' <td>\n' +
                                '<input type="number" class="form-control" name="pass_marks[]" value="0" required min="0">\n' +
                                '</td>\n' +
                                '</tr>';

                            $('#distributionTypeTable tbody').append(trrow);
                        });
                        Generic.loaderStop();
                    }).catch((error) => {
                    let status = error.response.statusText;
                    toastr.error(status);
                    Generic.loaderStop();
                });
            }
        });

        function fetchGradeInfo() {
            $('input[name="total_exam_marks"]').val('');
            $('input[name="over_all_pass"]').val('');
            let gradeId = $('select[name="grade_id"]').val();
            if (gradeId) {
                let getUrl = window.grade_details_url + "?grade_id=" + gradeId;
                Generic.loaderStart();
                axios.get(getUrl)
                    .then((response) => {
                        // console.log(response.data);
                        $('input[name="total_exam_marks"]').val(response.data.totalMarks);
                        $('input[name="over_all_pass"]').val(response.data.passingMarks);
                        Generic.loaderStop();
                    }).catch((error) => {
                    let status = error.response.statusText;
                    toastr.error(status);
                    Generic.loaderStop();
                });
            }
        }

        $('select[name="grade_id"]').on('change', function () {
            fetchGradeInfo();
        });
        $('select[name="combine_subject_id"]').on('change', function () {
            let subjectId = $('select[name="subject_id"]').val();
            let combineSujectId = $(this).val();

            if (subjectId == combineSujectId) {
                toastr.error("Same subject can not be a combine subject!");
                $('select[name="combine_subject_id"]').val('').trigger('change');
            }
        });
        $('select[name="passing_rule"]').on('change', function () {
            let passingRule = $(this).val();
            if (passingRule == 2) {
                // individual pass
                $('input[name="over_all_pass"]').val(0);
                $('input[name="pass_marks[]"]').prop('readonly', false);
                $('input[name="pass_marks[]"]').val(0);
            }
            else {
                if ($('input[name="over_all_pass"]').val() == 0) {
                    fetchGradeInfo();
                }
                $('.overAllPassDiv').show();
            }

            if (passingRule == 1) {
                $('input[name="pass_marks[]"]').prop('readonly', true);
            }
            else {
                $('input[name="pass_marks[]"]').prop('readonly', false);
                $('input[name="pass_marks[]"]').val(0);
            }
        });

        //
        $('html').on('change keyup paste', 'input[name="total_marks[]"]', function () {
            let grandTotalMakrs = parseInt($('input[name="total_exam_marks"]').val());
            let distributionTotalMarks = 0;
            $('input[name="total_marks[]"]').each(function (index, element) {
                if ($(element).val().length) {
                    distributionTotalMarks += parseInt($(element).val());
                }
            });
            // console.log(grandTotalMakrs, distributionTotalMarks);
            if (distributionTotalMarks > grandTotalMakrs) {
                toastr.error("Marks distribution is wrong! Not match with total marks.");
                $('input[name="total_marks[]"]').val(0);
            }
        });

        //list page js
        $('select[name="class"]').on('change', function () {
            let classId = $(this).val();
            if (classId) {
                //now fetch exams for this class
                Generic.loaderStart();
                let getUrl = window.exam_list_url + "?class_id=" + classId;
                axios.get(getUrl)
                    .then((response) => {
                        if (Object.keys(response.data).length) {
                            $('select[name="exam"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a exam...', data: response.data });
                        }
                        else {
                            $('select[name="exam"]').empty().select2({ placeholder: 'Pick a exam...' });
                            toastr.error('This class have no exam!');
                        }
                        Generic.loaderStop();
                    }).catch((error) => {
                    let status = error.response.statusText;
                    toastr.error(status);
                    Generic.loaderStop();

                });
            }
            else {
                $('select[name="exam"]').empty().select2({ placeholder: 'Pick a exam...' });
            }
        });
        $('#exam_rule_list_filter').on('change', function () {
            let classId = $('select[name="class"]').val();
            let examId = $('select[name="exam"]').val();
            if (classId && examId) {
                let getUrl = window.location.href.split('?')[0] + "?class_id=" + classId + "&exam_id=" + examId;
                window.location = getUrl;
            }
        });
    }

    static getExam(class_id, check_open=false) {
        let getUrl = window.exam_list_url + "?class_id=" + class_id;
        if(check_open) {
            getUrl += "&open_for_exam=1";
        }
        if (class_id) {
            Generic.loaderStart();
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        $('select[name="exam_id"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a exam...', data: response.data });
                    }
                    else {
                        $('select[name="exam_id"]').empty().select2({ placeholder: 'Pick a exam...' });
                        toastr.error('This class have no exam!');
                    }
                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();

            });
        }
        else {
            // clear section list dropdown
            $('select[name="exam_id"]').empty().select2({ placeholder: 'Pick a exam...' });
        }
    }

    static marksInit() {
        Generic.initCommonPageJS();
        $("#markForm").validate({
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
        $('#class_change').on('change', function () {
            let class_id = $(this).val();
            if (class_id) {
                //get sections
                Academic.getSection(class_id);
                //get subject of requested class
                Generic.loaderStart();
                Academic.getSubject(class_id, 0, function (res = {}) {
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

                //get sections
                var loadOnlyOpen = window.exam_entry_page || false;
                Academic.getExam(class_id, loadOnlyOpen);
            }
            else {
                $('select[name="section_id"]').empty().select2({ placeholder: 'Pick a section...' });
                $('select[name="subject_id"]').empty().select2({ placeholder: 'Pick a subject...' });
                $('select[name="exam_id"]').empty().select2({ placeholder: 'Pick a exam...' });
            }

        });

        $('input[type="number"]').on('change keyup paste', function () {
            let marksElements = $(this).closest('tr').find('input[type="number"]');
            let totalMarks = 0;
            marksElements.each(function (index, element) {
                let marks = parseFloat($(element).val());
                if (marks) {
                    totalMarks += marks;
                }
            });
            $(this).closest('tr').find('input.totalMarks').val(totalMarks.toFixed(2));
        });

        $('input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                $(this).closest('tr').find('input[type="number"]').val(0).prop('readonly', true);
                $(this).closest('tr').find('input.totalMarks').val(0);
            } else {
                $(this).closest('tr').find('input[type="number"]').val('').prop('readonly', false);
                $(this).closest('tr').find('input.totalMarks').val(0);
            }
        });

    }

    static resultInit() {
        Generic.initCommonPageJS();
        $('#class_change').on('change', function () {
            let class_id = $(this).val();
            if (class_id) {
                if (!window.generatePage) {
                    //get sections
                    Academic.getSection(class_id);
                }
                //get sections
                Academic.getExam(class_id);
            }
            else {
                $('select[name="section_id"]').empty().select2({ placeholder: 'Pick a section...' });
                $('select[name="exam_id"]').empty().select2({ placeholder: 'Pick a exam...' });
            }

        });

        //marksheetview button click

        $('html').on('click','a.viewMarksheetPubBtn',function (e) {
            e.preventDefault();
            postForm(this, window.marksheetpub_url);

        });

        function postForm(btnElement, marksheet_form_url) {
            let regiNo = $(btnElement).attr('data-regino');
            let pubMarksheetBtn = $(btnElement).hasClass("viewMarksheetPubBtn");
            let classId = $('select[name="class_id"]').val();
            let examId = $('select[name="exam_id"]').val();
            let section_id = $('select[name="section_id"]').val();
            let csrf = document.head.querySelector('meta[name="csrf-token"]').content;
            let formHtml = '<form id="marksheedForm" action="' + marksheet_form_url + '" method="post" target="_blank" enctype="multipart/form-data">\n' +
                '    <input type="hidden" name="_token" value="' + csrf + '">\n' +
                '    <input type="hidden" name="class_id" value="' + classId + '">\n' +
                '    <input type="hidden" name="exam_id" value="' + examId + '">\n' +
                '    <input type="hidden" name="regi_no" value="' + regiNo + '">\n';
            if (pubMarksheetBtn) {
                formHtml += '    <input type="hidden" name="authorized_form" value="1">\n';
            }
            else{
                formHtml += '<input type="hidden" name="section_id" value="' + section_id + '">\n';
            }

            var ac_year = $('select[name="academic_year_id"]').val();
            formHtml += '    <input type="hidden" name="academic_year" value="'+ac_year+'">\n';
            formHtml += '</form>';

            $('body').append(formHtml);
            $('#marksheedForm').submit();
            $('#marksheedForm').remove();
        }
    }

    static promotionInit() {
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
        $('input').not('.dont-style').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
        $('.select2').select2();

        $('#current_year_change').on('change', function () {
            let acYearId = $(this).val();
            if (acYearId) {
                Generic.loaderStart();
                let getUrl = window.academicYearUrl + "?current_academic_year_id=" + acYearId;
                axios.get(getUrl)
                    .then((response) => {
                        if (Object.keys(response.data).length) {
                            $('select[name="promote_academic_year_id"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a year...', data: response.data });
                        }
                        else {
                            $('select[name="promote_academic_year_id"]').empty().select2({ placeholder: 'Pick a year...' });
                            toastr.error('Academic year not found! Create it.');
                        }
                        Generic.loaderStop();
                    }).catch((error) => {
                    let status = error.response.statusText;
                    toastr.error(status);
                    Generic.loaderStop();

                });
            }
            else {
                $('select[name="promote_academic_year_id"]').empty().select2({ placeholder: 'Pick a year...' });
            }

        });

        $('#current_class_change').on('change', function () {
            let class_id = $(this).val();
            if (class_id) {
                //get sections
                Academic.getExam(class_id);
            }
            else {
                $('select[name="exam_id"]').empty().select2({ placeholder: 'Pick a exam...' });
            }

        });

        $('select[name="exam_id"]').on('change', function () {
            let class_id = $('#current_class_change').val();
            let exam_id = $(this).val();
            let getUrl = window.subject_count_url + "?classId="+class_id+"&examId="+exam_id+"&type=2";
            Generic.loaderStart();
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        $('select[name="fail_count"]').empty().prepend('<option selected=""></option>').select2({ allowClear: true, placeholder: 'Pick a option...', data: response.data });
                    }
                    else {
                        $('select[name="fail_count"]').empty().select2({ placeholder: 'Pick a option...' });
                    }

                    Generic.loaderStop();
                }).catch((error) => {
                let status = error.response.statusText;
                toastr.error(status);
                Generic.loaderStop();
            });

        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            var that = this;
            swal({
                title: 'Are you sure?',
                text: 'You want to do promotion? Re-check all information again, because this process is not recoverable!.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Do it!',
                cancelButtonText: 'No, Will check it!'
            }).then((result) => {
                if (result.value) {
                    that.submit();
                }
            });
        });
    }

}