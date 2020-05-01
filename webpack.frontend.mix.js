let mixFrontend = require('laravel-mix');

const fullPublicPath = "public/frontend";

/*
 |--------------------------------------------------------------------------
 | Mix Frontend Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mixFrontend.setPublicPath(fullPublicPath);

mixFrontend.js('resources/assets/frontend/js/libs.js', 'public/frontend/js')
    .sass('resources/assets/frontend/sass/libs.scss', 'public/frontend/css');


mixFrontend.options({
    processCssUrls: false,
    purifyCss: false,
    clearConsole: false
});


// copy non processing files to public path
mixFrontend.copyDirectory('resources/assets/frontend/libs/jquery.min.js', 'public/frontend/js/jquery.min.js');
mixFrontend.copyDirectory('resources/assets/frontend/img', 'public/frontend/img');
mixFrontend.copyDirectory('resources/assets/frontend/fonts', 'public/frontend/fonts');
mixFrontend.copyDirectory('resources/assets/frontend/flags', 'public/frontend/flags');
mixFrontend.copyDirectory('resources/assets/frontend/rs-plugin', 'public/frontend/rs-plugin');

if (mixFrontend.inProduction()) {
    mixFrontend.version();
    mixFrontend.sourceMaps();
}