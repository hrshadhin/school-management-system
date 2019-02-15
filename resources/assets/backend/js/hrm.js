import Generic from "./Generic";
import Academic from "./Academic";

export default class HRM {
    /**
     * Employee related codes
     */
    static employeeInit() {
        Generic.initCommonPageJS();
    }

    /**
     * Employee Attendance
     */
    static attendanceInit() {
        Generic.initCommonPageJS();

        $('select.emp_filter').on('change', function () {
            $('#attendance_list_filter').trigger('changeDate');
        });

        $('#attendance_list_filter').on('changeDate', function (event) {
            let atDate = $(this).val();
            let employeeId = $('select[name="employee_id"]').val();

            //check employee Id and date is fill up then procced
            if(!atDate){
                toastr.warning('Fill up date!');
                return false;
            }


            let queryString = "?attendance_date="+atDate;
            if(employeeId){
                queryString += "&employee_id="+employeeId;
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