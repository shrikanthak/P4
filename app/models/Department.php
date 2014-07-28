<?php

class Department extends Eloquent
{
	protected $table='departments';
	protected $fillable = array('name');

	public function employees()
	{
		return $this->hasMany('Employee','depatment_id');
	}

}
