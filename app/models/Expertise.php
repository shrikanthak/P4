<?php

class Expertise extends Eloquent
{
	$table='expertise';
	public function employee()
	{
		return $this->belongsToMany('Employee','employee_expertise','employee_id','expertise_id');
	}

}