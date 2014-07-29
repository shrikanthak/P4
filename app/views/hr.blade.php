@extends('_master')

@section('headsection')
	{{HTML::style('css/hr_employee.css')}}
	{{HTML::style('css/employeeview.css')}}
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<script>
		var loginArray=<?php echo json_encode($loginArray); ?>;
	</script>
@stop

@section('bodycontent')
	<!--list of login iDs.-->
	
	<details>
		
		<summary>Employee Data</summary>
	

		<div class="row">
			
			<div class="col-xs-12">
				<input id="currentEmployee" onclick="employeeNewCurrent()" type="radio" name="radioGroup1" value="1">
				<label for="currentEmployee" class="RadioButtonLabels">Current Employee</label>
				<input id="newEmployee" onclick="employeeNewCurrent()" type="radio" name="radioGroup1" value="2">
				<label for="newEmployee" class="RadioButtonLabels">New Employee</label></br>
			</div>

		</div>

		<div class="row" id="divViewEmployee" style="display:none">
			<div class="col-xs-3">
				{{Form::text('search_employee','',array('class'=>'form-control pull-left','id'=>'search_employee','placeholder'=>'Search Login ID Only','list'=>'loginList'))}}
				<datalist id="loginList">
					@foreach($loginArray as $login)
						<option>{{$login}}</option>
					@endforeach
				</datalist>
			</div>
			<div class="col-xs-9">
				{{Form::button('Get Data',array('class'=>'btn btn-info pull-left controlmargin','onclick'=>'getEmployeeData()'))}}
			</div>
		</div>
		<br><br>
		<div id="divEmployeeDataView" class="container">
		</div>

		<div class="row" id="divEditEmployee" style="display:none">
			
			{{Form::open(array('url'=>'/hr','method'=>'POST', 'id'=>'frmEditEmployee'))}}
				<div class="row">
					<div class="col-xs-12">
						{{Form::label('Login_id','Login ID:',array('class'=>'controlmargin'))}}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						{{Form::label('first_name','First Name',array('class'=>'controlmargin'))}}
						{{Form::text('first_name','',array('class'=>'form-control controlmargin'))}}
					</div>
					<div class="col-xs-6">
						{{Form::label('last_name','Last Name',array('class'=>'controlmargin'))}}
						{{Form::text('last_name','',array('class'=>'form-control controlmargin'))}}
					</div>
				</div>
				<div class="row">
					
					<div class="col-xs-4">
						{{Form::label('department','Department',array('class'=>'controlmargin'))}}
						{{Form::text('department','',array('class'=>'form-control controlmargin','list'=>'department_list'))}}
						<datalist id='department_list'>
							@foreach($departments as $department)
								<option>{{$department}}</option>
							@endforeach
						</datalist>
					</div>
					
					<div class="col-xs-4">
						{{Form::label('position','Position',array('class'=>'controlmargin'))}}
						{{Form::text('position','',array('class'=>'form-control controlmargin'))}}
					</div>

					<div class="col-xs-4">
						{{Form::label('supervisor','Supervisor',array('class'=>'controlmargin'))}}
						{{Form::text('supervisor','',array('class'=>'form-control controlmargin'))}}
					</div>

				</div>
				<br>
				<div class="row">
					<div class="col-xs-1">
						<input type="submit" name="btnSaveEmployee" class="btn btn-lg btn-info pull-left controlmargin" value="Save">
					</div>
					<div class="col-xs-1">
						<input type="button" name="btnCancel" class="btn btn-lg btn-default pull-left controlmargin" value="Cancel">
					</div>
					<div class="col-xs-10">
						<input type="submit" name="btnDelete" class="btn btn-lg btn-danger pull-right controlmargin" value="DELETE!">
					</div>
				</div>

			{{Form::close()}}

		</div>
	</details><br><br>
	<details>
		<summary>Position Data</summary>
	</details><br><br>
	<details>
		<summary>Department Data</summary>
	</details>

	
@stop

@section('footercontent')
	{{HTML::script('js/hr.js')}}
@stop