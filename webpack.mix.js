let mix = require('laravel-mix');

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
	.js('resources/assets/js/axios.js', 'public/js')
	.copy('resources/assets/js/agent.js', 'public/js')
	.copy('resources/assets/js/outbound.js', 'public/js')
	.copy('resources/assets/js/blended.js', 'public/js')
	.copy('resources/assets/js/supervisor.js', 'public/js')
	.copy('resources/assets/js/agent-table.js', 'public/js')
	.copy('resources/assets/js/dialpad.js', 'public/js')
	.copy('resources/assets/js/typeahead.bundle.js', 'public/js')
	.copy('resources/assets/js/handlebars.js', 'public/js')
	.copy('resources/assets/js/sip-init.js', 'public/js')
    .copy('resources/assets/js/transfer.js', 'public/js')
	.copy('resources/assets/js/outbound.history.js', 'public/js');
   // .sass('resources/assets/sass/app.scss', 'public/css');
