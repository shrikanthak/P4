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
		<td><a id={{'positionedit'.$position->id}} href="#" >Edit</a></td>
		<td><a id={{'positiondelete'.$position->id}} href="#" >Delete</a></td>
	</tr>
	@endforeach
</table>