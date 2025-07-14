const mix  =  require('laravel-mix');
const path = require('path');

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

// const __filename = fileURLToPath(import.meta.url);
// const __dirname = path.dirname(__filename);
 
mix.ts('resources/js/app.ts', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .version()
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js'),
                '#': path.resolve(__dirname, 'node_modules'),
                '&': path.resolve('public/assets')
            },
            extensions: ['.ts', '.js', '.vue', '.json']
        }
    }).disableNotifications();
