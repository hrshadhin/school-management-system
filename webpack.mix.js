let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/backend/js/app.js', 'public/js')
    .extract(['jquery', 'bootstrap', 'icheck', 'jquery-validation', 'slimscroll', 'fastclick', 'chart.js', 'fullcalendar'])
    .sass('resources/assets/backend/sass/app.scss', 'public/css')
    .sass('resources/assets/backend/sass/vendor.scss', 'public/css')
    .styles([
        'resources/assets/backend/css/AdminLTE.css',
        'resources/assets/backend/css/_all-skins.css',
    ], 'public/css/theme.css')
    .js([
        'resources/assets/backend/js/adminlte.js',
        'resources/assets/backend/js/theme_settings.js'
    ], 'public/js/theme.js')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery', 'jquery']
    });


mix.options({
    processCssUrls: true,
    // uglify: {},
    purifyCss: false,
    // purifyCss: {},
    clearConsole: false
});


// copy non processing files to public path
mix.copyDirectory('resources/assets/backend/images', 'public/images');



if (mix.inProduction()) {
    mix.version();
    mix.sourceMaps();
}

mix.browserSync({
    proxy: 'l5.school.test'
});
