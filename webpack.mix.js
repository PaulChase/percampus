const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [require("tailwindcss")]
);
// .js(
//     "resources/swiper/swiper-bundle.min.js",
//     "public/swiper/swiper-bundle.min.js"
// )
// .postCss(
//     "resources/swiper/swiper-bundle.min.css",
//     "public/swiper/swiper-bundle.min.css"
// );
