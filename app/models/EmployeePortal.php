<?php

class EmployeePortal extends Eloquent
{
	protected $table='employee_portals';
	
	public function employee()
	{
		return $this->hasOne('Employee','employee_portal_id');

	}
	
}