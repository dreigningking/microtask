<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Wonegig">
	<meta name="author" content="Wonegig">

	<title>Wonegig - @yield('title')</title>
	<link href="{{ asset('backend/css/modern.css') }}" rel="stylesheet">
	@stack('styles')
</head>

<body>
	<div class="splash active">
		<div class="splash-icon"></div>
	</div>

	@yield('content')
	
	<script src="{{asset('backend/js/app.js')}}"></script>
	@stack('scripts')

</body>
</html>