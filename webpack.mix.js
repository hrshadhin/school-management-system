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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['jquery', 'bootstrap', 'icheck'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/vendor.scss', 'public/css')
    .styles([
        'resources/assets/css/AdminLTE.css',
        'resources/assets/css/_all-skins.css',
    ], 'public/css/theme.css')
    .scripts(['resources/assets/js/adminlte.js'], 'public/js/theme.js')
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
mix.copyDirectory('resources/assets/images', 'public/images');



if (mix.inProduction()) {
    mix.version();
    mix.sourceMaps();
}

mix.browserSync({
    proxy: 'l5.school.test'
});
