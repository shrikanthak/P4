@extends('_master')



@section('bodycontent')

	<?php foreach($employees as $employee)
			{

				$data=$employee->get_data();
				echo'<div class="panel panel-default">';
					echo'<div class="panel-body">';
						echo View::make('employeebasicdataview')
							->with('data',$data)
							->with('addEditForm',false);
						
						echo'<div class"row">';
							
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
	?>
		


@stop