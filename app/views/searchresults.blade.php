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


		

			
		foreach($employees as $employee)
		{
			$data=EmployeePortalController::GetEmployeeViewData($employee->id);
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
								$i=0;
								$expertise_string='';
								$expertise_coll=$employee->expertise;
								foreach($expertise_coll as $area)
								{	
									$pos=strpos($area->description,strtoupper($searchString));
									
									if(!($pos===false))
									{
										if ($i==0)
										{
											$expertise_string='<h4>Expertise: '.$area->description;
											$i++;
										}
										else
										{
											$expertise_string.=', '.$area->description;
										}
									}
								}
								
								if($expertise_string!='')
								{
									echo $expertise_string."</h4>";
								}

							echo'</div>';

						echo'</div>';

				echo'</div>';
			echo'</div>';
		}
		

	?>
		


@stop