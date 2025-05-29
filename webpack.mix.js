let mix = require("laravel-mix");

// Kompilasi semua SCSS menjadi satu file CSS
mix.sass(
    "_keenthemes/src/sass/style.scss",
    "public/assets/css/style.bundle.css",
    {
        sassOptions: {
            quietDeps: true,
            includePaths: ["_keenthemes/src/sass/core"],
        },
    }
).options({
    processCssUrls: false,
    postCss: [require("autoprefixer")],
});

// Copy file statis
mix.copy("_keenthemes/src/js/**/*", "public/assets/js")
    .copy("_keenthemes/src/plugins/**/*", "public/assets/plugins")
    .copy("_keenthemes/src/media/**/*", "public/assets/media");

// Aktifkan sourcemaps untuk development
if (!mix.inProduction()) {
    mix.sourceMaps();
}

// Versioning untuk production
if (mix.inProduction()) {
    mix.version();
}
