@extends('_master')

@section('headsection')
	<script src="js/hr_employee.js"></script>
@stop

@section('bodycontent')
	<!--list of login iDs.-->
	<script>var loginArray=JSON.parse({{$loginArray;}})</script>

	<div class="row">
		<div class="col-xs-6">
			<!-- Form to either search for existing employee. Data is submitted after checking for user id-->
			<!-- This is done using jquery and javascript-->
			{{Form::open(array('url'=>'/search','method'=>'GET','id'=>'frmViewEmployee'))}}
				{{Form::label('txtLoginID','Search by Login ID',array('class'=>'form-control floatleft'))}}
				{{Form::text('txtLoginID','',array('class'=>'form-control floatleft','id'=>'txtLoginID'))}}
				<input type="submit" name="btnViewEmployee" class="btn btn-info floatleft" value="View Details">
			{{Form::close()}}

		</div>

		<!-- New employee. Simply expose the div for edit employee-->
		<div class="col-xs-6">
			<button type="button" class="btn btn-primary floatcenter" onclick="employeeAddEdit()">New Employee</button>
		</div>

	</div>

	<div class="row" id="divView display:none">
		<!--view the employee data-->
		@include('employeebasicdataview')

	</div>

	<div class="row" id="divEdit display:none">
		
		{{Form::open(array('url'=>'/hr','method'=>'POST', 'id'=>'frmEditEmployee'))}}

			<div class="row">
				<div class="col-xs-1">
					<input type="submit" name="btnSaveEmployee" class="btn btn-lg btn-info floatleft" value="Save">
				</div>
				<div class="col-xs-1">
					<input type="submit" name="btnCancel" class="btn btn-lg btn-default floatleft" value="Cancel">
				</div>
				<div class="col-xs-10">
					<input type="submit" name="btnDelete" class="btn btn-lg btn-danger floatright" value="DELETE!">
				</div>
			</div>

		{{Form::close()}}

	</div>

	<script src="js/hr_employee_jquery.js"></script>
@stop