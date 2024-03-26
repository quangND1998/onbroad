const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .react()
    .postCss('resources/css/app.css', 'public/css', require('autoprefixer'))
    .alias({
        '@': 'resources/js',
    });

if (mix.inProduction()) {
    mix.version();
}