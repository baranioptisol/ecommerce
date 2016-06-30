<!DOCTYPE html>
	<html>
	<head>
		<!-- BEGIN META SECTION -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <!-- END META SECTION -->
    	<title>E-COMMERCE </title>
    	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/img/favicon.ico')}}">
    	@include('partials.styles')	
	</head>		
	<body class="{{ (Request::is('login') ||  Request::is('/')  || Request::is('forgotpassword') || Request::is('resetpassword/*') )? 'body_bg' : '' }}" >
		@include('layout.default')		
		<div id="wrapper" >	
			@show	
				
					@section('navheader')
						@include('partials.navheader')					
				@show	
					
					@yield('content')
			</div>
		</div>	
		@include('partials.scripts')	
		@include('partials.activemenu')	
		@yield('customscript')	
	</body>
</html>