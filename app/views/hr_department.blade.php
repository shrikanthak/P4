<table class="table table-hover hrtable" id='department_table'>

	<tr>
		<th>Department Code</th><th>Department Name</th><th>Department Head Position</th>
		<th></th> <th></th>
	</tr>
	@foreach($departments as $department)
		@include('department_table_row',array('department'=>$department))
	@endforeach
</table>



<div class="row formmargin">
	<div class="col-xs-12">
		{{Form::button('Add Department',array('class'=>'form-control formmargin','id'=>'add_department'))}}
	</div>
</div>

{{Form::open(array('url'=>'hr/department/save','method'=>'POST','id'=>'edit_department_form'))}}
	<div class="row formmargin" id='divEditDepartment' style="display:none">
		<div class='col-xs-3'>
			{{Form::label('department_code','Department Code')}}
			{{Form::text('department_code','',array('class'=>'form-control'))}}
		</div>
		<div class='col-xs-5'>
			{{Form::label('department_name','Department Name')}}
			{{Form::text('department_name','',array('class'=>'form-control'))}}
		</div>
		<div class='col-xs-4'>
			{{Form::label('supervisor_position','')}}
			{{Form::select('supervisor_position',array(' '),null,array('class'=>'form-control'))}}
		</div>
		{{Form::button('Save',array('class'=>'btn btn-lg btn-info formmargin','id'=>'save_department'))}}
		
	</div>
	
{{Form::close()}}