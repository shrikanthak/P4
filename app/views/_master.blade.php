<!doctype html>
<html>
	<head>
		
		<title>Welcome to the Employee Portal!</title>
		<!--link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/master.css" rel="stylesheet">
	   	<script src="js/respond.js"></script-->

	   	{{ HTML::style('css/master.css'); }}
		{{ HTML::style('css/bootstrap.min.css'); }}
		{{ HTML::script('js/respond.js'); }}

    	@yield('headsection')

	</head>
	
	<body>

		<div class="container masteroutline">

			@if(Session::get('flash_message'))
				<div class='flash-message'>{{ Session::get('flash_message') }}</div>
			@endif
			
			<!--Login Section on the top-->
			<div class="row headercolor">
				
				<div class="col-xs-6 pull-left">
					@if(Auth::check())
						<h2>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</h2>
					@endif
				</div>

				<div class="col-xs-6 pull-right">
					<ul class="nav nav-pills navbar-right">
						<li><a class="menufont" href="/">Home</a></li>
						<!-- If user not logged in display log in menu option-->
						@if(Auth::check())
							<!--Else display link to employee home page-->		
							<li><a class="menufont" href="/employee/view/<?=Auth::user()->id?>">Your Info</a></li>
							
							<!-- If hr person display menu for HR page-->
							@if(Session::has('view_hr_tab'))
								<li><a class="menufont" href="/hr_page">Login</a></li>
							@endif

							<li><a class="menufont" href="/logout">Log Out</a></li>
						
						@else
							
							<li><a class="menufont" href="/login">Login</a></li>
						
						@endif
					</ul>
				</div>
			</div>
			
			<!--Header Section-->
			<div class="row headercolor">
				{{HTML::image('./images/logo.png', 'Employee Page Logo');}}
				<!--image src="images/logo.png"/-->
			</div>
			
			<!--Navigation bar section form-->
			<div class="row navbarcolor">
				{{Form::open(array('url'=>'/search','method'=>'GET'))}}
				<!--form method='POST' action='/search'-->
					<div class="col-xs-8"></div>
					<div class="col-xs-3">	
						<input type="text" name="txtSearch" class="form-control searchform" placeholder="Name, Login ID or Department">
					</div>
					<div class="col-xs-1">
						<input type="submit" name="btnSubmitSearch" class="btn btn-info searchform" value="Search">
					</div>
				{{Form::close()}}
				<!--/form-->
			</div>
			
			<!--CUstom content different for each page-->
			@yield('bodycontent')

		</div>
		@yield('footercontent')
		
		{{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');}}
		{{ HTML::script('js/bootstrap.min.js'); }}

	</body>

</html>