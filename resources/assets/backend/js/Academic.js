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
    }

}