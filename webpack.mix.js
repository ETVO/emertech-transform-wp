let mix = require("webpack-mix");

mix.disableSuccessNotifications();

mix
    .js('src/app.js', 'js/')
    .sass('src/app.scss', 'css/')
    .setPublicPath("assets/");
