<?php

class Supervisor extends Eloquent
{
	protected $table='employees';
	
	public function reportee()
	{
		return $this->hasMany('Employee','supervisor_id','id');
	}
}