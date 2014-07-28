<?php

class Employee extends Eloquent
{
	protected $table = 'employees';

	public function department()
	{
		return $this->belongsTo('Department','department_id');
	}
	
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
		return $this->belongsTo('Position','position_id');
	}

	public function supervisor()
	{
		return $this->belongsTo('Employee','supervisor_id');
	}

	public function reportees()
	{
		return $this->hasMany('Employee','supervisor_id');
	}

}



