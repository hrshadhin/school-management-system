let mixFrontend = require('laravel-mix');
const fs = require('file-system');
// const del = require('del');
const _ = require('lodash');
const jsonfile = require('jsonfile');

const filesPublicPath = "public";
const subDirectoryPath = '/frontend'
const fullPublicPath = filesPublicPath + subDirectoryPath;
const mixManifest = fullPublicPath + '/mix-manifest.json';
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
    // uglify: {},
    purifyCss: false,
    // purifyCss: {},
    clearConsole: false
});


// copy non processing files to public path
mixFrontend.copyDirectory('resources/assets/frontend/libs/jquery.min.js', 'public/frontend/js/jquery.min.js');
mixFrontend.copyDirectory('resources/assets/frontend/img', 'public/frontend/img');
mixFrontend.copyDirectory('resources/assets/frontend/fonts', 'public/frontend/fonts');
mixFrontend.copyDirectory('resources/assets/frontend/flags', 'public/frontend/flags');
mixFrontend.copyDirectory('resources/assets/frontend/rs-plugin', 'public/frontend/rs-plugin');
mixFrontend.copyDirectory('resources/assets/frontend/uploads', 'public/frontend/uploads');

if (mixFrontend.inProduction()) {
    mixFrontend.version();
    mixFrontend.sourceMaps();
}

mixFrontend.browserSync({
    proxy: 'l5.school.test'
});