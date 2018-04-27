let mix = require('laravel-mix');

var eportal_path = 'public/eportal/';
var vendor_path = 'public/vendor/';

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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

//vendors
mix.scripts([
    vendor_path + 'jquery/dist/jquery.js',
    vendor_path + 'jquery-easing/jquery.easing.js',
    vendor_path + 'angular/angular.js',
    vendor_path + 'bootstrap/dist/js/bootstrap.bundle.js'
], 'public/js/vendor.js');

//Eportal
mix.scripts([
    //session
    eportal_path + 'session/js/services.js',
    eportal_path + 'session/js/controllers.js',
    eportal_path + 'session/session.js',

    //term
    eportal_path + 'term/js/services.js',
    eportal_path + 'term/js/controllers.js',
    eportal_path + 'term/term.js',

    //school
    eportal_path + 'school/js/services.js',
    eportal_path + 'school/js/controllers.js',
    eportal_path + 'school/school.js',

    //class
    eportal_path + 'class/js/services.js',
    eportal_path + 'class/js/controllers.js',
    eportal_path + 'class/class.js',

    //department
    eportal_path + 'department/js/services.js',
    eportal_path + 'department/js/controllers.js',
    eportal_path + 'department/department.js',

    //subject
    eportal_path + 'subject/js/services.js',
    eportal_path + 'subject/js/controllers.js',
    eportal_path + 'subject/subject.js',

    //property
    eportal_path + 'property/js/services.js',
    eportal_path + 'property/js/controllers.js',
    eportal_path + 'property/property.js',

    //main
    eportal_path + 'eportal.js',
], 'public/js/eportal.js');