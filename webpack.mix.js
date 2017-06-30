const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/inventory.js', 'public/js')
	.js('resources/assets/js/search.js', 'public/js')
	.js('resources/assets/js/settings.js', 'public/js')
	.js('resources/assets/js/results.js', 'public/js')
	.js('resources/assets/js/recipe.js', 'public/js')
	.js('resources/assets/js/grocery_lists.js', 'public/js')
	.js('resources/assets/js/grocery_list.js', 'public/js')
	.js('resources/assets/js/recipe_made.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
