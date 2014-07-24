<?php

class Employee extends Eloquent
{
	protected $table = 'employees';

	public function group()
	{
		return $this->belongsTo('Group','group_id');
	}
	
	public function employee_portal()
	{
		return $this->hasOne('EmployeePortal','employee_portal_id')
	}
	
	public function expertise()
	{
		return $this->belongsToMany('Expertise','employee_expertise','employee_id','expertise_id');
	}

	public function position()
	{
		return $this->hasOne('Position','position_id');
	}

	public function supervisor()
	{
		return $this->belongsTo('Supervisor','supervisor_id','id');
	}
}



