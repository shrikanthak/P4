<?php

class Expertise extends Eloquent
{
	protected $table='expertise';
	
	protected $fillable=array('description');
	
	public function employee()
	{
		return $this->belongsToMany('Employee','employee_expertise','employee_id','expertise_id');
	}

}