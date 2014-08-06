<?php


class PositionsController extends BaseController
{
	private function formatOutputData($positions,$outputformat)
	{
		if($outputformat=='array')
		{
			$posarray=array(array('id'=>'0','description'=>'------------None---------------'));
			foreach($positions as $position)
			{
				$posarray[]=array('id'=>$position->id,'description'=>$position->department->code.'-'.$position->id.": ".$position->title);
			}
			return json_encode($posarray);
		}
		elseif($outputformat=='table')
		{
			return View::make('positions_table')->with('positions',$positions);
		}
	}

	private function getPositionsCollection($depid,$positionstatus)
	{
		//get the corporate head department id
		$positions=array();
		if($depid==0)
		{
			$corp_departments=Department::where('corporate_head','=',true)->get();
		
			$i=1;
			foreach($corp_departments as $corp_department)
			{
				if ($i==1)
				{
					$positions=Position::with('employee','supervisor_position','department')
							->where('department_id','=',$corp_department->id)->get();
				}
				else
				{
					$positions=$positions->merge(Position::with('employee','supervisor_position','department')
								->where('department_id','=',$corp_department->id)->get());
				}
				
			}
	
		}
		else
		{
			//get all the regular positions
			$positions=Position::with('employee','supervisor_position','department')
							->where('department_id','=',$depid)->get();
		}

		if($positionstatus==0)		//filter all closed positions
		{
			 $positions = $positions->filter(function($position)
			    {
			        return (!$position->open);
    			});
			
		}
		elseif($positionstatus==1) //filter all open positions
		{
				$positions = $positions->filter(function($position)
			    {
			        return $position->open;
    			});
		}

		return $positions;
	}


	public function getPositionsTable($depid,$positionstatus)
	{
		return $this->formatOutputData($this->getPositionsCollection($depid,$positionstatus)
								,'table');
	}

	public function getSupervisorPositionsList($depid,$currentpos)
	{
		//get all positions
		$positioncollection=$this->getPositionsCollection($depid,3);
		
		if($depid>0)
		{
			$department=Department::with('department_head')->find($depid);
			if(!!$department->department_head)
			{
				$positioncollection=$positioncollection->
				merge(Position::with('employee','supervisor_position','department')
					->where('id','=',$department->department_head->id)->get());
			}
		}
		if($currentpos!=0)
		{
			$position=Position::with('reportee_positions')
			->find($currentpos);
			$this->remove_Self_Reportees($positioncollection,$position);
		}

		return $this->formatOutputData($positioncollection,'array');
		
	}

	private function remove_Self_Reportees(&$positioncollection,$position)
	{
		PositionsController::$_posid=$position->id;
		$positioncollection=$positioncollection->filter(function($pos)
			{
				return $pos->id != PositionsController::$_posid;
			});
		$reportees=$position->reportee_positions()->get();
		foreach($reportees as $reportee)
		{
			
			$this->remove_Self_Reportees($positioncollection,$reportee);	
		}
	}

	public function savePosition()
	{
		$position=Position::find(Input::get('_position_id'));
		if(!$position)
		{
			$position=new Position();
		}
		if($position)
		{
			$position->hr_access=Input::get('_hr_access');
			$position->title=strtoupper(Input::get('position_title'));
			
			if(Input::get('supervisor_position')>0)
			{
				$position->supervisor_position_id=Input::get('supervisor_position');
			}
			
			if (Input::get('employee_for_position')>0)
			{
				$position->employee_id=Input::get('employee_for_position');
				$position->open=false;
			}
			
			if(Input::get('_department_id')>0)
			{
				$position->department_id=Input::get('_department_id');
			}
			
			$position->save();
		}
		return "success";
	}

	public function deletePosition()
	{
		$posid=Input::get('_delete_position_id');
		if ($posid>0)
		{
			$position=Position::with('reportee_positions')->find($posid);
			if (count($position->reportee_positions)>0)
			{
				return "Error: Cannot Delete Position. It has reportees.";
			}
			else
			{
				$position->delete();
				return "success";
			}

		}
		else
		{
			return "Error: Position not found in database.";
		}
	}

	private static $_posid=0;
}