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
    static studentInit() {
        Generic.initCommonPageJS();
        Generic.initDeleteDialog();
        $('select[name="nationality"]').on('change', function () {
            var value = $(this).val();
            if(value == 'Other'){
                $('input[name="nationality"]').prop('readonly', false);
            }
            else{
                $('input[name="nationality"]').val('');
                $('input[name="nationality"]').prop('readonly', true);
            }
        });

        $('select[name="class_id"]').on('change', function () {
            let class_id = $(this).val();
            Generic.loaderStart();
            Academic.getSection(class_id);
            Generic.loaderStop();
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
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        $('select[name="section_id"]').empty().prepend('<option selected=""></option>').select2({placeholder: 'Pick a section...', data: response.data});
                    }
                    else {
                        $('select[name="section_id"]').empty().select2({placeholder: 'Pick a section...'});
                        toastr.error('This class have no section!');
                    }
                }).catch((error) => {
                let status = error.statusText;
                toastr.error(status);

            });
        }
        else {
            // clear section list dropdown
            $('select[name="section_id"]').empty().select2({placeholder: 'Pick a section...'});
        }
    }

}