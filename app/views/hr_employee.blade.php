<div class="row">
	
	<div class="col-xs-12">
		<input id="currentEmployee" onclick="itemNewCurrent('Employee')" type="radio" name="radioGroup1" value="1">
		<label for="currentEmployee" class="RadioButtonLabels">Current Employee</label>
		<input id="newEmployee" onclick="itemNewCurrent('Employee')" type="radio" name="radioGroup1" value="2">
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
<br>
<div id="divEmployeeDataView" class="container">
</div>

<div id="divEditEmployee" style="display:none">
	
	{{Form::open(array('url'=>'/hr','method'=>'POST', 'id'=>'frmEditEmployee'))}}
		<div class="row formmargin">
			<div class="col-xs-12">
				{{Form::label('Login_id','Login ID:')}}
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

		</div>
		
		<div class="row formmargin">
			
			<div class="col-xs-3">
				{{Form::label('employee_department','Department')}}
				{{Form::select('employee_department',$departments, null ,
				array('class'=>'form-control'))}}
			</div>
			
			<div class="col-xs-5">
				{{Form::label('employee_position','Position')}}
				{{Form::select('employee_position',array(' '),null,array('class'=>'form-control'))}}
			</div>

			<div class="col-xs-4">
				{{Form::label('employee_supervisor','Supervisor')}}
				{{Form::select('employee_supervisor',array(' '),null,array('class'=>'form-control'))}}
			</div>

		</div>

		<br>

		<div class="row formmargin">
			<div class="col-xs-1">
				<input type="submit" name="btnSaveEmployee" class="btn btn-lg btn-info pull-left" value="Save">
			</div>
			<div class="col-xs-1">
				<input type="button" name="btnCancel" class="btn btn-lg btn-default pull-left" value="Cancel">
			</div>
			<div class="col-xs-10">
				<input type="submit" name="btnDelete" class="btn btn-lg btn-danger pull-right" value="DELETE!">
			</div>
		</div>

	{{Form::close()}}

</div>