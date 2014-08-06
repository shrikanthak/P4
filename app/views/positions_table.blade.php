<table class="table table-hover", id="position">

	<tr>
		<th>ID</th><th>Title</th><th>Reports To</th><th>HR Access</th><th>Status</th>
		<th>Employee</th> <th></th><th></th>
	</tr>
	@foreach($positions as $position)
		<tr>
			<td id={{'positionid'.$position->id}}>{{$position->id}}</td>
			<td id={{'positiontitle'.$position->id}}>{{$position->title}}</td>
			<td id={{'positionsupervisor'.$position->id}}>{{(!!$position->supervisor_position)? 
						$position->supervisor_position->department->code.'-'.$position->supervisor_position->id.": ".
						$position->supervisor_position->title:''}}
			<td id={{'positionhraccess'.$position->id}}>{{($position->hr_access)?'Allowed':'Not Allowed'}}</td>
			<td id={{'positionstatus'.$position->id}}>{{($position->open)?'Open':'Filled'}}</td>
			<td id={{'positionemployee'.$position->id}}>{{((!$position->open) && (!!$position->employee))? $position->employee->login.' ('.$position->employee->first_name
				.' '.$position->employee->last_name.')':''}}</td>
			<td><a id={{'positionedit'.$position->id}} href="javascript:void(0)" >Edit</a></td>
			
			<td>
				{{ Form::open(['method' => 'POST','id'=>'positiondelete'.$position->id]) }}
					<input type='hidden' name='_delete_position_id' value={{$position->id}}>
	    			<a style='color:red' id={{'positiondelete'.$position->id}} href='javascript:void(0)'>Delete</a>
				{{ Form::close() }} </a>

			</td>
		</tr>
	@endforeach
</table>