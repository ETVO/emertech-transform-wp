let mix = require("laravel-mix");

mix.disableSuccessNotifications();

mix
    .js('src/js/app.js', 'js/')
    .sass('src/scss/app.scss', 'css/')
    .sass('src/scss/admin.scss', 'css/')
    .setPublicPath("assets/");
