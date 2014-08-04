@extends('_master')



@section('bodycontent')
	

	<?php 
		foreach($departments as $department)
		{
			echo'<div class="panel panel-default">';
				echo'<div class="panel-body">';
					echo '<h2>Department: '.$department->name.' ('.$department->code.')</h2>';
					echo'<div class="row">';
						echo '<div class="col-xs-12">';
							echo'<h4><a href="/employee/orgchart/'.$department->department_head->employee->id.'">View Org Chart</a></h4>';
						echo '</div>';
					echo "</div>";
				echo'</div>';
			echo'</div>';

		}


		if (!is_null($employee_ids))
		{

			if(!is_array($employee_ids))
			{
				$employee_ids=array($employee_ids);
			}
			foreach($employee_ids as $empid)
			{

				$data=EmployeePortalController::GetEmployeeViewData($empid);
				echo'<div class="panel panel-default">';
					echo'<div class="panel-body">';
						echo View::make('employeebasicdataview')
							->with('data',$data)
							->with('addEditForm',false);
											
							echo'<div class="row">';
								
								echo'<div class="col-xs-2">';
									echo'<h4><a href="/employee/view/'.$data['current_id'].'">View Details</a></h4>';
								echo'</div>';
								
								echo'<div class="col-xs-2">';
									echo'<h4><a href="/employee/orgchart/'.$data['current_id'].'">View Org Chart</a></h4>';
								echo'</div>';
								
								echo'<div class="col-xs-8">';
									
								echo'</div>';

							echo'</div>';

					echo'</div>';
				echo'</div>';
			}
		}

	?>
		


@stop