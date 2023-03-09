const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .setPublicPath('public')
    .js('resources/js/theme.js', 'public/js')
    .sass('resources/sass/theme.sass', 'public/css')
    .copy('node_modules/jquery/dist', 'public/vendor/jquery')
    .copy('node_modules/aos/dist', 'public/vendor/aos')
    .copy('node_modules/stonehenge.js/dist', 'public/vendor/stonehenge.js');
