<?php

class Department extends Eloquent
{
	protected $table='departments';
	protected $fillable = array('name');

	public function grouplist()
	{
		return $this->hasMany('Group','depatment_id');
	}

}


class Group extends Eloquent
{
	protected $table='groups';
	public function department()
	{
		return $this->belongsTo('Department','department_id');
	}

	public function employee()
	{
		return $this->hasMany('Employee','group_id');
	}
}