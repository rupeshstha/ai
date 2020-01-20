<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Nugah Admin Panel - Bikram Lama</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">

	<!-- Styles -->
	<style>
		body,html{background-color:#fff;color:#636b6f;font-family:"Open Sans",sans-serif;font-weight:300;height:100vh;margin:0}.full-height{height:100vh}.flex-center{align-items:center;display:flex;justify-content:center}.position-ref{position:relative}.top-right{position:absolute;right:10px;top:18px}.content{text-align:center}.title{font-size:84px}.links>a{color:#636b6f;padding:0 25px;font-size:13px;font-weight:600;letter-spacing:.1rem;text-decoration:none;text-transform:uppercase}.m-b-md{margin-bottom:30px}
	</style>
</head>
<body>
	<div class="flex-center position-ref full-height">
		<div class="content">
			<div class="title m-b-md">
				Nugah Admin Panel
			</div>

			<div class="links">
				<a href="https://voyager-docs.devdojo.com/" target="_blank">Docs</a>
				<a href="{{ route('voyager.login') }}">Admin Login</a>
				<a href="https://bikramlama.com.np" target="_blank">Creator</a>
			</div>
		</div>
	</div>
</body>
</html>
