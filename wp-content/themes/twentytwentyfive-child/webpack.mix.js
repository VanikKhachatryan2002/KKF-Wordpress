const mix = require('laravel-mix');

mix.sass('src/styles/main.scss', 'assets/css/main.min.css').options({
    processCssUrls: false,
});

mix.js('src/index.js', 'assets/js/main.min.js');
mix.js('src/admin.js', 'assets/js/admin.min.js');

if (mix.inProduction()) {
    mix.version();
}