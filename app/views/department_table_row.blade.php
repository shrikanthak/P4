
	<tr>
		<td id={{'departmentcode'.$department->id}}>{{$department->code}}</td>
		<td id={{'departmentname'.$department->id}}>{{$department->name}}</td>
		<td id={{'departmenthead'.$department->id}}>{{(!!$department->department_head)?
									$department->code.'-'.
									$department->department_head->id.': '
									.$department->department_head->title:''}}</td>
		<td><a id={{'departmentedit'.$department->id}} href="#">Edit</a></td>
		<td><a id={{'departmentdelete'.$department->id}} href="#">Delete</a></td>
	</tr>
