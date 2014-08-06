<?php $name= $data['first_name']." ".$data['last_name'];
$imagefile=$data['image']!=''? '/images'.'/'.$data['image']:'';
$supervisor_id=$data['supervisor_id']>0?"/employee/view/".$data['supervisor_id']:'';
$department_id=$data['department_id']!=''?'/department'.'/'.$data['department_id']:'';
$head_of_department_id=$data['head_of_department_id']!=''?'/department'.'/'.$data['head_of_department_id']:'';
?>


<div clas="row">
	
	<div class="col-xs-4">
		
		@if($imagefile!='')
			{{HTML::image($imagefile,'Your Image',array('class'=>'imageformat'))}}
		@endif
		
	</div>

	<div class="col-xs-8">
		
		<h1>{{{$name}}}</h1>
		<h3>{{{"Title: ".$data['title']}}}<br>
			
			@if($data['department']!='')
				{{{"Department: "}}} <a href=<?=$department_id?>>{{{$data['department']}}}</a></br>
			@endif

			@if($data['head_of_department'])
				{{{"Head of Department: "}}}  <a href=<?=$head_of_department_id?>>{{{$data['head_of_department']}}}</a></br>
			@endif
					
			@if($data['supervisor']!='')
				{{{"Supervisor: "}}}<a href=<?=$supervisor_id?>>{{{$data['supervisor']}}}</a></br>
			@endif
		</h3>

	</div>

</div>

@if($addEditForm)
	<div class="row">
		<div class="col-xs-6">
			<button type="button" id="edit_employee_button" class="btn btn-warning btn-lg push-left formmargin">Edit Employee</button>
		</div>
		<div class="col-xs-6">
			{{Form::open(array('id'=>'employee_delete_form'))}}
				<button type="button" id="delete_employee_button" class="btn btn-danger btn-lg pull-right formmargin">Delete Employee!</button>
				<input name="_delete_employee_id" type="hidden" value={{$data['current_id']}} id='_delete_employee_id'></input>
			{{Form::close()}}
		</div>
	</div>
	{{-- Hidden Data for Edit Form --}}
	<div style="display:none">
		<div id="_login">{{{$data['login']}}}
		</div>
		<div id="_first_name">{{{$data['first_name']}}}
		</div>
		<div id="_last_name">{{{$data['last_name']}}}
		</div>
		<div id="_emp_id">{{{$data['current_id']}}}
		</div>
	</div>

@endif