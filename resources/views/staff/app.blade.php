<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Staff Portal | Cavalry Healthcare</title>
	<meta name="author" content="pixelcave">
	<meta name="robots" content="noindex, nofollow">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Icons -->
	<link rel="shortcut icon" href="media/favicon.png">
	<!-- Fonts and Styles -->
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
	<link rel="stylesheet" id="css-main" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
	<link rel="stylesheet" id="css-theme" href="{{ asset('css/dashmix.css') }}">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-87TFRJ32V2"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'G-87TFRJ32V2');
	</script>

	<!-- <iframe width=“300” height=“500" allow=“microphone” src=“https://ringcentral.github.io/ringcentral-embeddable/app.html”></iframe> -->
</head>

<body>
	<div id="app">
		<div id="page-container" class="sidebar-o enable-page-overlay page-header-fixed page-header-dark main-content-narrow">
			<div v-if="$store.state.user">
				<sidebar></sidebar>
			</div>
			<div v-if="$store.state.user">
				<navbar></navbar>
			</div>
			<main id="main-container">
				<router-view></router-view>
			</main>
		</div>
	</div>
	<script src="{{ mix('js/staff/app.app.js') }}"></script>
	<script src="{{ mix('js/dashmix.app.js') }}"></script>
    <script src="https://unpkg.com/vue-select@latest"></script>
    <script src="{{ asset('js/dashmix.app/select2.full.min.js') }}"></script>




</body>

</html>
