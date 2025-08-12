let mix = require("laravel-mix");

// Set output public path to avoid Windows locking issues on public/mix.js (MockEntryPlugin)
mix.setPublicPath("public/assets");

// Kompilasi semua SCSS menjadi satu file CSS
mix.sass(
    "_keenthemes/src/sass/style.scss",
    "css/style.bundle.css",
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

// Copy file statis Please uncomment to compile the assets
mix.copyDirectory("_keenthemes/src/js/custom", "js/custom");
mix.copy("_keenthemes/src/js/**/*.js", "js");
// .copyDirectory("_keenthemes/src/plugins", "public/assets/plugins")
// .copyDirectory("_keenthemes/src/media", "public/assets/media");

// Aktifkan sourcemaps untuk development
if (!mix.inProduction()) {
    mix.sourceMaps();
}

// Versioning untuk production
if (mix.inProduction()) {
    mix.version();
}
