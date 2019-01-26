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

}