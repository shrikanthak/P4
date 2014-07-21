<!doctype html>
<html>
	<head>
		<title>Welcome to the Employee Portal!</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/master.css" rel="stylesheet">
    	<script src="js/respond.js"></script>
    	@yield('headsection')
	</head>
	
	<body>

		<div class="container masteroutline">
			
			<!--Login Section on the top-->
			<div class="row headercolor">
				<div class="col-xs-11">
				</div>
				<div class="col-xs-1">
					<!-- If user not logged in display log in menu option-->
					<!--Else display link to employee home page-->
					@if(!Session::has('logged_in'))
						<a href="/login" class="loginmenu">Login</a>
					@else
						
					@endif
				</div>
			</div>
			
			<!--Header Section-->
			<div class="row headercolor">
				<image src="images/logo.png"/>
			</div>
			
			<!--Navigation bar section-->
			<div class="row navbarcolor">
				{{Form::open(array('url'=>'/search','method'=>'GET'))}}
				<!--form method='POST' action='/search'-->
					<div class="col-xs-8"></div>
					<div class="col-xs-3">	
						<input type="text" name="txtSearch" class="form-control" placeholder="Name, Email ID or Department">
					</div>
					<div class="col-xs-1">
						<input type="submit" name="btnSubmitSearch" class="btn btn-success" value="Search">
					</div>
				{{Form::close()}}
				<!--/form-->
			</div>
			
			<!--CUstom content different for each page-->
			@yield('bodycontent')

		</div>
		
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>

	</body>

</html>