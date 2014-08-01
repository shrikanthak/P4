@extends('_master')

@section('headsection')
	{{HTML::style('css/hr.css')}}
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<script>
		var loginArray=<?php echo json_encode($loginArray); ?>;
	</script>
@stop

@section('bodycontent')
	<!--list of login iDs.-->
	<br>
	<details>
		
		<summary>Employee Data</summary>
		
		<br>
		
		@include('hr_employee')
		
	</details><br><br>
	<details>
		<summary>Position Data</summary>
	</details><br><br>
	<details>
		<summary>Department Data</summary>
	</details>

	
@stop

@section('footercontent')
	{{HTML::script('js/hr_employee.js')}}
@stop