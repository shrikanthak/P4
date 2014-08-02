<?php

class Department extends Eloquent
{
	protected $table='departments';
	protected $fillable = array('name','code');

	public function positions()
	{
		return $this->hasMany('Position','department_id');
	}

	public static function getIdNamePair()
	{

		$departments=array();

		$collection = Department::all();	

		foreach($collection as $department) {
			$departments[$department->id] = $department->name;
		}	

		return $departments;	
	}

	public function department_head()
	{
		return $this->belongsTo('Position','department_head_position_id');
	}

}
