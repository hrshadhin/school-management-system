export default class Settings {
    /**
     * app settings related codes
     */
    static instituteInit() {
        Generic.initCommonPageJS();
    }

    static reportInit() {
        Generic.initCommonPageJS();
        $('.my-colorpicker').colorpicker();
    }

}