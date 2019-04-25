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
            $('#attendance_list_filter').trigger('dp.change');
        });

        $('#attendance_list_filter').on('dp.change', function (event) {
            let atDate = $(this).val();
            let employeeId = $('select[name="employee_id"]').val();

            //check employee Id and date is fill up then procced
            if(!atDate){
                return false;
            }


            let queryString = "?attendance_date="+atDate;
            if(employeeId){
                queryString += "&employee_id="+employeeId;
            }

            let getUrl = window.location.href.split('?')[0]+queryString;
            window.location = getUrl;

        });

        $('.attendanceExistsChecker').on('dp.change', function (event) {
            let atDate = $('input[name="attendance_date"]').val();
            let inOutDateTime = atDate + " 00:00 am";
            $('input.date_time_picker').val(inOutDateTime);
            $('input[name="workingHours"]').val("0.00");
            HRM.checkAttendanceExists(function (data) {
                if(data>0){
                    toastr.error('Attendance already exists!');
                    $('button[type="submit"]').hide();
                }
                else{
                    $('button[type="submit"]').show();
                }
            });

        });

        $('input.inTime').on('dp.change', function (event) {
            let attendance_date = window.moment($('input[name="attendance_date"]').val(),'DD-MM-YYYY');
            let inTime =  window.moment(event.date,'DD-MM-YYYY');
            if(inTime.isBefore(attendance_date)){
                toastr.error('In time can\'t be less than attendance date!');
                $(this).data("DateTimePicker").date(attendance_date.format('DD/MM/YYYY, hh:mm A'));
                return false;
            }

            let timeDiff = window.moment.duration(inTime.diff(attendance_date));
            if(timeDiff.days()>0){
                toastr.error('In time can\'t be greater than attendance date!');
                $(this).data("DateTimePicker").date(attendance_date.format('DD/MM/YYYY, hh:mm A'));
                return false;
            }

        });

        $('input.outTime').on('dp.change', function (event) {
            let inTime = window.moment($(this).parents('tr').find('input.inTime').val(),'DD-MM-YYYY, hh:mm A');
            let outTime =  window.moment(event.date,'DD-MM-YYYY, hh:mm A');

            if(outTime.isBefore(inTime)){
                toastr.error('Out time can\'t be less than in time!');
                $(this).data("DateTimePicker").date(inTime);
                return false;
            }
            let timeDiff = window.moment.duration(outTime.diff(inTime));
            if(timeDiff.days()>0){
                toastr.error('Can\'t work more than 24 hrs!');
                $(this).data("DateTimePicker").date(inTime);
                return false;
            }
            let workingHours = [timeDiff.hours(), timeDiff.minutes()].join(':');
            $(this).parents('tr').find('span.workingHour').text(workingHours);

        });
    }

    static checkAttendanceExists(cb={}) {
        let atDate = $('input[name="attendance_date"]').val();
        let queryString = "?attendance_date="+atDate;
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
                        HRM.attendanceFileUploadStatus();
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

    static employeeProfileInit() {
        $('.btnPrintInformation').click(function () {
            $('ul.nav-tabs li:not(.active)').addClass('no-print');
            $('ul.nav-tabs li.active').removeClass('no-print');
            window.print();
        });

        $('#tabAttendance').click(function () {
            let id = $(this).attr('data-pk');
            let geturl = window.attendanceUrl+'?employee_id='+id;
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