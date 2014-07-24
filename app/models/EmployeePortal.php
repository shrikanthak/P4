<?php

class EmployeePortal extends Eloquent
{
	protected $table='employee_portals';
	public function employee()
	{
		return $this->belongsTo('Employee','employee_portal_id');

	}

		
}