let mix = require("laravel-mix");
var LiveReloadPlugin = require("webpack-livereload-plugin");

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css");

mix.webpackConfig({
    plugins: [new LiveReloadPlugin()],
});
