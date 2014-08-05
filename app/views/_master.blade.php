<!doctype html>
<html>
<head>

	<title>@yield('title','Task Manager')</title>

	<link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/flatly/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="styles/styles.css" type="text/css">

	@yield('head')

</head>

<body>

	<a href='/'><img class='logo' src='<?php echo URL::asset('/images/softwarebanner.jpg'); ?>' alt='Software Banner'></a>

		@if(Auth::check())
			<a href='/logout'>Log out</a>
		@else
			<a href='/signup'>Sign up</a> or <a href='/login'>Log in</a>
		@endif

	@yield('content')

	@yield('body')

</body>

</html>
