let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue() // Eğer Vue.js kullanıyorsanız
    .sass('resources/sass/app.scss', 'public/css');
