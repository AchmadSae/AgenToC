const mix = require('laravel-mix');
const path = require('path');

// Configure webpack to resolve @ as resources/js
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources')
        }
    }
});

// Compile SCSS
mix.sass('resources/sass/style.scss', 'public/assets/css')
   .options({
      processCssUrls: false,
      postCss: [
         require('autoprefixer')
      ],
      sassOptions: {
         quietDeps: true,
         includePaths: [
            'node_modules',
            'resources/sass'
         ]
      }
   });

// // Copy file statis Please uncomment to compile the assets
// mix.copyDirectory("_keenthemes/src/js/custom", "public/assets/js/custom");
// mix.copy("_keenthemes/src/js/**/*.js", "public/assets/js");
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
