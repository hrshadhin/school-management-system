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
            Academic.getSection(class_id);
        });

        $('select[name="class_filter"]').on('change', function () {
            let class_id = $(this).val();
            if(class_id){
                let getUrl = window.location.href.split('?')[0]+"?class="+class_id;
                window.location = getUrl;

            }

        });


    }
    static  getSection(class_id) {
        let getUrl = window.section_list_url + "?class=" + class_id;
        if (class_id) {
            axios.get(getUrl)
                .then((response) => {
                    if (Object.keys(response.data).length) {
                        $('select[name="section_id"]').select2({data: response.data});
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