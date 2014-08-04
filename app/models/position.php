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
}