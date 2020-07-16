let mix = require('laravel-mix');
const webpack = require('webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Back Panel Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    plugins: [
        // Ignore all locale files of moment.js
        // new webpack.IgnorePlugin(
        //     /^\.\/locale$/, /moment$/,
        // )
        new webpack.ContextReplacementPlugin(
            // The path to directory which should be handled by this plugin
            // /moment[\/\\]locale/,
            /select2[\/\\]dist[\/\\]js[\/\\]i18n/,
        )
    ]
});

mix.js('resources/assets/backend/js/app.js', 'public/js')
    .js([
        'resources/assets/backend/js/site-dashboard.js',
    ], 'public/js/site-dashboard.js')
    .js([
        'resources/assets/backend/js/dashboard.js',
    ], 'public/js/dashboard.js')
   .js([
        'resources/assets/backend/js/adminlte.js',
        'resources/assets/backend/js/theme_settings.js',
        'resources/assets/backend/js/bootstrap-datetimepicker.min.js',
        'resources/assets/backend/js/bootstrap-toggle.min.js',
    ], 'public/js/theme.js')
    .extract([
        'jquery', 'bootstrap', 'icheck', 'jquery-validation', 'jquery-slimscroll', 'fastclick',
        'datatables.net', 'datatables.net-bs', 'datatables.net-responsive-bs'
    ])
    .sass('resources/assets/backend/sass/app.scss', 'public/css')
    .sass('resources/assets/backend/sass/print.scss', 'public/css')
    .sass('resources/assets/backend/sass/vendor.scss', 'public/css')
    .sass('resources/assets/backend/sass/colorpicker.scss', 'public/css')
    .sass('resources/assets/backend/sass/report.scss', 'public/css')
    .js([
        'resources/assets/backend/js/colorpicker.js',
    ], 'public/js/colorpicker.js')
    .styles([
        'resources/assets/backend/css/AdminLTE.css',
        'resources/assets/backend/css/_all-skins.css',
        'resources/assets/backend/css/bootstrap3-wysihtml5.min.css',
        'resources/assets/backend/css/bootstrap-datetimepicker.min.css',
        'resources/assets/backend/css/bootstrap-toggle.min.css'
    ], 'public/css/theme.css')
    .styles('resources/assets/backend/css/site-dashboard.css', 'public/css/site-dashboard.css')
    .styles('resources/assets/backend/css/pace.css', 'public/css/pace.css')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
        moment: ['window.moment', 'moment'],
    });


mix.options({
    processCssUrls: true,
    purifyCss: false,
    clearConsole: false
});


// copy non processing files to public path
mix.copy('resources/assets/backend/js/bootstrap3-wysihtml5.all.min.js', 'public/js/editor.js');
mix.copy('resources/assets/backend/js/pace.js', 'public/js/pace.js');
mix.copy('resources/assets/backend/js/bootstrap-datetimepicker.min.js', 'public/js/bootstrap-datetimepicker.min.js');
mix.copyDirectory('resources/assets/backend/images', 'public/images');



if (mix.inProduction()) {
    mix.version();
    mix.sourceMaps();
}