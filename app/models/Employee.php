<?php

class Employee extends Eloquent
{
	protected $table = 'employees';

	
	public function employee_portal()
	{
		return $this->belongsTo('EmployeePortal','employee_portal_id');
	}
	
	public function expertise()
	{
		return $this->belongsToMany('Expertise','employee_expertise','employee_id','expertise_id');
	}

	public function position()
	{
		return $this->hasOne('Position','employee_id');
	}


	public static function GetDataArray($employee)
	{
		if($employee)
		{
			if (!!$employee->portal)
			{
				$employee=$employee->with('portal')->get();
			}
			return array("current_id"=>$employee->id,
			"first_name"=>$employee->first_name,
			"last_name"=>$employee->last_name,
			"image"=>(!!$employee->employee_portal->imagefile) ? $employee->employee_portal->imagefile:"",
			"paragraph"=>$employee->employee_portal->employee_info,
			"login"=>$employee->login);
		}
		else
		{
			return array("current_id"=>0,
			"first_name"=>'',
			"last_name"=>'',
			"image"=>"",
			"paragraph"=>'',
			"login"=>'');
		}

	}

}



