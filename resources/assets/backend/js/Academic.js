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
            if(class_id){
                getUrl +="?class="+class_id;

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
            if(value == 'Other'){
                $('input[name="nationality_other"]').prop('readonly', false);
            }
            else{
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
            Generic.loaderStart();
            let class_id = $(this).val();
            let type = (institute_category == "college") ? 0 : 2;
            Academic.getSubject(class_id, type, function (res={}) {
                // console.log(res);
                if (Object.keys(res).length){

                    $('select[name="fourth_subject"]').empty().prepend('<option selected=""></option>').select2({placeholder: 'Pick a subject...', data: res});

                }
                else{
                    // clear subject list dropdown
                    $('select[name="fourth_subject"]').empty().select2({placeholder: 'Pick a subject...'});
                    toastr.warning('This class have no subject!');
                }
                Generic.loaderStop();
            });
            if(institute_category == "college") {
                Generic.loaderStart();
                Academic.getSubject(class_id, 1, function (res={}) {
                    // console.log(res);
                    if (Object.keys(res).length){

                        $('select[name="alt_fourth_subject"]').empty().prepend('<option selected=""></option>').select2({placeholder: 'Pick a subject...', data: res});

                    }
                    else{
                        // clear subject list dropdown
                        $('select[name="alt_fourth_subject"]').empty().select2({placeholder: 'Pick a subject...'});
                        toastr.warning('This class have no subject!');
                    }
                    Generic.loaderStop();
                });

            }
        });

        $('#student_list_filter').on('change', function () {
            let class_id = $('select[name="class_id"]').val();
            let section_id = $(this).val();
            let urlLastPart = '';
            if(institute_category == 'college'){
                let ac_year = $('select[name="academic_year"]').val();
                if(!ac_year){
                    toastr.error('Select academic year!');
                    return false;
                }

                urlLastPart ="&academic_year="+ac_year;
            }
            if(class_id && section_id){
                let getUrl = window.location.href.split('?')[0]+"?class="+class_id+"&section="+section_id+urlLastPart;
                window.location = getUrl;

            }

        });
        $('select[name="academic_year"]').on('change', function () {
            $('#student_list_filter').trigger('change');
        });


    }
    static  getSection(class_id) {
        let getUrl = window.section_list_url + "?class=" + class_id;
        if (class_id) {
            Generic.loaderStart();
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        $('select[name="section_id"]').empty().prepend('<option selected=""></option>').select2({allowClear: true,placeholder: 'Pick a section...', data: response.data});
                    }
                    else {
                        $('select[name="section_id"]').empty().select2({placeholder: 'Pick a section...'});
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
            $('select[name="section_id"]').empty().select2({placeholder: 'Pick a section...'});
        }
    }
    static  getSubject(class_id, $type=0, cb) {
        let getUrl = window.subject_list_url + "?class=" + class_id+"&type="+$type;
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
    static getStudentByAcYearAndClassAndSection(acYear=0, classId, sectionId, cb=function(){}) {
        let getUrl = window.getStudentAjaxUrl +"?academic_year="+acYear+"&class="+classId+"&section="+sectionId;
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

        $('#attendance_list_filter').on('changeDate', function (event) {
            let atDate = $(this).val();
            let classId = $('select[name="class_id"]').val();
            let sectionId = $('select[name="section_id"]').val();
            let acYearId = $('select[name="academic_year"]').val();

            //check year, class, section and date is fill up then procced
            if(!atDate || !classId || !sectionId){
                toastr.warning('Fill up class, section and date first!');
                return false;
            }
            if(institute_category == "college" && !acYearId){
                toastr.warning('Select academic year first!');
                return false;
            }

            let queryString = "?class="+classId+"&section="+sectionId+"&attendance_date="+atDate;
            if(institute_category == 'college'){
                queryString +="&academic_year="+acYearId;
            }

            let getUrl = window.location.href.split('?')[0]+queryString;
            window.location = getUrl;

        });

        $('.attendanceExistsChecker').on('changeDate', function (event) {
            Academic.checkAttendanceExists(function (data) {
                    if(data>0){
                        toastr.error('Attendance already exists!');
                        $('#studentListTable tbody').empty();
                        $('button[type="submit"]').hide();
                    }
                    else{
                        $('#section_id_filter').trigger('change');
                    }
            });

        });

        $('#toggleCheckboxes').on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                $('input:checkbox').iCheck('check');
            } else {
                $('input:checkbox').iCheck('uncheck');
            }
        });

        $('#section_id_filter').on('change', function () {
            //hide button
            $('button[type="submit"]').hide();
            let sectionId = $(this).val();
            let classId =  $('select[name="class_id"]').val();
            let acYearId =  $('select[name="academic_year"]').val();
            //validate input
            if(!classId || !sectionId){
                return false;
            }
            //check year then procced
            if(institute_category == "college"){
                if(!acYearId) {
                    toastr.warning('Select academic year first!');
                    return false;
                }
            }
            else {
                acYearId = 0;
            }

            Generic.loaderStart();
            Academic.checkAttendanceExists(function (data) {
                if(data==0){
                    Academic.getStudentByAcYearAndClassAndSection(acYearId, classId, sectionId, function (data) {
                        let students = data;
                        $('#studentListTable tbody').empty();
                        if(students.length){
                            students.forEach(function(item){
                                let rowHtml = '<tr>\n' +
                                    '<td>\n' +
                                    '<span class="text-bold">'+item.student.name+'</span>\n' +
                                    '<input type="hidden" name="registrationIds[]" value="'+item.id+'" required>\n' +
                                    '</td>\n' +
                                    '<td><span class="text-bold">'+item.roll_no+'</span></td>\n' +
                                    '<td>\n' +
                                    '<div class="checkbox icheck inline_icheck">\n' +
                                    '<input type="checkbox" name="present['+item.id+']">\n' +
                                    '</div>\n' +
                                    '</td>\n' +
                                    '</tr>';

                                $('#studentListTable tbody').append(rowHtml);
                            });
                            $('input:checkbox').not('.dont-style-notMe').iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%' /* optional */
                            });

                            //now show the submit button
                            $('button[type="submit"]').show();
                        }
                        Generic.loaderStop();
                    });
                }
                else{
                    toastr.error('Attendance already exists!');
                    Generic.loaderStop();
                }
            });


        });
    }

    static checkAttendanceExists(cb={}) {
        let atDate = $('input[name="attendance_date"]').val();
        let classId = $('select[name="class_id"]').val();
        let sectionId = $('select[name="section_id"]').val();
        let acYearId = $('select[name="academic_year"]').val();
        let queryString = "?class="+classId+"&section="+sectionId+"&attendance_date="+atDate;

        if(institute_category == 'college'){
            queryString +="&academic_year="+acYearId;
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
        }).done(function(r) {
            if(r.success) {
                $('#statusMessage').html(r.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            } else {
                $('#statusMessage').html(r.msg);
                if(r.status == 0){
                    setTimeout(function () {
                        Academic.attendanceFileUploadStatus();
                    }, 500);
                }
                else if(r.status == -1){
                    $('.progressDiv').removeClass('alert-info');
                    $('.progressDiv').addClass('alert-danger');
                    $('#spinnerspan').remove();
                }

            }
        }).fail(function() {
                $('#statusMessage').html("An error has occurred...Contact administrator" );
            });

    }

    static studentProfileInit() {
        $('.btnPrintInformation').click(function () {
            window.print();
        });

        $('#tabAttendance').click(function () {
            let id = $(this).attr('data-pk');
            let geturl = window.attendanceUrl+'?student_id='+id;
            Generic.loaderStart();
            $('#attendanceTable tbody').empty();
            axios.get(geturl)
                .then((response) => {
                   // console.log(response);
                   if(response.data.length){
                       response.data.forEach(function (item) {
                           let color = item.present == "Present" ? 'bg-green' : 'bg-red';
                          let trrow = ' <tr>\n' +
                              '  <td class="text-center">'+item.attendance_date+'</td>\n' +
                              '  <td class="text-center"> <span class="badge '+ color+'">'+item.present+'</span></td>\n' +
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
    }
}