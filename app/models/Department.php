<?php

class Department extends Eloquent
{
	protected $table='departments';
	protected $fillable = array('name','code');

	public function positions()
	{
		return $this->hasMany('Position','department_id');
	}


	public function department_head()
	{
		return $this->belongsTo('Position','department_head_position_id');
	}

}
