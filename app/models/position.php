<?php

class Position extends Eloquent
{
	protected $table='positions';
	
	public function employee()
	{
		return $this->hasOne('Employee','position_id');

	}

	public function department()
	{
		return $this->belongsTo('Department','department_id');

	}
}