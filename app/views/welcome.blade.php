@extends('_master')

@section('headsection')
	<link href="css/welcome.css" rel="stylesheet">
@stop

@section('bodycontent')

<section class="sectionformat">
	<h1>Welcome to the Employee Portal</h1>
	<h2>Find informtion about your colleagues and the org chart on this page<h2>
		
		<ul>
			<li>Login in onto the web page and select the {{{"Your Portal"}}} link to change your info</li>
			
		</ul>

</section>

<!--div class="asideformat">
	<h1><center>Todays News</center></h1>
	<iframe src="http://www.google.com/uds/modules/elements/newsshow/iframe.html?format=300x250"
        frameborder="0" width="300" height="250"
        marginwidth="0" marginheight="0">
	</iframe>
</div-->

@stop