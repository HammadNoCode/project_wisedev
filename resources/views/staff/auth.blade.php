<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Staff Login | Cavalry Healthcare</title>
	<meta name="author" content="pixelcave">
	<meta name="robots" content="noindex, nofollow">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Icons -->
	<link rel="shortcut icon" href="/media/favicon.png">
	<!-- Fonts and Styles -->
	<link rel="stylesheet" id="css-main" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
	<link rel="stylesheet" id="css-theme" href="{{ mix('css/dashmix.css') }}">

	<!-- Scripts -->
	<script>
		window.Laravel = {
			!!json_encode(['csrfToken' => csrf_token()]) !!
		};
	</script>
</head>

<body>
	<div id="app">
		<main id="main-container">
			<div class="bg-primary" style="background-size: cover; background-position: right;">
				<div class="row no-gutters bg-primary-op">
					<div class="hero-static col-md-6 d-flex align-items-center bg-white">
						<router-view></router-view>
					</div>
					<div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
						<img class="image" src="images/Logo-Roundal.svg" alt="Cavalrycare logo" width="40%" />
					</div>
				</div>
			</div>
		</main>
	</div>
	<script src="{{ mix('js/dashmix.app.js') }}"></script>
	<script src="{{ mix('js/staff/auth.app.js') }}"></script>
</body>

</html>