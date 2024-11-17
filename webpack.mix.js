const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/lightbox2/dist/css/lightbox.min.css', 'public/css/lightbox.min.css')
   .copy('node_modules/lightbox2/dist/js/lightbox.min.js', 'public/js/lightbox.min.js');
