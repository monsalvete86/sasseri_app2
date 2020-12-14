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

mix.styles([
    'resources/assets/plantilla/css/font-face.css',
    'resources/assets/plantilla/css/font-awesome.min.css',
    // 'resources/assets/plantilla/css/all.min.css',
    'resources/assets/plantilla/css/fontawesome-all.min.css',
    'resources/assets/plantilla/css/material-design-iconic-font.min.css',
    'resources/assets/plantilla/css/bootstrap.min.css',
    'resources/assets/plantilla/css/animsition.min.css',
    'resources/assets/plantilla/css/bootstrap-progressbar-3.3.4.min.css',
    'resources/assets/plantilla/css/animate.css',
    'resources/assets/plantilla/css/hamburgers.min.css',
    'resources/assets/plantilla/css/slick.css',
    'resources/assets/plantilla/css/select2.min.css',
    'resources/assets/plantilla/css/perfect-scrollbar.css',
    'resources/assets/plantilla/css/theme.css',
    
    'resources/assets/plantilla/css/simple-line-icons.min.css',
    'resources/assets/plantilla/css/bootstrap-datetimepicker.min.css',
    
    // 'resources/assets/plantilla/css/theme.css',
    // 'resources/assets/plantilla/css/style.css',
    'node_modules/vue-multiselect/dist/vue-multiselect.min.css'
], 'public/css/plantilla.css')
.scripts([


    // 'resources/assets/plantilla/js/jquery-3.2.1.min.js',
    'resources/assets/plantilla/js/popper.min.js',
    'resources/assets/plantilla/js/bootstrap.min.js',
    'resources/assets/plantilla/js/slick.min.js',
    'resources/assets/plantilla/js/wow.min.js',
    // 'resources/assets/plantilla/js/animsition.min.js',
    'resources/assets/plantilla/js/bootstrap-progressbar.min.js',
    'resources/assets/plantilla/js/jquery.waypoints.min.js',

    'resources/assets/plantilla/js/jquery.counterup.min.js',
    'resources/assets/plantilla/js/circle-progress.min.js',
    'resources/assets/plantilla/js/perfect-scrollbar.js',
    'resources/assets/plantilla/js/Chart.bundle.min.js',
    'resources/assets/plantilla/js/select2.min.js',
], 'public/js/plantilla.js')
.js(['resources/assets/js/app.js'],'public/js/app.js');