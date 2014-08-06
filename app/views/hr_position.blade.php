<div class="row formmargin">
	
	<div class="col-xs-3">
		<div class='form-group'>
			{{ Form::label('position_department', 'Department') }}
			{{ Form::select('position_department', $departments_list,null,array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="col-xs-9">
		<div class='form-group'>
			<label for="radioGroup2">Positions</label><br>
			<input id="openRadioPositions" type="radio" name="position_status" value="1" checked='true'>
			<label for="openRadioPositions" class="RadioButtonLabels" class='form'>Open</label>
			<input id="filledRadioPositions" type="radio" name="position_status" value="0">
			<label for="filledRadioPositions" class="RadioButtonLabels">Filled</label>
			<input id="allRadioPositions" type="radio" name="position_status" value="3">
			<label for="allRadioPositions" class="RadioButtonLabels">All</label>
		</div>
	</div>

</div>

<div class= "row formmargin" style="display:none" id="divPositions">
	<div class="col-xs-12" id="positions_table_data">
		
	</div>
	<input type="button" name="new_position" id='new_position' class="btn btn-lg btn-info pull-left formmargin" value="New Position">
</div>

{{Form::open(array('url' => '/position/edit', 'method' => 'POST','id'=>'position_form'))}}
	<div class="row formmargin" id="divEditPosition" style="display:none">

		<div class="col-xs-3">
			{{Form::label('position_title','Position')}}
			{{Form::text('position_title','',array('class'=>'form-control'))}}
		</div>
		<div class="col-xs-3">
			{{Form::label('supervisor_position','Reports To')}}
			{{Form::select('supervisor_position',array(' '),null,array('class'=>'form-control'))}}
		</div>
		<div class="col-xs-4">
			{{Form::label('employee_for_position','Employee')}}
			{{Form::select('employee_for_position',array(' '),null,array('class'=>'form-control'))}}
		</div>
		<div class="col-xs-2">
			{{Form::label('hr_access','HR Page Access')}}
			{{ Form::checkbox('hr_access', '0', false,array('class'=>'form-control push-left')) }}
		</div>
		<div class="col-xs-2">
			{{ Form::Submit('Save Position',array('class'=>'btn btn-lg btn-info', 'id'=>'save_position')) }}
		</div>
		<div class="col-xs-2">
			{{ Form::button('Cancel',array('class'=>'btn btn-lg', 'id'=>'cancel_position_save')) }}
		</div>
		{{Form::hidden('_position_id','',array('id'=>'_position_id'))}}
		{{Form::hidden('_department_id',1,array('id'=>'_department_id'))}}
		{{Form::hidden('_hr_access','',array('id'=>'_hr_access'))}}
	</div>
{{Form::close()}}