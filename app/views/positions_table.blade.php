<table class="table table-hover", id="position">

	<tr>
		<th>ID</th><th>Title</th><th>Reports To<th><th>Status</th><th>Employee</th>
		<th></th> <th></th>
	</tr>
	@foreach($positions as $position)
	<tr>
		<td id={{'positionid'.$position->id}}>{{$position->id}}</td>
		<td id={{'positiontitle'.$position->id}}>{{$position->title}}</td>
		<td id={{'positionsupervisor'.$position->id}}>{{(!!$position->supervisor_position)? $position->supervisor_position->title:''}}
		<td id={{'positionhraccess'.$position->id}}>{{($position->open)?'open':'closed'}}</td>
		<td id={{'positionemployee'.$position->id}}>{{((!$position->open) && (!!$position->employee))? $position->employee->first_name.' '.$position->employee->last_name:''}}</td>
		<td><a id={{'positionedit'.$position->id}} href="#">Edit</a></td>
		<td><a id={{'positiondelete'.$position->id}} href="#">Delete</a></td>
	</tr>
	@endforeach
</table>