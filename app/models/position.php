<?php

class Position extends Eloquent
{
	protected $table='positions';
	
	public function employee()
	{
		return $this->belongsTo('Employee','employee_id');

	}

	public function department()
	{
		return $this->belongsTo('Department','department_id');
	}

	public function supervisor_position()
	{
		return $this->belongsTo('Position','supervisor_position_id');
	}

	public function reportee_positions()
	{
		return $this->hasMany('Position','supervisor_position_id');
	}

	public function department_head_of()
	{
		return $this->hasOne('Department','department_head_position_id');
	}

	public static function GetDataArray($position)
	{
		
		if($position)
		{
			return array("title"=>$position->title,
			"department"=>(!!$position->department) ? $position->department->name:'',
			"department_id"=>(!!$position->department) ? $position->department->id:0,
			"supervisor"=>(!!$position->supervisor_position) && (!!$position->supervisor_position->employee)? 
							$position->supervisor_position->employee->first_name." "
							.$position->supervisor_position->employee->last_name:'',
			"supervisor_id"=>(!!$position->supervisor_position) && (!!$position->supervisor_position->employee)?
								$position->supervisor_position->employee->id:0,
			"position_id"=>$position->id,
			"head_of_department"=>(!!$position->department_head_of) ? $position->department_head_of->name:'',
			"head_of_department_id"=>(!!$position->department_head_of) ? $position->department_head_of->id:'');

		}
		else
		{
			return array("title"=>'',
			"department"=>'',
			"department_id"=>0,
			"supervisor"=>'',
			"supervisor_id"=>0,
			"position_id"=>0,
			"head_of_department"=>'',
			"head_of_department_id"=>0);
		}
	}
}