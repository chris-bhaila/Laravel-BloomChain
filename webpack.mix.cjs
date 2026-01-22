const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [])
   .browserSync({
       proxy: '127.0.0.1:8000',
       open: false,
       notify: false,
       files: [
           'resources/views/**/*.blade.php',
           'resources/js/**/*.js',
           'resources/css/**/*.css',
           'public/js/**/*.js',
           'public/css/**/*.css'
       ],
       rewriteRules: [
           {
               match: /http:\/\/127\.0\.0\.1:8000/g,
               replace: 'http://localhost:3000'
           }
       ]
   });
