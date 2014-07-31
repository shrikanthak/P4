<?php

class Department extends Eloquent
{
	protected $table='departments';
	protected $fillable = array('name','code');

	public function positions()
	{
		return $this->hasMany('Positions','department_id');
	}

	public static function getIdNamePair() {

		$departments=array();

		$collection = Department::all();	

		foreach($collection as $department) {
			$departments[$department->id] = $department->name;
		}	

		return $departments;	
	}
	public function employees()
	{
		return $this->hasManyThrough('Employee','Position','department_id','position_id');
	}
}
