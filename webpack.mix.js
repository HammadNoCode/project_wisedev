const mix = require('laravel-mix');

mix
	.sass('resources/assets/sass/dashmix.scss', 'public/css')
	.sass('resources/assets/sass/bootstrap/bootstrap.scss', 'public/css')
	.js('resources/assets/js/dashmix/app.js', 'public/js/dashmix.app.js')
	.js('resources/assets/js/staff/app/app.js', 'public/js/staff/app.app.js').vue()
	.js('resources/assets/js/staff/auth/app.js', 'public/js/staff/auth.app.js').vue()
	.options({
		processCssUrls: false
	})
	.webpackConfig({
		module: {
			rules: [{
				test: /\.pug$/,
				loader: 'pug-plain-loader'
			}]
		}
	})
	.version();