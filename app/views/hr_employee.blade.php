<!-- **************HR employee form************* -->

<!-- *******************Radio Buttons for Current and New Employees*************************** -->
<div class="row">
	<!-- Ne and current employee buttons-->
	<div class="col-xs-12">
		<input id="currentEmployee" onclick="itemNewCurrent('current')" type="radio" name="radioGroup1" value="1">
		<label for="currentEmployee" class="RadioButtonLabels">Current Employee</label>
		<input id="newEmployee" onclick="itemNewCurrent('new')" type="radio" name="radioGroup1" value="2">
		<label for="newEmployee" class="RadioButtonLabels">New Employee</label></br>
	</div>

</div>

<!-- *******************Form section to search for an employee*************************** -->
<div class="row" id="divSearchEmployee" style="display:none">
	<div class="col-xs-3">
		{{Form::text('search_employee','',array('class'=>'form-control pull-left','id'=>'search_employee','placeholder'=>'Search Login ID Only','list'=>'loginList'))}}
		<datalist id="loginList">
			@foreach($loginArray as $login)
				<option>{{$login}}</option>
			@endforeach
		</datalist>
	</div>
	<div class="col-xs-9">
		{{Form::button('Get Data',array('class'=>'btn btn-info pull-left controlmargin','id'=>'get_data'))}}
	</div>
</div>
<br>

<!-- This data is filled in by ajax request-->
<div id="divError" class="container">


</div>

<!-- *******************Employee Error Data*************************** -->
<!-- This data is filled in by ajax request-->
<div id="divViewEmployee" class="container">
	
</div>

<!-- *******************Employee Data Edit Form*************************** -->
<div id="divEditEmployee" style="display:none">
	
	{{Form::open(array('url'=>'/hr','method'=>'POST', 'id'=>'edit_employee_form'))}}
		<div class="row formmargin">
			<div class="col-xs-12">
				{{Form::label('Login_id','Login ID:',array('id'=>'Login_id'))}}
			</div>
		</div>
		
		<div class="row formmargin">
			
			<div class="col-xs-6">
				{{Form::label('first_name','First Name')}}
				{{Form::text('first_name','',array('class'=>'form-control'))}}
			</div>
			
			<div class="col-xs-6">
				{{Form::label('last_name','Last Name')}}
				{{Form::text('last_name','',array('class'=>'form-control'))}}
			</div>

			<input name="_employee_id" type="hidden" value="0" id='_employee_id'></input>

		</div>
		
		<br>

		<div class="row formmargin">
			<div class="col-xs-1">
				<input type="button" name="save" id="save" class="btn btn-lg btn-info pull-left" value="Save">
			</div>
			<div class="col-xs-1">
				<input type="button" name="cancel" id="cancel" class="btn btn-lg btn-default pull-left" value="Cancel">
			</div>
			<div class="col-xs-10">
			</div>
		</div>

	{{Form::close()}}

</div>