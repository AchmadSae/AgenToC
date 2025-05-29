var elixir = require("laravel-elixir");

elixir(function (mix) {
    mix.sass("resources/keenthemes/sass/**/*.scss", "public/assets/css")
        .copy("resources/keenthemes/js", "public/assets/js")
        .copy("resources/keenthemes/plugins", "public/assets/plugins")
        .copy("resources/keenthemes/media", "public/assets/media");
});
