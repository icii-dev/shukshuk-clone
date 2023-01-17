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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/responsive.scss', 'public/css')
   .sourceMaps()
   .browserSync('127.0.0.1:8000');

mix.scripts([
    'public/vendor/buyer/script/pgwslideshow.min.js',
    'public/vendor/buyer/script/product-detail.js',
    'public/vendor/buyer/script/reviews.js',
], 'public/js/product-detail.js');

mix.styles([
   'public/vendor/buyer/Css/notify.css',
   'public/vendor/buyer/Css/custom.css',
   'public/vendor/buyer/Css/style-mobi.css',
   'public/vendor/buyer/Css/customLib.css',
   'public/asset-common/css/dimension.css',
], 'public/css/all.css');

mix.styles([
    'public/asset-seller/Css/custom-seller.css',
    'public/asset-seller/Css/seller-mobile.css',
    'public/vendor/buyer/Css/loading.css"',
], 'public/css/seller-all.css');

if (mix.inProduction()) {
  mix.version();
}

// mix.browserSync('127.0.0.1:8000');
